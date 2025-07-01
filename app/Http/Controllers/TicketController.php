<?php

namespace App\Http\Controllers;

use App\Helpers\Setting;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class TicketController extends Controller
{
    public function ticketBooking($slug)
    {
        $data = Setting::data();
        $event = Event::where('slug', Crypt::decrypt($slug))->withCount('bookings')->with(['organizer.followers', 'images', 'amenities'])->first();
        if ($event) {
            $meta = (object) [
                'meta_title' => 'Ticket or Pass Booking | Caribbean Airforce',
                'meta_keywords' => 'Caribbean Airforce',
                'meta_description' => 'Caribbean Airforce',
            ];
            return view('ticket', compact('data', 'event', 'meta'));
        }
        Alert::error('Error!', 'Event not found');
        return redirect()->route('events.index');
    }
    public function seatingPlan($uuid)
    {
        if (Storage::disk('r2')->exists($uuid)) {
            $json = Storage::disk('r2')->get($uuid);
            return response()->json(json_decode($json, true));
        }

        return response()->json(['message' => 'Seating plan not found'], 404);

    }
}
