@extends('layout.profile')
@section('profile')
    @if (Auth::user()->role == \App\Enums\Role::SUPERADMIN)
        @if ($events->isNotEmpty())
            <section class="events-section-inner px-15px profile-body-content-wrapper item-row pb-50px">
                @foreach ($events as $event)
                    {{--    <x-event-card :event="$event" isSuperAdmin editable />--}}
                    <x-card :event="$event" admin isSuperAdmin editable/>
                @endforeach
            </section>
            {{ $events->links('vendor.pagination.custom') }}
        @else
            <section>
                <div class="flex justify-center items-center">
                    <img src="{{ asset('asset/images/no-event-found.png') }}" alt="">
                </div>
            </section>
        @endif
    @else
        <!-- Suggestion Section Starts Here -->
        <section class="events-section-inner suggestions-wrapper">
            <div class="suggestions-inner-wrapper">

                <div class="suggestions-heading-wrapper">
                    <h2 class="suggestions-heading">People you may know</h2>
                    <a href="{{ route('admin.suggestions') }}" class="see-all-suggestions">See all</a>
                </div>

                <div class="swiper user-suggestions-swiper">
                    <div class="swiper-wrapper">

                        @foreach ($suggestions as $suggestion)
                            <div class="swiper-slide" id="connection-card-{{ $suggestion->id }}">
                                <div class="swiper-slide suggestions-user-card-wrapper">
                                    <div class="suggestions-user-card-image-wrapper">
                                        <img class="suggestions-user-card-image" src="{{ $suggestion->profile }}"
                                             alt="connection"
                                             draggable="false">
                                    </div>
                                    <div class="w-full suggestions-user-card-info-wrapper">
                                        <p class="basic-connection-name">{{ $suggestion->full_name }}</p>
                                        <button type="button"
                                                class="suggestions-connect-a-tag connection-request-{{ $suggestion->id }}"
                                                onclick="handleFollow(event, {{ $suggestion->id }})">
                                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                            Follow
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- Suggestion Section Ends Here -->

        @if (Auth::user()->role === \App\Enums\Role::ORGANIZER)
            <section class="events-section-inner px-15px profile-body-content-wrapper">
                <h1 class="all-events-heading">Your Organized Events</h1>
            </section>
            @if($events->isNotEmpty())
                <section class="events-section-inner px-15px item-row pb-50px">
                    @foreach ($events as $event)
                        @if(Auth::id() === $event->organizer->id)
                            <x-card :event="$event" admin editable/>
                        @else
                            <x-card :event="$event" admin/>
                        @endif
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
        <section class="events-section-inner px-15px profile-body-content-wrapper">
            <h1 class="all-events-heading">Popular Events</h1>
        </section>
        @if($popularEvents->isNotEmpty())
            <section class="events-section-inner px-15px item-row pb-50px">
                @foreach ($popularEvents as $event)
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
        {{ $popularEvents->links('vendor.pagination.custom') }}
    @endif
@endsection

@push('js')
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
    </script>
@endpush