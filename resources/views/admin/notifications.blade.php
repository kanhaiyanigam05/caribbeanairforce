@extends('layout.profile')
@section('profile')
    <!-- Navbar Section Ends Here -->
    <section class="events-section-inner px-15px profile-body-content-wrapper pb-50px">
        <div class="dropdown all-notification-wrapper flex justify-start items-start flex-column p-15px">
            @forelse (Auth::user()->unreadNotifications as $notification)
                <a class="nav-notification-item"
                    href="{{ $notification->data['object']['var'] != null ? route($notification->data['object']['route'], $notification->data['object']['var']) : route($notification->data['object']['route']) }}">
                    @if ($notification->data['object']['image'])
                        <img class="select-none rounded-full basic-connection-image" src="{{ $notification->data['object']['image'] }}" alt="" draggable="false">
                    @elseif ($notification->data['object']['video'])
                        <video class="select-none rounded-full basic-connection-image" src="{{ $notification->data['object']['video'] }}" alt=""
                            draggable="false"></video>
                    @endif
                    <div>
                        <p class="notification-message-text">{{ $notification->data['message'] }}</p>
                        <p class="notification-message-time">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            @empty
                <p>No Notifications Found</p>
            @endforelse
        </div>
    </section>
    <!-- Main Section Ends Here -->
@endsection
