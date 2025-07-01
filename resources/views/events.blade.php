@extends('layout.front')
@push('title')
    <title>{{ $meta->meta_title }}</title>
    <meta name="keywords" content="{{ $meta->meta_keywords }}"/>
    <meta name="description" content="{{ $meta->meta_description }}"/>
@endpush
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
@endpush
@section('main')
    <section class="mt-36 max-w-[1800px] mx-auto w-full transition">
        <form action="{{ route('events.index') }}" method="GET" class="my-4 px-2 filter-form">
            <div class="justify-center items-center px-6">
                <h2 class="text-2xl font-bold screen768:text-3xl my-5 text-black capitalize flex-wrap">
                    @if(request()->city)
                        @php $city = \App\Models\City::where('name', request()->city)->first(); @endphp
                        @if($city) {{ $city->heading }} @else Caribbean Events and Parties in {{ request()->city }} @endif
                    @else
                        Caribbean Events and Parties
                    @endif
                </h2>
                <div class="flex justify-between items-center">
                    <button class="text-white text-nowrap font-medium text-sm bg-black text-white px-4 py-1 rounded-[4px]">Apply Filter</button>
                    <a class="text-primary font-medium text-nowrap text-xs" href="{{ route('events.index') }}">Clear Filter</a>
                </div>
            </div>
            <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-lg mb-10">
                <div class="flex justify-center items-center gap-3 flex-col clear-filter-wrapper">
                    <div class="w-full search-wrapper">
                        <div class="relative">
                            <input type="text" name="category" value="{{ request()->category }}" placeholder="Event category..."
                                   class="search-input filter-input block w-full px-3 py-2 border border-gray-300 focus:outline-none sm:text-sm capitalize"/>
                            <ul class="absolute z-10 w-full mt-2 bg-white border border-gray-300 rounded-sm shadow-lg max-h-56 overflow-auto dropdown-items-wrapper hidden"
                                id="cityDropdown">
                                @foreach ($categories as $category)
                                    <li class="dropdown-item px-4 py-2 cursor-pointer hover:bg-gray-100">{{ $category->title }}
                                    </li>
                                @endforeach
                                <div class="no-item hidden">
                                    <p class="px-4 py-2 cursor-pointer hover:bg-gray-100">No Results Found</p>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="w-full search-wrapper">
                        <div class="relative">
                            <input type="text" name="title" value="{{ request()->title }}" placeholder="Search Event"
                                   class="search-input filter-input block w-full px-3 py-2 border border-gray-300 focus:outline-none sm:text-sm"/>
                            <ul class="absolute z-10 w-full mt-2 bg-white border border-gray-300 rounded-sm shadow-lg max-h-56 overflow-auto dropdown-items-wrapper hidden"
                                id="cityDropdown">
                                @foreach ($searchEvents as $searchEvent)
                                    <li class="dropdown-item px-4 py-2 cursor-pointer hover:bg-gray-100">{{ $searchEvent->title }}
                                    </li>
                                @endforeach
                                <div class="no-item hidden">
                                    <p class="px-4 py-2 cursor-pointer hover:bg-gray-100">No Results Found</p>
                                </div>
                            </ul>
                        </div>

                    </div>
                    <div class="w-full search-wrapper">
                        <div class="relative">
                            <input type="text" name="city" value="{{ request()->city }}" placeholder="Search city..."
                                   class="search-input filter-input block w-full px-3 py-2 border border-gray-300 focus:outline-none sm:text-sm"/>
                            <ul class="absolute z-10 w-full mt-2 bg-white border border-gray-300 rounded-sm shadow-lg max-h-56 overflow-auto dropdown-items-wrapper hidden"
                                id="cityDropdown">
                                @foreach ($searchCities as $searchCity)
                                    <li class="dropdown-item px-4 py-2 cursor-pointer hover:bg-gray-100">{{ $searchCity->name }}</li>
                                @endforeach
                                <div class="no-item hidden">
                                    <p class="px-4 py-2 cursor-pointer hover:bg-gray-100">No Results Found</p>
                                </div>
                            </ul>
                        </div>

                    </div>
                    <div class="w-full">
                        <input type="date" value="{{ request()->date }}" name="date" id="date"
                               class="filter-input block w-full px-3 py-2 border border-gray-300 focus:outline-none sm:text-sm"/>
                    </div>
                </div>
            </div>
        </form>

        <div class="flex flex-col-reverse sm:flex-row justify-start items-start gap-4 sm:relative">
            <section class="w-full">
                <div class="gap-6 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2">
                    @forelse ($events as $event)
                        <x-card :event="$event"/>
                    @empty
                        <p>No events found</p>
                    @endforelse
                </div>
                {{ $events->links('vendor.pagination.custom') }}
            </section>
            <!-- Filter Section Starts Here -->
            <section class="w-11/12 mx-auto sm:w-full sm:h-[100vh] sm:sticky sm:top-0">
                <div class="mx-auto w-11/12 sm:w-full sm:h-[100vh]" id="map"></div>
            </section>
            <!-- Filter Section Ends Here -->
        </div>
    </section>
    <div class="map_img" data-favicon-url="{{ asset('/' . $data->favicon) }}"></div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/esri-leaflet-geocoder/3.1.5/esri-leaflet-geocoder-debug.min.js"></script>
    <script>
        const GEOAPIFY_API = `{{ env('GEOAPIFY_API') }}`;
        const map = L.map('map').setView([0, 0], 2);

        L.tileLayer(`https://maps.geoapify.com/v1/tile/osm-carto/{z}/{x}/{y}.png?apiKey=${GEOAPIFY_API}`, {
            maxZoom: 19,
        }).addTo(map);

        const paginatedEvents = {!! json_encode($events) !!};
        const events = paginatedEvents.data;

        async function getCoordinates(address) {
            const url = `https://api.geoapify.com/v1/geocode/search?text=${encodeURIComponent(address)}&apiKey=${GEOAPIFY_API}`;
            const response = await fetch(url);
            const data = await response.json();
            if (data && data.features.length > 0) {
                return data.features[0].geometry.coordinates;
            }
            return null;
        }

        const faviconUrl = document.querySelector('.map_img').getAttribute('data-favicon-url');

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


        let bounds = [];
        events.forEach(async event => {
            const coords = await getCoordinates(event.address);
            if (coords) {
                const marker = L.marker([coords[1], coords[0]], {icon: customIcon}).addTo(map);
                marker.bindPopup(`<b>${event.name}</b><br>${event.address}`);
                bounds.push([coords[1], coords[0]]);
            }
            if (bounds.length === events.length) {
                map.fitBounds(bounds);
            }
        });
    </script>

    @if($errors->hasBag('payment'))
        <script>
            showCheckoutModel();
        </script>
    @endif
    
    <script>
        /*$(document).ready(function () {
            $('.filter-form').on('submit', function (e) {
                $(this).find('input, select').each(function () {
                    if ($(this).data('original-name')) {
                        $(this).attr('name', $(this).data('original-name'));
                    }

                    if (!$(this).data('original-name')) {
                        $(this).data('original-name', $(this).attr('name'));
                    }

                    if (!$(this).val()) {
                        $(this).removeAttr('name');
                    }
                });
            });
        });*/
        $(document).ready(function () {
            $('.filter-form').on('submit', function (e) {
                // Customization for city to route parameter
                const cityInput = $(this).find('input[name="city"]');
                const cityValue = cityInput.val().trim();

                if (cityValue) {
                    // Update the form's action dynamically with the city as a route parameter
                    const baseUrl = '{{ url('/') }}'; // Laravel base URL
                    $(this).attr('action', `${baseUrl}/${encodeURIComponent(cityValue)}`);
                    cityInput.removeAttr('name');
                }

                // Existing functionality to handle names and empty fields
                $(this).find('input, select').each(function () {
                    if ($(this).data('original-name')) {
                        $(this).attr('name', $(this).data('original-name'));
                    }

                    if (!$(this).data('original-name')) {
                        $(this).data('original-name', $(this).attr('name'));
                    }

                    if (!$(this).val()) {
                        $(this).removeAttr('name');
                    }
                });
            });
        });


    </script>
@endpush
