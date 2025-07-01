@extends('layout.app')
@section('admin')
    <main>
        <!-- Banner Section Starts Here -->
        <section class="relative full-width max-h-400px">
            <div class="h-250px flex justify-end items-center">
                <img class="w-full select-none object-cover h-250px" id="cover-image-display" src="{{ $user->banner }}"
                     alt="banner" draggable="false"/>
            </div>
            <div class="events-section-inner flex justify-between items-end gap-1 main-profile-details-wrapper">
                <div class="relative rounded-full user-profile-img-wrapper">
                    <div class="relative rounded-full profile-display-image">
                        <img class="absolute select-none rounded-full w-full h-full object-cover"
                             id="profile-image-display"
                             src="{{ $user->profile }}" alt="" draggable="false"/>
                    </div>
                </div>
                <div class="w-full flex justify-start items-start flex-column gap-2-3-rem translate-Y-35px">
                    <div class="w-full flex justify-between items-center details-wrapper-main">
                        <div class="details-wrapper">
                            <div class="flex justify-start items-center gap-1">
                                <h5 class="user-name">{{ $user->full_name }}</h5>
                                <h5 class="user-name-2">{{ $user->username }}</h5>
                            </div>
                            <p class="designation">
                                @if ($user->role === \App\Enums\Role::SUPERADMIN)
                                    Super Admin
                                @elseif ($user->role === \App\Enums\Role::ORGANIZER)
                                    Event Organizer
                                @else
                                    User
                                @endif
                            </p>
                            <div class="mb-03rem flex justify-start items-center gap-05 profile-connections-wrapper">
                                <p class="connections">{{ $user->followers?->count() }} <span>follower{{
                                    $user->followers?->count() > 1 ? 's' : '' }}</span></p>
                                <div class="flex justify-start items-center">
                                    @foreach ($user->followers?->take(5) as $follower)
                                        <img class="select-none object-cover rounded-full thub-connections-img"
                                             src="{{ $follower->profile }}" alt="{{ $follower->full_name }}"
                                             draggable="false"/>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @if( Auth::user()->role !== \App\Enums\Role::SUPERADMIN)
                            <div class="profile-connect-button-wrapper">
                                @if( Auth::user()->isFollowing($user->id) )
                                    <button type="button"
                                            class="suggestions-connect-a-tag connection-request-{{ $user->id }}"
                                            onclick="handleUnfollow(event, {{ $user->id }})">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        Unfollow
                                    </button>
                                @else
                                    <button type="button"
                                            class="suggestions-connect-a-tag connection-request-{{ $user->id }}"
                                            onclick="handleFollow(event, {{ $user->id }})">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        Follow
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        @if( Auth::user()->role === \App\Enums\Role::SUPERADMIN || Auth::id() === $user->id )
            <section class="events-section-inner px-15px profile-body-content-wrapper item-row pb-50px">
                @if($user->license_file)
                    <div class="suggestions-user-card-wrapper">
                        <div class="suggestions-user-card-image-wrapper" style="background-color: #f0f8ff;">
                            @if(Auth::user()->role === \App\Enums\Role::SUPERADMIN)
                                <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                    <button class="feed-card-menu-drop-downmenu-btn" id="status-license"
                                            aria-label="Menu">
                                        <span class="material-symbols-outlined"> more_vert </span>
                                    </button>
                                    <div class="absolute card-dropdown-wrapper">
                                        <div class="dropdown card-dropdown-inner-wrapper">
                                            <a href="javascript:void(0);"
                                               onclick="handleStatus(event, {{ $user->id }}, 'license', '{{ \App\Enums\Status::PENDING }}')"
                                               @if($user->license_status == \App\Enums\Status::PENDING) class="active"@endif>
                                                <span class="fa fa-circle-info"></span>
                                                <p>Pending</p>
                                            </a>
                                            <a href="javascript:void(0);"
                                               onclick="handleStatus(event, {{ $user->id }}, 'license', '{{ \App\Enums\Status::ACCEPTED }}')"
                                               @if($user->license_status == \App\Enums\Status::ACCEPTED) class="active"@endif>
                                                <span class="fa fa-circle-check"></span>
                                                <p>Approve</p>
                                            </a>
                                            <a href="javascript:void(0);"
                                               onclick="handleStatus(event, {{ $user->id }}, 'license', '{{ \App\Enums\Status::REJECTED }}')"
                                               @if($user->license_status == \App\Enums\Status::REJECTED) class="active"@endif>
                                                <span class="fa fa-circle-xmark"></span>
                                                <p>Reject</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($user->license_file && $user->license_file['type'] === 'image')
                                <img class="suggestions-user-card-image"
                                     src="{{ asset('uploads/license/'.$user->license_file['filename']) }}"
                                     alt="connection"
                                     draggable="false">
                            @elseif($user->license_file && $user->license_file['type'] === 'pdf')
                                <img class="suggestions-user-card-image" src="{{ asset('admins/images/pdf-file.png') }}"
                                     alt="connection"
                                     draggable="false">
                            @else
                                <img class="suggestions-user-card-image" src="{{ asset('admins/images/file.png') }}"
                                     alt="connection"
                                     draggable="false">
                            @endif
                        </div>
                        <div class="w-full suggestions-user-card-info-wrapper">
                            <p class="basic-connection-name"
                               style="text-wrap: wrap !important;">{{ $user->license_file['filename'] }}</p>
                            <a href="{{ asset('uploads/license/'.$user->license_file['filename']) }}" target="_blank"
                               class="suggestions-connect-a-tag connection-request">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                View Document
                            </a>
                        </div>
                    </div>
                @endif
                @if($user->address_proof_file)
                    <div class="suggestions-user-card-wrapper">
                        <div class="suggestions-user-card-image-wrapper" style="background-color: #f0f8ff;">
                            @if(Auth::user()->role === \App\Enums\Role::SUPERADMIN)
                                <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                    <button class="feed-card-menu-drop-downmenu-btn" id="status-address"
                                            aria-label="Menu">
                                        <span class="material-symbols-outlined"> more_vert </span>
                                    </button>
                                    <div class="absolute card-dropdown-wrapper">
                                        <div class="dropdown card-dropdown-inner-wrapper">
                                            <a href="javascript:void(0);"
                                               onclick="handleStatus(event, {{ $user->id }}, 'address', '{{ \App\Enums\Status::PENDING }}')"
                                               @if($user->address_proof_status == \App\Enums\Status::PENDING) class="active"@endif>
                                                <span class="fa fa-circle-info"></span>
                                                <p>Pending</p>
                                            </a>
                                            <a href="javascript:void(0);"
                                               onclick="handleStatus(event, {{ $user->id }}, 'address', '{{ \App\Enums\Status::ACCEPTED }}')"
                                               @if($user->address_proof_status == \App\Enums\Status::ACCEPTED) class="active"@endif>
                                                <span class="fa fa-circle-check"></span>
                                                <p>Approve</p>
                                            </a>
                                            <a href="javascript:void(0);"
                                               onclick="handleStatus(event, {{ $user->id }}, 'address', '{{ \App\Enums\Status::REJECTED }}')"
                                               @if($user->address_proof_status == \App\Enums\Status::REJECTED) class="active"@endif>
                                                <span class="fa fa-circle-xmark"></span>
                                                <p>Reject</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($user->address_proof_file && $user->address_proof_file['type'] === 'image')
                                <img class="suggestions-user-card-image"
                                     src="{{ asset('uploads/address-proof/'.$user->address_proof_file['filename']) }}"
                                     alt="connection"
                                     draggable="false">
                            @elseif($user->address_proof_file && $user->address_proof_file['type'] === 'pdf')
                                <img class="suggestions-user-card-image" src="{{ asset('admins/images/pdf-file.png') }}"
                                     alt="connection"
                                     draggable="false">
                            @else
                                <img class="suggestions-user-card-image" src="{{ asset('admins/images/file.png') }}"
                                     alt="connection"
                                     draggable="false">
                            @endif
                        </div>
                        <div class="w-full suggestions-user-card-info-wrapper">
                            <p class="basic-connection-name"
                               style="text-wrap: wrap !important;">{{ $user->address_proof_file['filename'] }}</p>
                            <a href="{{ asset('uploads/address-proof/'.$user->address_proof_file['filename']) }}"
                               target="_blank"
                               class="suggestions-connect-a-tag connection-request">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                View Document
                            </a>
                        </div>
                    </div>
                @endif
            </section>
        @endif
        <!-- Banner Section Ends Here -->
        <section class="events-section-inner px-15px profile-body-content-wrapper pb-3 bottom-edge-shadow">
            <div class="all-events-heading-wrapper">
                <h1 class="all-events-heading">All Events</h1>
                <form action="{{ route('admin.search') }}" method="post" class="search-wrapoper-form">
                    @csrf
                    <div class="search-wrapoper">
                        <div class="relative" style="transform: translateY(-10px);">
                            <input class="search-input search-event-input" type="text" name="search" placeholder="Search Event?"
                                   oninput="handleSearchDropdown(this)">
                            <button class="search-icon-button" type="submit" style="top: -12%;">
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
                    {{--                <x-event-card :event="$event"/>--}}
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
        {{ $events->links('vendor.pagination.custom') }}
    </main>
@endsection
@section('js')
    <script>
        function handleFollow(e, id) {
            e.preventDefault();
            ajaxLoader('.connection-request-' + id, '<i class="fa-solid fa-arrow-right-from-bracket"></i> Follow');

            $.ajax({
                type: "POST",
                url: `{{ route('admin.follow', ':id') }}`.replace(':id', id),
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });

                        // Remove the suggestion card from the DOM
                        $('#connection-card-' + id).remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                }
            });
        }

        function handleUnfollow(e, id) {
            e.preventDefault();
            ajaxLoader('.connection-request-' + id, '<i class="fa-solid fa-arrow-right-from-bracket"></i> Unfollow');

            $.ajax({
                type: "POST",
                url: `{{ route('admin.unfollow', ':id') }}`.replace(':id', id),
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });

                        // Remove the request card from the DOM
                        $('#connection-card-' + id).remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                }
            });
        }

        const handleStatus = (e, id, type, status) => {
            e.preventDefault();
            ajaxLoader('#status-' + type, '<span class="material-symbols-outlined"> more_vert </span>');

            $.ajax({
                type: "POST",
                url: `{{ route('admin.signup.documents.status', ':id') }}`.replace(':id', id),
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'PUT',
                    type: type,
                    status: status
                },
                success: function (response) {
                    if (response.success) {
                        // Remove the request card from the DOM
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                }
            });
        }
    </script>
@endsection