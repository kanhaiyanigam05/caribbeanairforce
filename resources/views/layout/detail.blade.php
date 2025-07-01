@push('detailCss')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('asset/css/swiper-v11/swiper.css') }}">
    <style>
        .leaflet-bottom.leaflet-right {
            display: none !important;
        }

        .leaflet-pane,
        .leaflet-control,
        .leaflet-top,
        .leaflet-bottom {
            z-index: 0 !important;
        }
    </style>
    <style>
        .dynamic-event-details h1,
        .dynamic-event-details h2,
        .dynamic-event-details h3,
        .dynamic-event-details h4,
        .dynamic-event-details h5,
        .dynamic-event-details h6 {
            line-height: 60px !important;
            letter-spacing: 0.5px !important;
        }

        .dynamic-event-details p {
            line-height: 30px;
        }

        .dynamic-event-details h1 {
            font-size: 2.5rem !important;
        }

        /* 40px */
        .dynamic-event-details h2 {
            font-size: 2rem !important;
        }

        /* 32px */
        .dynamic-event-details h3 {
            font-size: 1.75rem !important;
        }

        /* 28px */
        .dynamic-event-details h4 {
            font-size: 1.3rem !important;
        }

        /* 24px */
        .dynamic-event-details h5 {
            font-size: 1.25rem !important;
        }

        /* 20px */
        .dynamic-event-details h6 {
            font-size: 1rem !important;
        }

        /* 16px */

        .event-detail-left {
            width: 75%;
        }

        .event-detail-right {
            width: 25%;
        }

        .event-detail-right iframe {
            width: 100% !important;
            max-width: 100% !important;
        }

        @media only screen and (max-width: 1023px) {
            .event-detail-left {
                width: 100%;
            }

            .event-detail-right {
                width: 100%;
            }
        }


        .other-events-slider-wrapper {
            position: relative;
        }

        .other-events-slider-next,
        .other-events-slider-prev {
            position: absolute;
            top: -48px;
            width: 40px;
            height: 40px;
            z-index: 10;
            cursor: pointer;
            color: rgb(0, 0, 0);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color .2s ease-in-out;
            background-color: #fff;
            border: 2px solid #dbdae3;
        }

        .other-events-slider-next:hover,
        .other-events-slider-prev:hover {
            background-color: #eeedf2;
        }

        .other-events-slider-next.swiper-button-disabled,
        .other-events-slider-prev.swiper-button-disabled,
        .other-events-slider-next.swiper-button-disabled:hover,
        .other-events-slider-prev.swiper-button-disabled:hover {
            background-color: #fff;
            opacity: 0.35;
            cursor: not-allowed;
        }


        .other-events-slider-next {
            right: 10px;
        }

        .other-events-slider-prev {
            right: 100px;
        }

        @media only screen and (max-width: 500px) {
            .other-events-slider {
                margin-top: 3rem;
            }

            .other-events-slider-wrapper {
                margin-top: 4rem;
            }
        }

        .landscape-card-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .display-amenities {
          display: flex;
          justify-content: flex-start;
          align-items: center;
          gap: 1rem;
          flex-wrap: wrap;
        
        }
        
        .display-amenities .item {
          width: 20px;
          height: 20px;
        }
        
        .display-amenities .item img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          border-radius: 50%
          filter: grayscale(0);
        }
    </style>
@endpush
<!-- Banner Section Starts Here -->
<section class="relative flex justify-center items-center">
    <img class="brightness-50 select-none" src="{{ $event->header }}" alt="banner" draggable="false"
        style="width: 100%; height: 290px; object-fit: cover">
    <h1 class="absolute text-white text-3xl font-medium screen768:text-5xl">{{ $event->title }}</h1>
</section>
{{-- @dd($event->next_slot) --}}
<!-- Banner Section Ends Here -->
<section class="event-detail-page-wrapper my-10 max-w-[1500px] mx-auto w-full px-2 transition-all duration-500 flex justify-start items-start flex-col lg:flex-row gap-10">
    <div class="event-detail-left">
        <div class="block">
            <div class="swiper carousel">
                <div class="swiper-wrapper">
                    @if (isset($event->images))
                        @foreach ($event->images as $slide)
                            @if (in_array(strtolower(pathinfo($slide->image, PATHINFO_EXTENSION)), ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp']))
                                <div class="swiper-slide">
                                    <div class="overflow-hidden rounded-lg">
                                        <img class="select-none object-cover transition-all duration-300 ease-in-out hover:scale-[1.3] w-screen max-h-[450px]"
                                            src="{{ asset('uploads/events/' . $slide->image) }}" alt=""
                                            draggable="false">
                                    </div>
                                </div>
                            @elseif (in_array(strtolower(pathinfo($slide->image, PATHINFO_EXTENSION)), ['mp4']))
                                <div class="swiper-slide">
                                    <div class="overflow-hidden rounded-lg">
                                        <video class="select-none object-cover w-screen max-h-[450px]"
                                            controls muted autoplay loop>
                                            <source src="{{ asset('uploads/events/' . $slide->image) }}"
                                                type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="swiper-button-next bg-black px-6 rounded-full">
                    <i class="fa-solid fa-chevron-right text-2xl"></i>
                </div>
                <div class="swiper-button-prev bg-black px-6 rounded-full">
                    <i class="fa-solid fa-chevron-left text-2xl"></i>
                </div>
            </div>
            {{-- @if (count($event->images) > 1)
            <div thumbsSlider="" class="swiper carousel">
                <div class="swiper-wrapper">
                    @foreach ($event->images as $slide)
                    @if (in_array(strtolower(pathinfo($slide->image, PATHINFO_EXTENSION)), ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp']))
                    <div class="swiper-slide">
                        <div class="overflow-hidden rounded-lg w-full events-prev-thumb">
                            <img class="select-none img-contain img-contain transition-all duration-300 ease-in-out hover:scale-[1.3]"
                                src="{{ asset('uploads/events/' . $slide->image) }}" alt="" draggable="false">
                        </div>
                    </div>
                    @elseif (in_array(strtolower(pathinfo($slide->image, PATHINFO_EXTENSION)), ['mp4']))
                    <div class="swiper-slide">
                        <div class="overflow-hidden rounded-lg w-full events-prev-thumb">
                            <video
                                class="select-none img-contain object-contain transition-all duration-300 ease-in-out"
                                muted autoplay loop>
                                <source src="{{ asset('uploads/events/' . $slide->image) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif --}}
        </div><!-- Swiper JS -->
        <!-- Follow Section Starts Here -->
        <div class="w-full my-6">
            <div class="flex flex-col bg-gray-100 px-4 py-5 rounded-md profile-card">
                <div class="flex justify-between items-center w-full flex-wrap">
                    <div class="flex justify-start items-center gap-3 profile-header">
                        <img class="select-none object-cover w-14 h-14 rounded-full" src="{{ $event->organizer->profile }}" alt="logo" draggable="false">
                        <div class="flex justify-start items-start flex-col gap-1">
                            <div class="flex justify-start items-center gap-3 relative">
                                <p class="font-medium text-gray-950 text-nowrap">By {{ $event->organizer->full_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="button-container flex gap-2">
                        <button class="w-full text-primary px-4 py-1 rounded-[4px] font-medium">Contact</button>
                        @if (Auth::check())
                            @if (Auth::id() !== $event->organizer_id && Auth::user()->role !== \App\Enums\Role::SUPERADMIN)
                                <div class="button-container">
                                    @if ($event->organizer->followers->contains(Auth::id()))
                                        <button onclick="handleUnfollow(event, {{ $event->organizer->id }})" type="button"
                                            class="w-full bg-primary text-white px-4 py-1 rounded-[4px]">
                                            Unfollow
                                        </button>
                                    @else
                                        <button onclick="handleFollow(event, {{ $event->organizer->id }})" type="button"
                                            class="w-full bg-primary text-white px-4 py-1 rounded-[4px]">
                                            Follow
                                        </button>
                                    @endif
                                </div>
                            @endif
                        @else
                            <button onclick="handleFollowWithoutLogin(event, '{{ $event->organizer->full_name }}')"
                                type="button"
                                class="w-full bg-primary text-white px-4 py-1 rounded-[4px]">
                                Follow
                            </button>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col gap-2 mt-5 w-full">
                    @php $totalFollowers = $event->organizer->followers->count(); @endphp
                    <p class="text-black font-medium text-sm">{{ \App\Helpers\Setting::formatFollowers($totalFollowers) }} follower{{ $totalFollowers > 1 ? 's' : '' }}</p>
                    <p class="font-medium text-primary text-sm">{{ \App\Helpers\Setting::formatFollowers($event->bookings_count) }} <span class="text-gray-950">attendees hosted ðŸ“ˆ</span></p>
                </div>
            </div>
        </div>
        <!-- Follow Section Ends Here -->

        <h2 id="event-title" class="text-3xl font-bold screen768:text-5xl my-5 text-black capitalize">{{ $event->title }}</h2>

        <div class="flex justify-start flex-col gap-2 dynamic-event-details">
            {!! $event->description !!}
        </div>

        {{-- <div class="my-5 border border-stonegray px-8 py-8 shadow-cardshadow flex gap-4 justify-between items-end">
            <div class="">
                <img class="leading-6 text-base transition-all duration-500 rounded-full"
                    src="{{ $event->organizer->profile }}">
                <p class="leading-6 text-base font-semibold transition-all duration-500 mb-1">{{
                    $event->organizer->full_name }}</p>
            </div>
            <img class="select-none max-w-52" src="{{ asset('asset/images/untitled.png') }}" alt="" draggable="false">
        </div> --}}
        <style>
            #map {
                height: 400px;
                /* Adjust the height to your needs */
                width: 100%;
                /* Set the width to 100% or a specific value */
                position: relative;
            }
        </style>
        <div class="my-10 mx-auto w-full" id="map" data-address="{{ $event->address }}"
            data-favicon-url="{{ asset('/' . $data->favicon) }}"></div>


        @if (!empty($event->faqs))
            <!-- Faq Starts Here -->
            <div style="margin-top: 4.5rem;">
                <h5 class="text-2xl font-bold my-5 text-black capitalize">Frequently Asked
                    Questions</h5>

                <div class="faq-wrapper">
                    @foreach ($event->faqs as $i => $faq)
                        @if ($loop->first)
                            <div class="border-b border-gray-100 faq-item">
                                <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                    <h3 class="text-lg font-semibold">{{ $faq['question'] }}</h3>
                                    <span class="text-gray-500">
                                        <i class="fa-solid fa-minus faq-expand-collapse-icon"></i>
                                    </span>
                                </div>
                                <div class="faq-answer-wrapper">
                                    <p class="py-4 pr-4 text-gray-700">{!! $faq['answer'] !!}</p>
                                </div>
                            </div>
                        @else
                            <div class="border-b border-gray-100 faq-item">
                                <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                    <h3 class="text-lg font-semibold">{{ $faq['question'] }}</h3>
                                    <span class="text-gray-500">
                                        <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                    </span>
                                </div>
                                <div class="faq-answer-wrapper hide-faq-answer">
                                    <p class="py-4 pr-4 text-gray-700">{!! $faq['answer'] !!}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <!-- Faq Ends Here -->
        @endif


        <div style="margin-top: 4.5rem;">
            <h2 class="text-2xl font-bold my-5 text-black capitalize">More Events From This Organizer</h2>

            <div id="events-list" class="landscape-card-wrapper">
                @foreach ($event->organizer?->events->take(4) as $item)
                    <x-card :event="$item" varient="list" />
                @endforeach
            </div>

            @if ($event->organizer?->events->count() > 4)
                <div class="flex justify-center" style="margin-top: 1.5rem;">
                    <button id="load-more-btn" class="bg-primary text-white px-4 py-1 rounded-[4px]">Read More</button>
                </div>
            @endif
        </div>


        @if ($event->category?->events->where('id', '!=', $event->id)->count() > 0)
            <div style="margin-top: 4.5rem;">
                <h2 class="text-2xl font-bold my-5 text-black capitalize">Other Events You may Like</h2>

                <div class="other-events-slider-wrapper">
                    <div class="other-events-slider-next"><i class="fa-solid fa-arrow-right"></i></div>
                    <div class="other-events-slider-prev"><i class="fa-solid fa-arrow-left"></i></div>
                    <div class="swiper other-events-slider" style="padding: 1rem 0.5rem;">
                        <div class="swiper-wrapper">
                            @foreach ($event->category?->events->where('id', '!=', $event->id) as $item)
<div class="swiper-slide">
                            <x-card :event="$item" />
                        </div>
@endforeach
                    </div>
                </div>
            </div>
        </div>
@endif
        
        
    </div>
    <aside class="event-detail-right rounded-[4px] lg:sticky lg:top-52 py-10 px-7 min-w-[100%] lg:min-w-80" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
        <div class="border-b border-slate-300 my-4">
            <h2 class="text-nowrap border-b-2 border-primary w-fit">Event details</h2>
        </div>

        <div class="mb-4">
            <h5 class="mb-1 font-semibold">Event title</h5>
            <p>{{ $event->title }}</p>
        </div>

        @if ($event->next_slot && $event->type === 'pass')
<div class="mb-4">
                <h5 class="mb-1 font-semibold">Starts At</h5>
                <p>{{ "{$event->next_slot?->start_date?->format('D, M j')}, {$event->next_slot?->start_time?->format('h:i A')}" }}</p>
            </div>
            <div class="mb-4">
                <h5 class="mb-1 font-semibold">End At</h5>
                <p>{{ "{$event->next_slot?->end_date?->format('D, M j')}, {$event->next_slot?->end_time?->format('h:i A')}" }}</p>
            </div>
            <div class="mb-4">
                <h5 class="mb-1 font-semibold">Duration</h5>
               @php
                   // Assuming that $event->next_slot->start_date and $event->next_slot->start_time are available
                   $start = \Carbon\Carbon::parse("{$event->next_slot->start_date->format('Y-m-d')} {$event->next_slot->start_time?->format('h:i A')}");
                   $end = \Carbon\Carbon::parse("{$event->next_slot->end_date->format('Y-m-d')} {$event->next_slot->end_time?->format('h:i A')}");
                   $duration = $start->diff($end); // Calculate the difference
               @endphp
                <p>{{ $duration }}</p> <!-- Format the duration -->



            </div>
@else
<div class="mb-4">
                <h5 class="mb-1 font-semibold">Starts At</h5>
                <p>{{ "{$event->next_slot?->date?->format('D, M j')}, {$event->next_slot?->start_time?->format('h:i A')}" }}</p>
            </div>
            <div class="mb-4">
                <h5 class="mb-1 font-semibold">End At</h5>
                <p>{{ "{$event->next_slot?->date?->format('D, M j')}, {$event->next_slot?->end_time?->format('h:i A')}" }}</p>
            </div>
            <div class="mb-4">
                <h5 class="mb-1 font-semibold">Duration</h5>
                <p> {{ $event->next_slot?->start_time?->diff($event->next_slot?->end_time) }}</p>
            </div>
@endif
        <div class="mb-4">
            <h5 class="mb-1 font-semibold">Venue</h5>
            <p>{{ $event->venue }}</p>
        </div>
        <div class="mb-4">
            <h5 class="mb-1 font-semibold">Location</h5>
            <a href="@if ($event->venue_map) {{ $event->venue_map }} @else https://www.google.com/maps/place/{{ $event->address }} @endif"
                target="_blank">{{ $event->address }}</a>
        </div>
        <div class="flex justify-start items-center gap-3">
            @php $ticket = \Illuminate\Support\Facades\Crypt::encrypt($event->slug); @endphp
            @if ($event->next_slot && $event->paid_tickets !== null && $event->paid_tickets > 0)
                @if (!(Auth::check() && Auth::user()->role == \App\Enums\Role::SUPERADMIN && Route::currentRouteName() === 'admin.events.show'))
                    <a href="{{ route('ticket.booking', $ticket) }}" class="w-full bg-primary text-white px-4 py-1 rounded-[4px] ticket_booking">
                        Buy Ticket
                    </a>
                @endif
                {{-- <button type="button" onclick="showCheckoutModel()" data-slug="{{ $event->slug }}"
                        class="w-full bg-primary text-white px-4 py-1 rounded-[4px] ticket_booking">
                    Buy Ticket
                </button> --}}
            @elseif(!$event->next_slot)
                <button type="button" disabled class="w-full bg-gray text-white px-4 py-1 rounded-[4px] opacity-50 select-none">
                    Event completed
                </button>
            @else
                <button type="button" disabled class="w-full bg-gray text-white px-4 py-1 rounded-[4px] opacity-50 select-none">
                    Sold Out
                </button>
            @endif
            @if (Auth::user()?->role === \App\Enums\Role::SUPERADMIN || Auth::id() === $event->organizer_id)
                <a class="w-full bg-primary text-white px-4 py-1 rounded-[4px]" href="{{ route('download.qr.code', $event->slug) }}">Download QR Code</a>
            @endif
            <button class="w-[10%] px-4 py-1 rounded-[4px] flex items-center justify-center" onclick="openShareModal(this, '{{ route('events.index', $event->slug) }}')">
                <span class="fa-solid fa-share-nodes"></span>
            </button>
        </div>
        <div class="mt-4">
            <h5 class="mb-1 font-semibold">Amenities</h5>
        </div>
        <div class="display-amenities mb-4">
            @foreach($event->amenities as $amenity)
                <div class="item">
                    <img src="{{ asset("uploads/amenities/{$amenity->image}") }}"  title="{{ $amenity->name }}" alt="{{ $amenity->name }}">
                </div>
            @endforeach
        </div>
    </aside>
</section>

@include('models.share')

@push('detailJs')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
            <script src="https://unpkg.com/@geoapify/leaflet-geocoder/dist/leaflet-geocoder.min.js"></script>
            <script src="{{ asset('asset/js/swiper-v11/swiper-bundle.min.js') }}"></script>
            <script src="{{ asset('asset/js/swiper-v11/settings.js') }}"></script>
            <script>
                $(document).ready(function() {
                    handleFaq();
                })

                function ajaxLoader(selector, text) {
                    $(selector).html('<div class="ajax-loader"><i class="fa-solid fa-spinner fa-pulse"></i></div>');
                    $(document).one('ajaxStop', function() {
                        $(selector).html(text);
                    });
                }

                const GEOAPIFY_API = `{{ env('GEOAPIFY_API') }}`;

                // Get the address from the #map element's data-address attribute
                const mapElement = document.getElementById('map');
                const address = mapElement.getAttribute('data-address');
                const faviconUrl = mapElement.getAttribute('data-favicon-url');
                // Initialize the map with default coordinates and zoom level
                const map = L.map('map').setView([0, 0], 2);


                // Add tile layer with Geoapify API
                L.tileLayer(`https://maps.geoapify.com/v1/tile/osm-carto/{z}/{x}/{y}.png?apiKey=${GEOAPIFY_API}`, {
                    maxZoom: 19,
                }).addTo(map);

                // Function to get coordinates based on the address
                async function getCoordinates(address) {
                    const url = `https://api.geoapify.com/v1/geocode/search?text=${encodeURIComponent(address)}&apiKey=${GEOAPIFY_API}`;
                    const response = await fetch(url);
                    const data = await response.json();
                    if (data && data.features.length > 0) {
                        return data.features[0].geometry.coordinates;
                    }
                    return null;
                }

                // Custom marker icon
                const customIcon = L.divIcon({
                    html: `
            <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="imagePattern" patternUnits="userSpaceOnUse" width="32" height="32">
                        <image href="${faviconUrl}" x="0" y="0" width="32" height="32" />
                    </pattern>
                </defs>
                <path d="M16 0C9.373 0 4 5.373 4 12c0 9.373 12 20 12 20s12-10.627 12-20c0-6.627-5.373-12-12-12z" fill="url(#imagePattern)"/>
                <circle cx="16" cy="12" r="5" fill="white" fill-opacity="0" stroke="white" stroke-width="5"/>
            </svg>
        `,
                    iconSize: [32, 32],
                    className: 'custom-marker'
                });

                // Get the coordinates for the address and add a marker to the map
                getCoordinates(address).then(coords => {
                    if (coords) {
                        const marker = L.marker([coords[1], coords[0]], {
                            icon: customIcon
                        }).addTo(map);
                        marker.bindPopup(`<b>${address}</b>`);
                        map.setView([coords[1], coords[0]], 15); // Set view to the found coordinates with zoom level 15
                    } else {
                        console.error('Coordinates not found for the given address.');
                    }
                }).catch(error => {
                    console.error('Error fetching coordinates:', error);
                });

                function handleFollowWithoutLogin(e, name) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Sign in to follow ' + name,
                        text: 'Stay up on the latest from your favorite event organizers'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('store.intended.url') }}",
                                data: {
                                    url: window.location.href,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function() {
                                    window.location.href = "{{ route('admin.login') }}";
                                }
                            });
                        }
                    });
                }

                function handleFollow(e, id) {
                    e.preventDefault();
                    ajaxLoader('.follow-button', 'Follow');

                    $.ajax({
                        type: "POST",
                        url: `{{ route('admin.follow', ':id') }}`.replace(':id', id),
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Reload the page after clicking the "OK" button
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                        }
                    });
                }

                function handleUnfollow(e, id) {
                    e.preventDefault();
                    ajaxLoader('.follow-button', 'Unfollow');

                    $.ajax({
                        type: "POST",
                        url: `{{ route('admin.unfollow', ':id') }}`.replace(':id', id),
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Reload the page after clicking the "OK" button
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                        }
                    });
                }

                const otherEventsSlider = new Swiper('.other-events-slider', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    freeMode: true,
                    preventClicks: false,
                    breakpoints: {
                        550: {
                            slidesPerView: 2
                        },
                        800: {
                            slidesPerView: 2
                        },
                        1000: {
                            slidesPerView: 3
                        }
                    },
                    navigation: {
                        nextEl: ".other-events-slider-next",
                        prevEl: ".other-events-slider-prev",
                        disabledClass: "swiper-button-disabled"
                    }
                });

                $(document).ready(function() {
                    let currentPage = 1; // Start at page 1
                    const eventId = "{{ $event->id }}"; // Get the current event ID
                    const loadMoreBtn = $("#load-more-btn");
                    const eventsList = $("#events-list");


                    loadMoreBtn.on("click", function() {
                        ajaxLoader(loadMoreBtn, 'Read More');
                        $.ajax({
                            url: "{{ route('load.more.events') }}",
                            type: "POST",
                            data: {
                                event_id: eventId,
                                page: currentPage,
                                _token: "{{ csrf_token() }}"
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data.html.length > 0) {
                                    data.html.forEach(function(html) {
                                        eventsList.append(html);
                                    });
                                    currentPage = data.nextPage;
                                }

                                if (!data.hasMore) {
                                    loadMoreBtn.remove(); // Remove button if no more events
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error loading events:", error);
                            }
                        });
                    });
                });
            </script>
@endpush
)
