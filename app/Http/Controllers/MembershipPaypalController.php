<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipBooking;
use App\Models\MembershipPlan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class MembershipPaypalController extends Controller
{

    public function plans()
    {
        $plans = MembershipPlan::all();
        return view('membership.plans', compact('plans'));
    }
    public function checkout(string $slug)
    {
        $plan = MembershipPlan::where('slug', Crypt::decrypt($slug))->first();
        Session::put('checkout', route('membership.checkout', $slug));
        return view('membership.checkout', compact('plan'));
    }
    public function checkoutProcess(Request $request, string $slug)
    {
        $plan = MembershipPlan::where('slug', $slug)->first();
        $data = (object)array_merge($request->all(), $plan->toArray());
        Session::put('membership', $data);
        // dd(Session::get('membership'));

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('membership.payment.success'),
                "cancel_url" => route('membership.payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $data->price,
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
            return redirect()->route('membership.payment.cancel')->with('error', 'Something went wrong. No approval link found.');
        } else {
            Alert::error('Error', $response['message'] ?? 'Something went wrong while creating the order.');
            return redirect()->back()->with('error', $response['message'] ?? 'Something went wrong while creating the order.');
        }
    }
    public function paymentCancel()
    {
        Alert::info('Cancelled Membership', 'Payment was cancelled');
        return redirect()->route(Session::get('checkout'));
    }
    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        Log::info($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $membership = Session::get('membership');
            $membership = (object)array_merge((array)$membership, ['transaction_id' => $response['id']]);
            // dd($response, $membership);
            $membership = $this->membershipBooking($membership);
            Log::info($response);
            Alert::success('Ticket Booked', "Your membership has been booked successfully. Your Membership Number is: {$membership->booking->membership_number}");
            return redirect()->route('membership.success', Crypt::encrypt($membership->id))->with('success', "Event booked successfully. Booking ID: {$membership->booking->membership_number}");
        } else {
            Alert::error('Error', $response['message'] ?? 'Something went wrong while capturing the payment.');
            return redirect()->route('events.index')->with('error', $response['message'] ?? 'Something went wrong while capturing the payment.');
        }
    }
    private function membershipBooking($membershipData)
    {
        // dd($membershipData);
        try {
            $membership = new Membership();
            if (Auth::check()) $membership->user_id = Auth::id();
            $membership->plan_id = $membershipData->id;
            $membership->start_date = now();
            $membership->end_date = now()->addMonths($membershipData->duration);
            $membership->status = true;
            $membership->save();

            $membership_number = 'CAM' . str_pad(substr(time(), -8), 8, '0', STR_PAD_LEFT);;
            $booking = new MembershipBooking();
            $booking->membership_id = $membership->id;
            $booking->fname = $membershipData->fname;
            $booking->lname = $membershipData->lname;
            $booking->email = $membershipData->email;
            $booking->phone = $membershipData->phone;
            $booking->transaction_id = $membershipData->transaction_id;
            $booking->membership_number = $membership_number;
            $booking->amount = $membershipData->price;
            $booking->save();
            return $membership;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return null;
        }
    }
    public function success($id)
    {
        $membership = Membership::find(Crypt::decrypt($id));
        return view('membership.success', compact('membership'));
    }
}
