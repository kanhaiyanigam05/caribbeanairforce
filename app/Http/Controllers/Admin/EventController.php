<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Enums\Status;
use App\Helpers\ImageHelper;
use App\Helpers\Setting;
use App\Models\Event;
use App\Models\Amenity;
use DateTime;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Event\Accepted;
use App\Mail\Event\Cancelled;
use App\Mail\Event\Created;
use App\Mail\Event\Rejected;
use App\Models\EventImage;
use App\Models\User;
use App\Notifications\EventNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('admin.all.events');
    }
    public function upcoming()
    {
        $events = Event::where('organizer_id', Auth::id())
            ->withCount('bookings')
            ->where('status', Status::ACCEPTED)
            ->get();
        $filteredEvents = $events->filter(function ($event) {
            return $event->next_slot;
        });
        $events = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredEvents->forPage(request()->page, 9),
            $filteredEvents->count(),
            9,
            request()->page,
            ['path' => url()->current()]
        );
        return view('admin.events.upcoming', compact('events'));
    }
    public function past()
    {
        $events = Event::where('organizer_id', Auth::id())
            ->withCount('bookings')
            ->where('status', Status::ACCEPTED)
            ->get();
        $filteredEvents = $events->filter(function ($event) {
            return !$event->next_slot;
        });
        $events = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredEvents->forPage(request()->page, 9),
            $filteredEvents->count(),
            9,
            request()->page,
            ['path' => url()->current()]
        );
        return view('admin.events.past', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @throws Exception
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // dd($request->all());

        $isNewEvent = !$request->input('id');


        // Step 1: Create Event
        $event = Event::findOrNew($request->input('id'));
        $event->organizer_id = $isNewEvent ? Auth::id() : $event->organizer_id;
        $event->organizer_name = $request->input('organizer_name') ?? $event->organizer_name;
        $event->organizer_email = $request->input('organizer_email') ?? $event->organizer_email;
        $event->organizer_phone = $request->input('organizer_phone') ?? $event->organizer_phone;
        $event->title = trim($request->input('title')) ?? $event->title;
        $event->slug = Str::slug(trim($request->input('title'))) ?? $event->slug;
        $event->category_id = Str::slug(trim($request->input('category'))) ?? $event->category_id;
        $event->ticket_info = $request->input('ticket_info') ?? $event->ticket_info;

        // Step 3: Create Tickets
        $paid_tickets = 0;
        $free_tickets = (int) $request->input('free_tickets') ?? 0;
        $donated_tickets = (int) $request->input('donated_tickets') ?? 0;
        $packages = collect($request->input('package_name'))
            ->map(function ($name, $index) use ($request, &$paid_tickets) {
                $price = trim($request->package_price[$index]) ?? 0;
                $qty = trim($request->package_qty[$index]) ?? 0;
                $paid_tickets += (int) $qty;

                return (object) [
                    'name' => trim($name) ?? '',
                    'price' => (float) $price,
                    'qty' => (int) $qty,
                    'type' => 'paid',
                ];
            });
        if ($free_tickets > 0) {
            $packages->push((object) [
                'name' => 'Free',
                'price' => 0,
                'qty' => $free_tickets,
                'type' => 'free',
            ]);
        }
        if ($donated_tickets > 0) {
            $packages->push((object) [
                'name' => 'Donated',
                'price' => 0,
                'qty' => $donated_tickets,
                'type' => 'donated',
            ]);
        }
        $total_tickets = $free_tickets + $donated_tickets + $paid_tickets ?? 0;
        $event->free_tickets = $free_tickets ?? $event->free_tickets;
        $event->donated_tickets = $donated_tickets ?? $event->donated_tickets;
        $event->paid_tickets = $paid_tickets ?? $event->paid_tickets;
        $event->total_tickets = $total_tickets ?? $event->total_tickets;
        $event->packages = $packages ?? $event->packages;



        // Step 2(B): Event Seating Plan
        $seatingMap = null;
        if ($request->input('reserved')) {
            $event->reserved = $request->input('reserved') ? true : false;
            $seatingMap = ImageHelper::storeJSON($request->input('seating_map'));
            if ($isNewEvent === false && $seatingMap !== null) {
                // Delete the old seating map if it exists
                ImageHelper::destroyJSON($event->seating_map);
            }
            $event->seating_map = $seatingMap ?? $event->seating_map;
            $event->seating_plan = $request->input('seating_plan') ?? $event->seating_plan;
        }

        // Step 2: Event Duration
        $event->type = $request->input('type') ?? $event->type;
        $timing = $request->input('timing') ?? $event->timing;
        if ($event->type === 'pass')
            $timing = 'custom';
        $event->timing = $timing;
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $slots = [];
        $times = [];
        if ($timing === 'single') {
            $date = $request->input('date');
            $slot = (object) [
                'date' => (new DateTime($date))->format('Y-m-d'),
                'time' => [
                    (object) [
                        'start_time' => DateTime::createFromFormat('g:i A', $start_time)->format('g:i A'),
                        'end_time' => DateTime::createFromFormat('g:i A', $end_time)->format('g:i A'),
                    ],
                ],
                'packages' => $packages,
                'free_tickets' => $free_tickets,
                'donated_tickets' => $donated_tickets,
                'paid_tickets' => $paid_tickets,
                'total_tickets' => $total_tickets,
            ];
            $groupedSlots = [
                $seatingMap !== null ? $this->generateSlot($slot, $seatingMap) : $slot
            ];

            $slots = collect($groupedSlots)->values();
            // dd($slots);
        } elseif ($timing == 'daily') {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $groupedSlots = [];
            while ($startDate->lte($endDate)) {
                $slot = (object) [
                    'date' => $startDate->format('Y-m-d'),
                    'time' => [
                        (object) [
                            'start_time' => DateTime::createFromFormat('g:i A', $start_time)->format('g:i A'),
                            'end_time' => DateTime::createFromFormat('g:i A', $end_time)->format('g:i A'),
                        ],
                    ],
                    'packages' => $packages,
                    'free_tickets' => $free_tickets,
                    'donated_tickets' => $donated_tickets,
                    'paid_tickets' => $paid_tickets,
                    'total_tickets' => $total_tickets,
                ];
                $groupedSlots[] = $seatingMap !== null ? $this->generateSlot($slot, $seatingMap) : $slot;
                $startDate->addDay();
            }
            $slots = collect($groupedSlots)->values();
            // dd($slots, Carbon::parse($request->input('start_date')), $endDate);

        } else if ($timing == 'weekly') {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $day = strtolower($request->input('week-day'));
            // dd($day);
            $groupedSlots = [];

            if ($startDate->lte($endDate)) {
                $currentWeekday = strtolower($startDate->englishDayOfWeek);
                $nextSlotDate = $currentWeekday === $day ? $startDate : $startDate->copy()->next($day);

                while ($nextSlotDate->lte($endDate)) {
                    $slot = (object) [
                        'date' => $nextSlotDate->format('Y-m-d'),
                        'time' => [
                            (object) [
                                'start_time' => DateTime::createFromFormat('g:i A', $start_time)->format('g:i A'),
                                'end_time' => DateTime::createFromFormat('g:i A', $end_time)->format('g:i A'),
                            ],
                        ],
                        'packages' => $packages,
                        'free_tickets' => $free_tickets,
                        'donated_tickets' => $donated_tickets,
                        'paid_tickets' => $paid_tickets,
                        'total_tickets' => $total_tickets,
                    ];
                    $groupedSlots[] = $seatingMap !== null ? $this->generateSlot($slot, $seatingMap) : $slot;
                    $nextSlotDate->addWeek();
                }
            }

            $slots = collect($groupedSlots)->values();
            // dd($slots, Carbon::parse($request->input('start_date')), $endDate);
        } else if ($timing == 'monthly') {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $day = (int) strtolower($request->input('month-day'));
            // dd($day);
            $groupedSlots = [];

            if ($startDate->lte($endDate)) {
                $nextSlotDate = $startDate->copy()->day($day);

                while ($nextSlotDate->lte($endDate)) {
                    $slot = (object) [
                        'date' => $nextSlotDate->format('Y-m-d'),
                        'time' => [
                            (object) [
                                'start_time' => DateTime::createFromFormat('g:i A', $start_time)->format('g:i A'),
                                'end_time' => DateTime::createFromFormat('g:i A', $end_time)->format('g:i A'),
                            ],
                        ],
                        'packages' => $packages,
                        'free_tickets' => $free_tickets,
                        'donated_tickets' => $donated_tickets,
                        'paid_tickets' => $paid_tickets,
                        'total_tickets' => $total_tickets,
                    ];
                    $groupedSlots[] = $seatingMap !== null ? $this->generateSlot($slot, $seatingMap) : $slot;
                    $nextSlotDate->addMonth();
                }
            }

            $slots = collect($groupedSlots)->values();
            // dd($slots, Carbon::parse($request->input('start_date')), $endDate);
        } else if ($timing == 'custom') {
            $startDates = explode(',', $request->input('start_date'));
            $endDates = explode(',', $request->input('end_date'));

            $groupedSlots = [];
            foreach ($startDates as $i => $startDate) {
                $endDate = $endDates[$i];
                $slot = (object) [
                    'start_date' => (new DateTime($startDate))->format('Y-m-d'),
                    'end_date' => (new DateTime($endDate))->format('Y-m-d'),
                    'time' => [
                        (object) [
                            'start_time' => DateTime::createFromFormat('g:i A', $start_time)->format('g:i A'),
                            'end_time' => DateTime::createFromFormat('g:i A', $end_time)->format('g:i A'),
                        ],
                    ],
                    'packages' => $packages,
                    'free_tickets' => $free_tickets,
                    'donated_tickets' => $donated_tickets,
                    'paid_tickets' => $paid_tickets,
                    'total_tickets' => $total_tickets,
                ];
                $groupedSlots[] = $seatingMap !== null ? $this->generateSlot($slot, $seatingMap) : $slot;
            }
            $slots = collect($groupedSlots)->values();
            // dd($slots);
        }
        $event->slots = $slots ?? $event->slots;
        $passes = json_decode($request->input('custom_passes'), true);
        // dd($passes);
        $event->passes = $passes ?? $event->passes;


        // Step 4: Event Location
        $event->venue = trim($request->input('venue')) ?? $event->venue;
        $event->address = trim($request->input('address')) ?? $event->address;
        $event->city = trim($request->input('city')) ?? $event->city;
        $event->venue_map = trim($request->input('venue_map')) ?? $event->venue_map;


        // Step 5: Event Description
        $event->description = trim($request->input('description')) ?? $event->description;


        // Step 6: Event Banner
        if ($request->hasFile('banner')) {
            $banner = ImageHelper::store($request->file('banner'), 'events');
            $event->banner = $banner['filename'];
        }


        // Step 8: Select Event Ticket Mode
        $event->ticket_mode = $request->input('ticket_mode') ?? $event->ticket_mode;
        $event->ticket_location = $request->input('ticket_location') ?? $event->ticket_location;
        $event->ticket_location_map = $request->input('ticket_location_map') ?? $event->ticket_location_map;
        $event->refund = $request->input('refund') ?? $event->refund;


        // Step 9: Create Tickets FAQ
        $faqs = collect($request->input('question'))
            ->map(function ($question, $index) use ($request) {
                return (object) [
                    'question' => trim($question) ?? '',
                    'answer' => trim($request->answer[$index]) ?? '',
                ];
            });
        $event->faqs = $faqs ?? $event->faqs;


        // Step 10: Event Meta
        $event->meta_title = trim($request->input('meta_title')) ?? $event->meta_title;
        $event->meta_keywords = trim($request->input('meta_keywords')) ?? $event->meta_keywords;
        $event->meta_description = trim($request->input('meta_description')) ?? $event->meta_description;

        // dd($event);
        // Save Event
        if (Auth::user()->role === Role::SUPERADMIN) {
            $event->status = Status::ACCEPTED;
        }
        $event->save();


        // Step 7: Event Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $file = ImageHelper::store($image, 'events');
                $event->images()->create([
                    'event_id' => $event->id,
                    'image' => $file['filename'],
                    'type' => $file['type'],
                ]);
            }
        }

        // Step: Store Amenities
        $amenities = [];
        if ($request->hasFile('amenity_images')) {
            foreach ($request->file('amenity_images') as $i => $amenityImage) {
                $file = ImageHelper::store($amenityImage, 'amenities');
                $amenity = Amenity::firstOrCreate([
                    'name' => $request->custom_amenities[$i],
                    'image' => $file['filename'],
                    'type' => 'custom',
                ]);
                $amenities[] = $amenity;
            }
        }
        $uniqueAmenityIds = array_unique(array_merge($request->amenities ?? [], array_column($amenities, 'id')));
        $event->amenities()->sync($uniqueAmenityIds);

        if ($isNewEvent) {
            if ($event->organizer?->role === Role::SUPERADMIN) {
                $notificationUsers = User::where('id', '!=', $event->organizer->id)->where('role', '!=', Role::SUPERADMIN)->get();
                $notificationUsers = $notificationUsers->merge($event->organizer->followers ?? collect())->unique('id');
                $object = [
                    'title' => $event->name,
                    'route' => 'events.index',
                    'var' => $event->slug,
                    'image' => $event->image
                ];
                $message = 'A new event has been created by ' . Auth::user()->full_name;
                // EventJob::dispatch($notificationUsers, $message, $object);
                foreach ($notificationUsers as $user) {
                    if ($user) {
                        Log::info("Sending notification to user: {$user->id}"); // Log user ID
                        $user->notify(new EventNotification($message, $object));
                    } else {
                        Log::error('Null user found in notification list');
                    }
                }
            } else {
                $emailArray = [];
                try {
                    foreach (User::all() as $user) {
                        if ($user->role == Role::SUPERADMIN) {
                            $emailArray = array_merge($emailArray, [$user->email]);
                        }
                    }
                    $data = Setting::data();
                    // Mail::to(env('MAIL_USERNAME'))->send(new Created($data, $event));
                    Mail::to($emailArray)->send(new Created($data, $event));
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
                $notificationUser = User::where('id', $event->organizer->id)->first();
                $object = [
                    'title' => $event->name,
                    'route' => 'events.index',
                    'var' => $event->slug,
                    'image' => $event->image
                ];
                $message = 'Your event has been created successfully! wait for approval';
                Log::info("Sending notification to user: {$notificationUser->id}");
                $notificationUser->notify(new EventNotification($message, $object));
            }
            Alert::success('Event created!', 'Your event has been created successfully.');
        } else {
            Alert::success('Event updated!', 'Your event has been updated successfully.');
        }

        // return response()->json(['success' => true, 'message' => 'Event created successfully']);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::with(['organizer.followers', 'images', 'category', 'amenities'])->withCount('bookings')->where('slug', $id)->firstOrFail();
        if ($event !== null) {
            $meta = (object) [
                'meta_title' => $event->meta_title ?? 'Event | Caribbean Air force',
                'meta_keywords' => $event->meta_keywords ?? 'Caribbean Air force',
                'meta_description' => $event->meta_description ?? 'Caribbean Air force',
            ];
            $data = Setting::data();
            return view('admin.events.show', compact('event', 'meta', 'data'));
        } else {
            Alert::error('Event Not Found!', 'Your requested event either completed or removed');
            return redirect()->route('admin.all.events');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::where('id', $id)->with(['images', 'category', 'amenities'])->first();
        if ($event->reserved) {
            $event->seating_map = ImageHelper::getJSON($event->seating_map);
        }
        return response()->json(['success' => true, 'event' => $event], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        if ($event->bookings->count() > 0) {
            foreach ($event->bookings as $booking) {
                Mail::to($booking->email)->send(new Cancelled($booking->id));
            }
        }
        // if ($event->images()) {
        //     foreach ($event->images as $image) {
        //         ImageHelper::destroy($image->image, 'events');
        //     }
        // }
        $event->delete();
        return response()->json(['success' => true, 'message' => 'Event deleted successfully']);
    }

    public function status(string $id, Request $request): \Illuminate\Http\JsonResponse
    {
        $event = Event::findOrFail($id);
        // $event->status = $request->status;
//        dd($event);
        try {
            if ($request->status == Status::ACCEPTED->value) {
                $data = Setting::data();
                $event->status = Status::ACCEPTED;
                if (!$event->organizer->role == Role::SUPERADMIN) {
                    Mail::to($event->organizer->email)->send(new Accepted($data, $event));

                    $notificationUsers = User::where('id', '!=', $event->organizer->id)->where('role', '!=', Role::SUPERADMIN)->get();
                    $notificationUsers = $notificationUsers->merge($event->organizer->followers ?? collect())->unique('id');
                    $object = [
                        'title' => $event->name,
                        'route' => 'events.index',
                        'var' => $event->slug,
                        'image' => $event->image
                    ];
                    $message = 'A new event has been created by ' . Auth::user()->full_name;
                    // EventJob::dispatch($notificationUsers, $message, $object);
                    foreach ($notificationUsers as $user) {
                        if ($user) {
                            Log::info("Sending notification to user: {$user->id}"); // Log user ID
                            $user->notify(new EventNotification($message, $object));
                        } else {
                            Log::error('Null user found in notification list');
                        }
                    }
                }
                $event->update();
                return response()->json(['success' => true, 'message' => 'Event status updated to Accepted']);
            } elseif ($request->status == Status::REJECTED->value) {
                $data = Setting::data();
                $event->status = Status::REJECTED;
                if (!$event->organizer->role == Role::SUPERADMIN) {
                    Mail::to($event->organizer->email)->send(new Rejected($data, $event->organizer));
                }
                $event->update();
                return response()->json(['success' => true, 'message' => 'Event status updated to Rejected']);
            } else {
                $event->status = Status::PENDING;
                $event->update();
                return response()->json(['success' => true, 'message' => 'Event status updated to Pending']);
            }
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 404);
        }
    }
    public function destroyImage(string $id)
    {
        dd($id);
        $eventImage = EventImage::find($id);
        if ($eventImage) {
            ImageHelper::destroy($eventImage->image, 'events');
            $eventImage->delete();
            return response()->json(['success' => true, 'message' => 'Event image deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Event image not found'], 404);
    }

    private function generateSlot(object $object, string $seating_map)
    {
        $object->booked_seats = [];
        return $object;
    }
}