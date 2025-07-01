<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\Timing;
use App\Helpers\Setting;
use App\Models\Event;
use App\Models\City;
use App\Models\EventCategory;
use App\Models\EventBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Random\RandomException;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MainController extends Controller
{
    public function events(Request $request, $parameter = null): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if ($parameter !== null) {
            $event = Event::where('slug', $parameter)->count();
            if ($event > 0) {
                return $this->eventDetail($parameter);
            } else {
                return $this->eventsIndex($request, $parameter);
            }
        } else {
            return $this->eventsIndex($request, $parameter);
        }
    }
    private function eventsIndex(Request $request, $city = null): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $city = $city ?: $request->city;
        $data = Setting::data();
        $query = Event::where('status', Status::ACCEPTED)->with('category')->with('images')->withCount('bookings')->with(['organizer.followers']);
        $categoryQuery = EventCategory::where('status', true);
        if ($city) {
            $query = $query->where('city', $city);
        }

        if ($request?->date) {
            $date = Carbon::parse($request->date);
            //            $query = $query->where('starts_datetime', '>=', $date)->orderBy('starts_datetime');
        }

        if ($request?->title) {
            $query = $query->where('name', 'like', "%$request->title%");
        }

        if ($request?->category) {
            $categoryIds = $categoryQuery->where('title', 'like', "%$request->category%")->pluck('id');
            $query = $query->whereIn('category_id', $categoryIds);
        }

        if ($request?->type === 'upcoming') {
            //            $query = $query->where('starts_datetime', '>=', Carbon::now())->orderBy('starts_datetime');
        } elseif ($request?->type === 'past') {
            //            $query = $query->where('starts_datetime', '<=', Carbon::now())->orderBy('starts_datetime', 'desc');
        } else {
            //            $query = $query->orderBy('starts_datetime');
        }

        $events = $query->paginate(10);
        $events->appends($request->except('city'));
        $meta = (object) [
            'meta_title' => 'Events | Caribbean Air force Radio Network and Events',
            'meta_keywords' => 'Caribbean Air force Radio Network and Events Parties Reggae Soca Calypso Festivals Carnival Fun Day Buy tickets on line',
            'meta_description' => 'Caribbean Air force Hottest Caribbean Events in the USA Europe and The Caribbean None Stop Entertainment Reggae Calypso Soca Buy Tickets On line ',
        ];
        $searchEvents = $query->get();
        // $searchCities = Event::whereNotNull('city')->where('city', '!=', '')->where('status', Status::ACCEPTED)->distinct()->pluck('city');

        $searchCities = City::all();
        $categories = $categoryQuery->get();
        return view('events', compact('data', 'events', 'meta', 'searchEvents', 'searchCities', 'categories'));
    }


    /**
     * @throws RandomException
     */
    private function eventDetail($slug): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $event = Event::with(['organizer.followers'])->with('images')->withCount('bookings')->where('slug', $slug)->first();
        if ($event) {
            if (request()->ajax()) {
                $image = $event->image;
                $event->setAttribute('image', $image);
                $ticket_id = 'TKT' . str_pad(random_int(1, 9999999), 7, '0', STR_PAD_LEFT);
                $event->ticket_id = $ticket_id;
                return response()->json($event);
            } else {
                $data = Setting::data();
                $events = Event::where('status', Status::ACCEPTED)->get();

                $meta = (object) [
                    'meta_title' => $event->meta_title ?? 'Event | Caribbean Airforce',
                    'meta_keywords' => $event->meta_keywords ?? 'Caribbean Airforce',
                    'meta_description' => $event->meta_description ?? 'Caribbean Airforce',
                ];
                return view('event-detail', compact('data', 'events', 'event', 'meta'));
            }
        } else {
            Alert::error('Error 404!', 'Event Not Found');
            return redirect()->route('events.index');
        }
    }
    public function success($id)
    {
        $booking = EventBooking::with('event')->where('id', Crypt::decrypt($id))->first();
        if ($booking) {
            $data = Setting::data();
            $slots = $booking->slots;
            $ticket = $booking->event->type === "ticket";
            $meta = (object) [
                'meta_title' => 'Success | Caribbean Airforce',
                'meta_keywords' => 'Caribbean Airforce',
                'meta_description' => 'Caribbean Airforce',
            ];
            return view('success', compact('data', 'booking', 'slots', 'ticket', 'meta'));
        }
        Alert::error('Error!', 'Ticket not found');
        return redirect()->route('events.index');
    }
    // public function downloadTicket($id, Request $request)
    // {
    //     $booking = EventBooking::where('ticket_id', $id)->first();
    //     $eventTicket = new EventBookingTicket();
    //     $issuer_id = env('GOOGLE_WALLET_ISSUER_ID');
    //     $customer_id = $id;
    //     $class_id = env('GOOGLE_WALLET_CLASS_ID');
    //     // $class_id = $eventTicket->createClass($issuer_id, $customer_id);
    //     // dd($class_id);
    //     $res = $eventTicket->createJwtNewObjects($issuer_id, $class_id, $customer_id);
    //     // dd($res);
    //     return redirect($res);  // Correct redirect syntax
    // }
    public function intellectualPolicy(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $data = Setting::data();
        $meta = (object) [
            'meta_title' => "Intellectual Property Rights Policy | " . env('APP_NAME'),
            'meta_keywords' => env('APP_NAME'),
            'meta_description' => env('APP_NAME'),
        ];
        return view('policies.intellectual-property-rights', compact('data', 'meta'));
    }
    public function privacyPolicy(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $data = Setting::data();
        $meta = (object) [
            'meta_title' => "Privacy Policy | " . env('APP_NAME'),
            'meta_keywords' => env('APP_NAME'),
            'meta_description' => env('APP_NAME'),
        ];
        return view('policies.privacy', compact('data', 'meta'));
    }
    public function termsPolicy(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $data = Setting::data();
        $meta = (object) [
            'meta_title' => "Terms and Conditions | " . env('APP_NAME'),
            'meta_keywords' => env('APP_NAME'),
            'meta_description' => env('APP_NAME'),
        ];
        return view('policies.terms', compact('data', 'meta'));
    }
    public function faqs(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $data = Setting::data();
        $meta = (object) [
            'meta_title' => "Frequently Asked Questions | " . env('APP_NAME'),
            'meta_keywords' => env('APP_NAME'),
            'meta_description' => env('APP_NAME'),
        ];
        return view('policies.faqs', compact('data', 'meta'));
    }
    public function faqsRadio(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $data = Setting::data();
        $meta = (object) [
            'meta_title' => "Frequently Asked Questions | " . env('APP_NAME'),
            'meta_keywords' => env('APP_NAME'),
            'meta_description' => env('APP_NAME'),
        ];
        return view('policies.faqs-radio', compact('data', 'meta'));
    }

    public function downloadQRCode($slug): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $event = Event::where('slug', $slug)->first();
        $url = route('events.index', $event->slug) . '#qrcode';
        $qrCode = QrCode::format('svg')->size(300)->generate($url);
        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qrcode.svg"');
    }
    public function loadMoreEvents(Request $request)
    {
        $eventId = $request->event_id; // Get the current event ID
        $limit = 4; // Number of events per page
        $page = $request->page ?? 1; // Get the current page, default is 1

        $organizer = Event::find($eventId)?->organizer; // Find the organizer

        if (!$organizer) {
            return response()->json(['html' => '', 'hasMore' => false]);
        }

        // Get paginated events, excluding the current event
        $events = $organizer->events()
            ->where('id', '!=', $eventId) // Exclude current event
            ->paginate($limit, ['*'], 'page', $page);

        // Render the Blade components
        $html = [];
        foreach ($events as $event) {
            $html[] = view('components.card', ['event' => $event, 'varient' => 'list'])->render();
        }

        return response()->json([
            'html' => $html,
            'hasMore' => $events->hasMorePages(), // Check if more pages exist
            'nextPage' => $events->currentPage() + 1 // Send the next page number
        ]);
    }
}