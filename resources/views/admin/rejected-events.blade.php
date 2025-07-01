@extends('layout.events')
@section('events')
    @if (Auth::user()->role === \App\Enums\Role::SUPERADMIN)
        <section class="events-section-inner px-15px profile-body-content-wrapper bottom-edge-shadow ">
            <h1 class="all-events-heading">Rejected Events</h1>
            <div class="all-events-heading-wrapper">
                <div class="profile-tab-menu-wrapper" style="flex: 0 0 0">
                    <div class="relative">
                        <a href="{{ route('admin.all.events') }}">
                            <p>All Events</p>
                        </a>
                    </div>
                    <div class="relative">
                        <a href="{{ route('admin.pending.events') }}">
                            <p>Pending Events</p>
                        </a>
                    </div>
                    <div class="relative">
                        <a href="{{ route('admin.accepted.events') }}" class="">
                            <p>Accpeted Events</p>
                        </a>
                    </div>
                    <div class="relative">
                        <a href="{{ route('admin.rejected.events') }}" class="active-tab">
                            <p>Rejected Events</p>
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.search') }}" method="post" class="search-wrapoper-form">
                    @csrf
                    <div class="search-wrapoper">
                        <div class="relative">
                            <input class="search-input" type="text" name="search" placeholder="Search Event?"
                                   oninput="handleSearchDropdown(this)">
                            <button class="search-icon-button" type="submit">
                                <img class="search-icon" src="{{ asset('admins/images/search.svg') }}" alt="search">
                            </button>
                            <div class="search-dropdown-main-wrapper">
                                <div class="search-items-inner-wrapper">
                                    <div class="search-no-results hidden">
                                        <p>No Events Found</p>
                                    </div>
                                    <div class="search-results hidden">
                                        <div class="search-dropdown-wrapper">
                                            @foreach ($events as $event)
                                                <a href="javascript:void(0);">{{ $event->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        @if($events->isNotEmpty())
            <section class="events-section-inner px-15px profile-body-content-wrapper item-row pb-50px">
                @foreach ($events as $event)
                    {{--    <x-event-card :event="$event" isSuperAdmin editable />--}}
                    <x-card :event="$event" admin isSuperAdmin editable/>
                @endforeach
            </section>
        @else
            <section>
                <div class="flex justify-center items-center">
                    <img src="{{ asset('asset/images/no-event-found.png') }}" alt="">
                </div>
            </section>
        @endif
        @include('models.events')
    @else
        <section class="events-section-inner px-15px profile-body-content-wrapper">
            <div class="all-events-heading-wrapper">
                <h1 class="all-events-heading">Rejected Events</h1>
                <form action="{{ route('admin.search') }}" method="post" class="search-wrapoper-form">
                    @csrf
                    <div class="search-wrapoper">
                        <div class="relative">
                            <input class="search-input" type="text" name="search" placeholder="Search Event?"
                                   oninput="handleSearchDropdown(this)">
                            <button class="search-icon-button" type="submit">
                                <img class="search-icon" src="{{ asset('admins/images/search.svg') }}" alt="search">
                            </button>
                            <div class="search-dropdown-main-wrapper">
                                <div class="search-items-inner-wrapper">
                                    <div class="search-no-results hidden">
                                        <p>No Events Found</p>
                                    </div>
                                    <div class="search-results hidden">
                                        <div class="search-dropdown-wrapper">
                                            @foreach ($events as $event)
                                                <a href="javascript:void(0);">{{ $event->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        @if($events->isNotEmpty())
            <section class="events-section-inner px-15px profile-body-content-wrapper item-row pb-50px">
                @foreach ($events as $event)
                    {{--    <x-event-card :event="$event" />--}}
                    <x-card :event="$event" admin/>
                @endforeach
            </section>
        @else
            <section>
                <div class="flex justify-center items-center">
                    <img src="{{ asset('asset/images/no-event-found.png') }}" alt="">
                </div>
            </section>
        @endif
    @endif
@endsection