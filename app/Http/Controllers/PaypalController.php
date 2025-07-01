<?php

namespace App\Http\Controllers;

use Exception;
use App\Enums\Role;
use App\Models\User;
use App\Models\Event;
use App\Models\EventBooking;
use App\Mail\Booking;
use App\Mail\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\UserNotification;
use App\Notifications\EventBookingNotification;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    /**
     * Display the PayPal payment view.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $checkoutData = json_decode($request->checkout_user_data, true);
        $slots = $checkoutData['slots'];
        $total = $checkoutData['grand_total'];
        // dd($checkoutData, $request->all());
        $emailExists = User::where('email', $request->email)->exists();
        if (!$emailExists) {
            try {
                $username = strstr($request->email, '@', true);
                $password = Str::random(7)
                    . collect(['!', '@', '#', '$', '%', '^', '&', '*'])->random(1)
                        ->join('');
                $user = new User();
                $user->fname = $request->fname;
                $user->lname = $request->lname;
                $user->username = $username;
                $user->email = $request->email;
                $user->password = Hash::make($password);
                $user->role = 'user';
                $user->save();
                $notUsers = User::where('id', '!=', $user->id)->get();
                foreach ($notUsers as $notUser) {
                    $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile];
                    $notUser->notify(new UserNotification("A new user {$user->full_name} has been joined", $object));
                }
                $verificationUrl = URL::temporarySignedRoute(
                    'verification.verify', // The name of the route
                    Carbon::now()->addMinutes(60), // Link expiration time
                    ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())] // Parameters
                );
                Mail::to($user->email)->send(new Registration($user, $password, $verificationUrl));
            } catch (Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                Alert::error('Error', 'Something went wrong. Please try again.');
                return redirect()->back();
            }
        }
        /*if ($request->total <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Total price cannot be zero.'], 500);
        }*/

        Session::put('ticket', $request->all());
        if ((int) $total > 0) {
            return redirect()->route('paypal.payment');
        }
        $ticket = Session::get('ticket');
        //        dd($ticket);
        $booking_id = $this->ticketBooking((object) $ticket);
        Log::info($ticket);
        return redirect()->route('success', Crypt::encrypt($booking_id));
    }

    /**
     * Handle the PayPal payment request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $ticket = Session::get('ticket');

        $checkoutData = json_decode($ticket['checkout_user_data'], true);
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $checkoutData['grand_total'],
                    ],
                ],
            ],
        ]);
        Log::info($response);


        if (isset($response['id']) && $response['id'] != null) {
            // Redirect to PayPal approval URL
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
            Alert::error('Error', 'Something went wrong. No approval link found.');
            return redirect()->route('paypal.payment.cancel')->with('error', 'Something went wrong. No approval link found.');
        } else {
            Alert::error('Error', $response['message'] ?? 'Something went wrong while creating the order.');
            return redirect()->route('events.index')->with('error', $response['message'] ?? 'Something went wrong while creating the order.');
        }
    }

    /**
     * Handle the payment cancellation.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentCancel()
    {
        return redirect()->route('events.index')->with('info', 'Payment was cancelled.');
    }

    /**
     * Handle the successful payment capture.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        Log::info($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $ticket = Session::get('ticket');
            $booking_id = $this->ticketBooking((object) $ticket);
            $booking = EventBooking::find($booking_id);
            Log::info($booking);
            Alert::success('Ticket Booked', 'Your ticket has been booked successfully. Your Ticket ID is: ' . $booking->ticket_id);
            return redirect()->route('success', Crypt::encrypt($booking->id))->with('success', 'Event booked successfully. Booking ID: ' . $booking->id);
        } else {
            Alert::error('Error', $response['message'] ?? 'Something went wrong while capturing the payment.');
            return redirect()->route('events.index')->with('error', $response['message'] ?? 'Something went wrong while capturing the payment.');
        }
    }

    private function ticketBooking($request)
    {
        $event = Event::find($request->event_id);
        $ticket_id = 'TKT' . str_pad(random_int(1, 9999999), 7, '0', STR_PAD_LEFT);
        $checkoutData = json_decode($request->checkout_user_data, true);
        $slots = collect();
        foreach ($checkoutData['slots'] as $slot) {
            $slots->push((object) $slot);
        }
        $totalTickets = $slots->sum('selectedQty');
        $total = $checkoutData['grand_total'];
        $bookingSlots = $this->selectSlots($event->slots, $slots);
        // dd($checkoutData, $bookingSlots, $request);
        $booking = $event->bookings()->create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'ticket_id' => $ticket_id,
            'tickets' => $totalTickets,
            'total' => $total,
            // 'packages' => $packages,
            'slots' => $bookingSlots
        ]);
        $event->slots = $this->subtractArrays($event->slots, $slots, $event->reserved);
        $event->paid_tickets = $event->paid_tickets - (int) $totalTickets;
        $event->total_tickets = $event->total_tickets - (int) $totalTickets;
        // dd($event->slots);
        $event->save();
        try {
            $users = User::where('role', Role::SUPERADMIN)->get();
            $users = $users->merge([$event->organizer]);
            $full_name = "{$request->fname} {$request->lname}";
            foreach ($users as $user) {
                if ($user) {
                    $object = ['title' => $full_name, 'route' => 'admin.events.show', 'var' => $event->slug, 'image' => $event->image];
                    $message = "{$event->name} has been booked by {$full_name}";
                    $user->notify(new EventBookingNotification($message, $object));
                    Mail::to($request->email)->send(new Booking($booking->id));
                } else {
                    Log::error('Null user found in notification list');
                }
            }
        } catch (Exception $e) {
            Log::error('Error during ticket booking:', ['error' => $e->getMessage()]);
        }
        return $booking->id;
    }
    private function subtractArrays($arr1, $arr2, $reserved)
    {
        // Process the data
        foreach ($arr2 as $selected) {
            if (property_exists($selected, 'date') && $selected->date) {
                $selectedDate = $selected->date;
                $selectedPackage = $selected->packageName;
                $selectedQty = $selected->selectedQty;

                foreach ($arr1 as &$event) {
                    if (isset($event['date']) && $event['date'] === $selectedDate) {
                        if ($selected->type === 'paid') {
                            foreach ($event['packages'] as &$package) {
                                if ($package['name'] === $selectedPackage) {
                                    // Subtract the selected quantity from available quantity
                                    $package['qty'] -= $selectedQty;
                                    $event['paid_tickets'] -= $selectedQty;
                                    $event['total_tickets'] -= $selectedQty;
                                }
                            }
                        } elseif ($selected->type === 'free') {
                            $event['free_tickets'] -= $selectedQty;
                            $event['total_tickets'] -= $selectedQty;
                        } elseif ($selected->type === 'donated') {
                            $event['donated_tickets'] -= $selectedQty;
                            $event['total_tickets'] -= $selectedQty;
                        }
                        if ($reserved) {
                            $event['booked_seats'] = array_merge($event['booked_seats'] ?? [], $selected->seats ?? []);
                        }
                    } elseif (isset($event['start_date']) && ($selectedDate >= $event['start_date'] && $selectedDate <= $event['end_date'])) {
                        if ($selected->type === 'paid') {
                            foreach ($event['packages'] as &$package) {
                                if ($package['name'] === $selectedPackage) {
                                    // Subtract the selected quantity from available quantity
                                    $package['qty'] -= $selectedQty;
                                    $event['paid_tickets'] -= $selectedQty;
                                    $event['total_tickets'] -= $selectedQty;
                                }
                            }
                        } elseif ($selected->type === 'free') {
                            $event['free_tickets'] -= $selectedQty;
                            $event['total_tickets'] -= $selectedQty;
                        } elseif ($selected->type === 'donated') {
                            $event['donated_tickets'] -= $selectedQty;
                            $event['total_tickets'] -= $selectedQty;
                        }
                        if ($reserved) {
                            $event['booked_seats'] = array_merge($event['booked_seats'] ?? [], $selected->seats ?? []);
                        }
                    }
                }
            } elseif (property_exists($selected, 'start_date') && $selected->start_date) {

                $selectedDate = $selected->start_date;
                $selectedPackage = $selected->packageName;
                $selectedQty = $selected->selectedQty;

                foreach ($arr1 as &$event) {
                    if (strtotime($event['start_date']) <= strtotime($selectedDate) && strtotime($selectedDate) <= strtotime($event['end_date'])) {
                        if ($selected->type === 'paid') {
                            foreach ($event['packages'] as &$package) {
                                if ($package['name'] === $selectedPackage) {
                                    // Subtract the selected quantity from available quantity
                                    $package['qty'] -= $selectedQty;
                                    $event['paid_tickets'] -= $selectedQty;
                                    $event['total_tickets'] -= $selectedQty;
                                }
                            }
                        } elseif ($selected->type === 'free') {
                            $event['free_tickets'] -= $selectedQty;
                            $event['total_tickets'] -= $selectedQty;
                        } elseif ($selected->type === 'donated') {
                            $event['donated_tickets'] -= $selectedQty;
                            $event['total_tickets'] -= $selectedQty;
                        }

                        if ($reserved) {
                            $event['booked_seats'] = array_merge($event['booked_seats'] ?? [], $selected->seats ?? []);
                        }
                    }
                }
            }
        }

        // Print updated event data
        return $arr1;
    }
    private function selectSlots($arr1, $arr2): array
    {
        $new_arr = [];
        // dd($arr1, $arr2);
        foreach ($arr2 as $selected) {
            $selectedPackage = $selected->packageName;
            // dd($arr1, $arr2);
            // Check if date exists first
            if (property_exists($selected, 'date') && $selected->date) {
                $selectedDate = $selected->date;
                $index = array_search($selectedDate, array_column($new_arr, 'date'));
                foreach ($arr1 as &$event) {
                    // dd($event, $selectedDate);
                    if (isset($event['date']) && $event['date'] === $selectedDate) {
                        if ($selected->type === 'paid') {
                            foreach ($event['packages'] as &$package) {
                                if ($package['name'] === $selectedPackage) {
                                    // Check if the date already exists in $new_arr
                                    if ($index !== false) {
                                        // Date exists, append the package inside the existing array
                                        $new_arr[$index]['packages'][] = (object) [
                                            "qty" => $selected->selectedQty,
                                            "name" => $selected->packageName,
                                            "price" => $selected->price,
                                            "type" => $selected->type
                                        ];
                                    } else {
                                        // Date does not exist, create a new entry
                                        $new_arr[] = [
                                            'date' => $selected->date,
                                            'time' => $event['time'],
                                            'packages' => [
                                                (object) [
                                                    "qty" => $selected->selectedQty,
                                                    "name" => $selected->packageName,
                                                    "price" => $selected->price,
                                                    "type" => $selected->type
                                                ],
                                            ], // Initialize as an array
                                        ];
                                    }
                                }
                            }
                        } elseif ($selected->type === 'free' || $selected->type === 'donated') {
                            if ($index !== false) {
                                // Date exists, append the package inside the existing array
                                $new_arr[$index]['packages'][] = (object) [
                                    "qty" => $selected->selectedQty,
                                    "name" => $selected->packageName,
                                    "price" => $selected->price,
                                    "type" => $selected->type
                                ];
                            } else {
                                // Date does not exist, create a new entry
                                $new_arr[] = [
                                    'date' => $selected->date,
                                    'time' => $event['time'],
                                    'packages' => [
                                        (object) [
                                            "qty" => $selected->selectedQty,
                                            "name" => $selected->packageName,
                                            "price" => $selected->price,
                                            "type" => $selected->type
                                        ],
                                    ], // Initialize as an array
                                ];
                            }
                        }
                    } elseif (isset($event['start_date']) && ($selectedDate >= $event['start_date'] && $selectedDate <= $event['end_date'])) {
                        if ($selected->type === 'paid') {
                            foreach ($event['packages'] as &$package) {
                                if ($package['name'] === $selectedPackage) {
                                    // Check if the date already exists in $new_arr
                                    if ($index !== false) {
                                        // Date exists, append the package inside the existing array
                                        $new_arr[$index]['packages'][] = (object) [
                                            "qty" => $selected->selectedQty,
                                            "name" => $selected->packageName,
                                            "price" => $selected->price,
                                            "type" => $selected->type
                                        ];
                                    } else {
                                        // Date does not exist, create a new entry
                                        $new_arr[] = [
                                            'date' => $selected->date,
                                            'time' => $event['time'],
                                            'packages' => [
                                                (object) [
                                                    "qty" => $selected->selectedQty,
                                                    "name" => $selected->packageName,
                                                    "price" => $selected->price,
                                                    "type" => $selected->type
                                                ],
                                            ], // Initialize as an array
                                        ];
                                    }
                                }
                            }
                        } elseif ($selected->type === 'free' || $selected->type === 'donated') {
                            if ($index !== false) {
                                // Date exists, append the package inside the existing array
                                $new_arr[$index]['packages'][] = (object) [
                                    "qty" => $selected->selectedQty,
                                    "name" => $selected->packageName,
                                    "price" => $selected->price,
                                    "type" => $selected->type
                                ];
                            } else {
                                // Date does not exist, create a new entry
                                $new_arr[] = [
                                    'date' => $selected->date,
                                    'time' => $event['time'],
                                    'packages' => [
                                        (object) [
                                            "qty" => $selected->selectedQty,
                                            "name" => $selected->packageName,
                                            "price" => $selected->price,
                                            "type" => $selected->type
                                        ],
                                    ], // Initialize as an array
                                ];
                            }
                        }
                    }

                }
            } elseif (property_exists($selected, 'start_date') && $selected->start_date) {
                $selectedDate = $selected->start_date;
                foreach ($arr1 as &$event) {
                    $index = array_search($selected->start_date, array_column($new_arr, 'start_date'));
                    if (strtotime($event['start_date']) <= strtotime($selectedDate) && strtotime($selectedDate) <= strtotime($event['end_date'])) {
                        if ($selected->type === 'paid') {
                            foreach ($event['packages'] as &$package) {
                                if ($package['name'] === $selectedPackage) {
                                    // Check if the date already exists in $new_arr
                                    if ($index !== false) {
                                        // Date exists, append the package inside the existing array
                                        $new_arr[$index]['packages'][] = (object) [
                                            "qty" => $selected->selectedQty,
                                            "name" => $selected->packageName,
                                            "price" => $selected->price,
                                            "type" => $selected->type
                                        ];
                                    } else {
                                        // Date does not exist, create a new entry
                                        $new_arr[] = [
                                            'start_date' => $selected->start_date,
                                            'end_date' => $selected->end_date,
                                            'time' => $event['time'],
                                            'packages' => [
                                                (object) [
                                                    "qty" => $selected->selectedQty,
                                                    "name" => $selected->packageName,
                                                    "price" => $selected->price,
                                                    "type" => $selected->type
                                                ],
                                            ], // Initialize as an array
                                        ];
                                    }
                                }
                            }
                        } elseif ($selected->type === 'free' || $selected->type === 'donated') {
                            if ($index !== false) {
                                // Date exists, append the package inside the existing array
                                $new_arr[$index]['packages'][] = (object) [
                                    "qty" => $selected->selectedQty,
                                    "name" => $selected->packageName,
                                    "price" => $selected->price,
                                    "type" => $selected->type
                                ];
                            } else {
                                // Date does not exist, create a new entry
                                $new_arr[] = [
                                    'start_date' => $selected->start_date,
                                    'end_date' => $selected->end_date,
                                    'time' => $event['time'],
                                    'packages' => [
                                        (object) [
                                            "qty" => $selected->selectedQty,
                                            "name" => $selected->packageName,
                                            "price" => $selected->price,
                                            "type" => $selected->type
                                        ],
                                    ], // Initialize as an array
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $new_arr;
    }




}