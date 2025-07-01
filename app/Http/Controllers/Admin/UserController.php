<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Enums\Status;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\UserNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function allUsers()
    {
        $searchUsers = User::where('role', '!=', Role::SUPERADMIN)->withCount('bookings')->get();
        $users = User::all();
        $membershipPlans = MembershipPlan::all();
        return view('admin.users', compact('users', 'searchUsers', 'membershipPlans'));
    }
    public function searchUsers(Request $request)
    {
        $search = $request->search;
        if ($search === null) {
            return redirect()->back();
        }
        $user = User::where('username', $search)->withCount('bookings')->first();
        return redirect()->route('admin.profile', $user->username);
    }
    public function allEvents()
    {
        $eventsQuery = Auth::user()->role == Role::SUPERADMIN
            ? Event::withCount('bookings')
            : Event::where('status', Status::ACCEPTED)->withCount('bookings');

        $events = $eventsQuery->with('images')->with('organizer')->withCount('bookings')->paginate(9);
        return view('admin.all-events', compact('events'));
    }

    public function pendingEvents()
    {
        $events = Event::where('status', Status::PENDING)->withCount('bookings')->with('images')->with('organizer')->withCount('bookings')->paginate(9);
        return view('admin.pending-events', compact('events'));
    }
    public function acceptedEvents()
    {
        $events = Event::where('status', Status::ACCEPTED)->withCount('bookings')->with('images')->with('organizer')->withCount('bookings')->paginate(9);
        return view('admin.accepted-events', compact('events'));
    }
    public function rejectedEvents()
    {
        $events = Event::where('status', Status::REJECTED)->withCount('bookings')->with('images')->with('organizer')->withCount('bookings')->paginate(9);
        return view('admin.rejected-events', compact('events'));
    }

    public function role(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->role = $request->role;
        $user->save();
        $notUsers = User::where('role', Role::SUPERADMIN)->get();
        foreach ($notUsers as $notUser) {
            $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile];
            $notUser->notify(new UserNotification("{$user->full_name}`s role has been updated to {$user->role->value}", $object));
        }
        $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile];
        $user->notify(new UserNotification("Your role has been updated to {$user->role->value}", $object));
        return response()->json(['success' => true, 'message' => "User role updated to {$user->role->value}"]);
    }

    public function block(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->block = !$user->block;
        $user->save();
        $notUsers = User::where('role', Role::SUPERADMIN)->get();
        foreach ($notUsers as $notUser) {
            $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile];
            $notUser->notify(new UserNotification($user->full_name . '`s account has been ' . ($user->block ? 'Blocked' : 'Unblocked') . ' by ' . Auth::user()->full_name, $object));
        }
        $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile];
        $user->notify(new UserNotification('You have been ' . ($user->block ? 'Blocked' : 'Unblocked') . ' by European Certified', $object));
        return response()->json(['success' => true, 'message' => 'User has been ' . ($user->block ? 'Blocked' : 'Unblocked')]);
    }
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User has been deleted']);
    }
    public function membership(string $id, Request $request)
    {
        // dd($id, $request->all());
        $membership = new Membership();
        $membership->user_id = $id;
        $membership->plan_id = $request->input('plan_id');
        $membership->save();
        return response()->json(['success' => true, 'message' => 'Membership has been ' . $membership->plan->title . ' added successfully'], 200);
    }
}