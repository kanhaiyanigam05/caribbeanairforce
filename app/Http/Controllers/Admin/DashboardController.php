<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Notifications\FollowNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function dashboard()
    {
            $user = Auth::user();

            // Check if any important field is empty
            // $emptyFields = [];
            // if (!$user->profiles) {
            //     $emptyFields[] = 'Profile Image';
            // }
            // if (!$user->cover) {
            //     $emptyFields[] = 'Cover Image';
            // }
            // if (!$user->country || !$user->state || !$user->zipcode || !$user->address) {
            //     $emptyFields[] = 'Address fields';
            // }
            // if (count($emptyFields) > 0) {
            //     $message = 'Please fill in the following fields: ' . implode(', ', $emptyFields);
            //     Alert::toast($message, 'warning')->autoClose(10000);
            // }
            $today = Carbon::now();
            $events = [];
            $popularEvents = [];
            if ($user->role === Role::SUPERADMIN) {
                $events = Event::where('status', Status::PENDING)->withCount('bookings')->paginate(9);
            } else {
                if ($user->role === Role::ORGANIZER) {
                    $events = Event::where('organizer_id', $user->id)->where('status', Status::ACCEPTED)->withCount('bookings')
                        ->paginate(9);
                }
                $popularEvents = Event::where('status', Status::ACCEPTED)
                    ->withCount('bookings')
                    ->orderBy('bookings_count', 'desc')
                    ->paginate(9);
            }

            $suggestions = User::where('city', $user->city)->where('id', '!=', $user->id)->whereNotIn('id', $user->following->pluck('id'))->paginate(12);
            return view('admin.dashboard', compact('events', 'suggestions', 'popularEvents'));
    }

    public function notifications()
    {
        $notifications = Auth::user()->unreadNotifications;
        return view('admin.notifications', compact('notifications'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if ($search === null) {
            return redirect()->back();
        }
        $event = Event::where('name', $search)->first();
        if ($event) {
            return redirect()->route('admin.events.show', $event->slug);
        } else {
            Alert::toast('Your searched event not found!', 'error');
            return redirect()->back();
        }
    }

    public function profile(string $username)
    {
        $user = User::where('username', $username)->first();
        if($user) {
            $events = $user?->events()?->paginate(9);
            return view('admin.profile', compact('user', 'events'));
        } else {
            Alert::error('Error!', 'User Not Found');
            return redirect()->back();
        }
    }

    public function suggestions()
    {
        $user = Auth::user();
        $suggestions = User::where('city', $user->city)->where('id', '!=', $user->id)->whereNotIn('id', $user->following->pluck('id'))->paginate(12);

        return view('admin.suggestions', compact('suggestions'));
    }

    public function followers()
    {
        $user = Auth::user();

        $followers = $user->followers()->paginate(12);

        return view('admin.followers', compact('followers'));
    }

    public function following()
    {
        $user = Auth::user();

        $followings = $user->following()->paginate(12);

        return view('admin.following', compact('followings'));
    }

    public function follow(string $id)
    {
        $user = Auth::user();

        // Check if the request was already sent or they're already friends
        $existingFollowing = $user->following()->where('followed_id', $id)->exists();

        if ($existingFollowing) {
            return response()->json(['success' => false, 'message' => 'You already follow this user'], 400);
        }

        // Send a new connection request
        $user->following()->attach($id);
        $followingUser = User::find($id);
        $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile];
        $followingUser->notify(new FollowNotification("{$user->full_name} started following you", $object));
        return response()->json(['success' => true, 'message' => "You started following {$followingUser->full_name}"], 200);
    }

    public function unfollow(string $id)
    {
        $user = Auth::user();

        // Find if the following exists in either of the two sides of the relationship
        $following = $user->following()->where('followed_id', $id)->first();

        if (!$following) {
            return response()->json(['success' => false, 'message' => 'Following not found'], 404);
        }

        // Detach the following
        $user->following()->detach($id);

        $followingUser = User::find($id);
        $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile];
        $followingUser->notify(new FollowNotification("{$user->full_name} unfollowed you", $object));

        return response()->json(['success' => true, 'message' => 'You unfollowed '.User::find($id)->full_name], 200);
    }
}