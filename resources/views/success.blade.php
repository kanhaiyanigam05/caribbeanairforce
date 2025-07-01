<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meta->meta_title }}</title>
    <meta name="keywords" content="{{ $meta->meta_keywords }}" />
    <meta name="description" content="{{ $meta->meta_description }}" />

    <link rel="icon" href="{{ asset('/' . $data->favicon) }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('/' . $data->favicon) }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('/' . $data->favicon) }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/tailwind/styles.css') }}">
    <style>
        * {
            font-family: "Barlow", sans-serif
        }

        @media print {
            .download-button {
                display: none;
            }
        }

        .display-amenities {
            display: flex;
            justify-content: center;
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
            border-radius: 50% filter: grayscale(0);
        }
    </style>
</head>
{{-- @dd($slots) --}}

<body>
    <section class="m-auto flex justify-center items-center">
        <div class="max-w-[500px]">
            <div class="relative flex flex-col bg-white shadow-lg rounded-xl pointer-events-auto dark:bg-neutral-800">
                <div class="relative min-h-32 bg-gray-900 text-center rounded-t-xl dark:bg-neutral-950">
                    <figure class="h-1/5">
                        <img class="select-none w-full object-cover" src="{{ $booking?->event?->image }}" alt="banner"
                            draggable="false">
                    </figure>
                </div>

                <div class="relative z-10 -mt-12">
                    <span
                        class="mx-auto flex justify-center items-center size-[72px] rounded-full border border-gray-200 bg-white text-gray-700 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                        <img class="select-none object-cover" src="{{ asset($data?->logo) }}" alt="logo"
                            title="Unifying Caribbean People Socially Mentally $ Economically" draggable="false">
                    </span>
                </div>

                <div class="p-4 sm:p-7 overflow-y-auto">
                    <div class="flex justify-between items-center">
                        <div class="text-center">
                            <h3 id="hs-ai-modal-label" class="text-lg text-gray-800 dark:text-neutral-200">
                                Event Name:
                                <span class="font-semibold">{{ $booking?->event?->title }}</span>
                            </h3>
                            <p class="text-xs lg:text-sm text-gray-500 dark:text-neutral-500 text-left">
                                Event starts from:
                                <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200">
                                    @if (isset($slots[0]['date']))
                                        {{ \Carbon\Carbon::parse($slots[0]['date'])->format('F j, Y') . ', ' . \Carbon\Carbon::parse($slots[0]['time'][0]['start_time'])->format('h:i A') }}
                                    @elseif(isset($slots[0]['start_date']))
                                        {{ \Carbon\Carbon::parse($slots[0]['start_date'])->format('F j, Y') . ', ' . \Carbon\Carbon::parse($slots[0]['time'][0]['start_time'])->format('h:i A') }}
                                    @endif
                                </span>
                            </p>
                        </div>
                        <p class="text-xs font-medium lg:text-sm text-gray-500 dark:text-neutral-500 text-right">
                            {{ $ticket ? 'Ticket' : 'Pass' }}
                            <span>#{{ $booking?->ticket_id }}</span>
                        </p>
                    </div>

                    <div class="mt-5 sm:mt-10 grid grid-cols-2 sm:grid-cols-2 gap-5">


                        @if ((float) $booking->total == 0)
                            <div>
                                <span class="block text-xs uppercase text-black dark:text-white font-semibold">Booking Date:</span>
                                <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200 ">{{ $booking?->created_at?->format('F j, Y, h:i A') }}</span>
                            </div>
                        @else
                            <div>
                                <span class="block text-xs uppercase text-black dark:text-white font-semibold">Amount
                                    paid:</span>
                                <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200">
                                    {{ '$ ' . $booking?->total }}
                                </span>
                            </div>
                            <div class="text-end">
                                <span class="block text-xs uppercase text-black dark:text-white font-semibold">Booking Date:</span>
                                <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200 ">{{ $booking?->created_at?->format('F j, Y, h:i A') }}</span>
                            </div>
                            <div>
                                <span class="block text-xs uppercase text-black dark:text-white font-semibold">Payment
                                    method:</span>
                                <div class="flex items-center gap-x-2">
                                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48">
                                        <g clip-path="url(#a)">
                                            <path fill="#002991"
                                                d="M38.914 13.35c0 5.574-5.144 12.15-12.927 12.15H18.49l-.368 2.322L16.373 39H7.056l5.605-36h15.095c5.083 0 9.082 2.833 10.555 6.77a9.687 9.687 0 0 1 .603 3.58z" />
                                            <path fill="#60CDFF"
                                                d="M44.284 23.7A12.894 12.894 0 0 1 31.53 34.5h-5.206L24.157 48H14.89l1.483-9 1.75-11.178.367-2.322h7.497c7.773 0 12.927-6.576 12.927-12.15 3.825 1.974 6.055 5.963 5.37 10.35z" />
                                            <path fill="#008CFF"
                                                d="M38.914 13.35C37.31 12.511 35.365 12 33.248 12h-12.64L18.49 25.5h7.497c7.773 0 12.927-6.576 12.927-12.15z" />
                                        </g>
                                        <defs>
                                            <clipPath id="a">
                                                <path fill="#fff" d="M7.056 3h37.35v45H7.056z" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200">
                                        {{ \App\Helpers\Setting::maskEmail($booking?->email) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-5 sm:mt-10">
                        <h4 class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Summary</h4>
                        <ul class="mt-3 flex flex-col">
                            @php $paidAmount = 0; @endphp
                            @foreach ($booking?->slots as $slot)
                                @php $slot = (object) $slot; @endphp
                                <li
                                    class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                                    <div class="flex items-center justify-between w-full font-semibold">
                                        @if (property_exists($slot, 'date') && $slot->date)
                                            <span>{{ \Carbon\Carbon::parse($slot->date)->format('F j, Y') }}</span>
                                        @elseif(property_exists($slot, 'start_date') && $slot->start_date)
                                            <span>{{ \Carbon\Carbon::parse($slot->start_date)->format('F j, Y') . ' - ' . \Carbon\Carbon::parse($slot->end_date)->format('F j, Y') }}</span>
                                        @endif
                                        <span>{{ \Carbon\Carbon::parse($slot->time[0]['start_time'])->format('H:i A') . ' - ' . \Carbon\Carbon::parse($slot->time[0]['end_time'])->format('H:i A') }}</span>
                                    </div>
                                </li>
                                @foreach ($slot->packages as $package)
                                    @php
                                        $package = (object) $package;
                                        $paidAmount += $package->type === 'paid' ? (int) $package->qty * (int) $package->price : 0;
                                    @endphp
                                    <li
                                        class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                                        <div class="flex items-center justify-between w-full">
                                            <span>{{ "{$package->name} x {$package->qty}" }}</span>
                                            <span>{{ "$ " . (int) $package->qty * (int) $package->price }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                        <ul class="mt-3 flex flex-col">
                            <li
                                class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
                                <div class="flex items-center justify-between w-full">
                                    <span class="font-semibold">Total {{ $ticket ? 'Tickets' : 'Passes' }}</span>
                                    <span>{{ $booking?->tickets }}</span>
                                </div>
                            </li>
                            @php
                                $donation = number_format((int) $booking->total - $paidAmount, 2);
                            @endphp
                            {{-- @dd($booking?->slots, $paidAmount, $booking->total, $donation) --}}
                            @if ($donation > 0)
                                <li
                                    class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold bg-gray-50 border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200">
                                    <div class="flex items-center justify-between w-full">
                                        <span>Donation</span>
                                        <span>{{ "\$ $donation" }}</span>
                                    </div>
                                </li>
                            @endif
                            @if ($paidAmount >= 0)
                                <li
                                    class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold bg-gray-50 border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200">
                                    <div class="flex items-center justify-between w-full">
                                        <span>Sub-Total</span>
                                        <span>{{ '$ ' . $paidAmount }}</span>
                                    </div>
                                </li>
                            @endif
                            @if ((int) $booking?->total >= 0)
                                <li
                                    class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold bg-gray-50 border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200">
                                    <div class="flex items-center justify-between w-full">
                                        <span>Total</span>
                                        <span>{{ '$ ' . $booking?->total }}</span>
                                    </div>
                                </li>
                            @endif
                        </ul>
                        @if ($booking?->event?->amenities->isNotEmpty())
                            <div class="">
                                <div class="flex items-center justify-center gap-x-2 mt-4">
                                    <h5 class="mb-1 font-semibold dark:text-white">Amenities</h5>
                                </div>
                                <div class="display-amenities mb-4 mt-3">
                                    @foreach ($booking?->event?->amenities as $amenity)
                                        <div class="item">
                                            <img src="{{ asset("uploads/amenities/{$amenity->image}") }}" title="{{ $amenity->name }}" alt="{{ $amenity->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-5 sm:mt-10">
                        <h4 class="text-xs text-center font-semibold uppercase text-gray-800 dark:text-neutral-200">Add To Calendar</h4>
                        <div class="flex items-center justify-center gap-x-2 mt-3">
                            <!-- Google Calendar Button -->
                            <a href="https://www.google.com/calendar/render?action=TEMPLATE&text={{ $booking?->event?->name }}&dates={{ $booking?->created_at }}&details={{ $booking?->event?->description }}.&location={{ "{$booking?->event?->venue}, {$booking?->event?->address}" }}&sf=true&output=xml"
                                target="_blank">
                                <svg class="w-10 h-10" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg" version="1.1" id="svg2" width="150" height="150" viewBox="0 0 150 150"
                                    sodipodi:docname="7123030_google_calendar_icon.ai">
                                    <defs id="defs6" />
                                    <sodipodi:namedview id="namedview4" pagecolor="#ffffff" bordercolor="#000000" borderopacity="0.25" inkscape:showpageshadow="2" inkscape:pageopacity="0.0"
                                        inkscape:pagecheckerboard="0" inkscape:deskcolor="#d1d1d1" />
                                    <g id="g8" inkscape:groupmode="layer" inkscape:label="7123030_google_calendar_icon" transform="matrix(1.3333333,0,0,1.3333333,0,3.75e-6)">
                                        <g id="g10">
                                            <path
                                                d="m 59.398,50.398 1.95,2.774 3,-2.176 v 15.75 h 3.226 V 46.051 h -2.699 z m -5.171,5.403 c 1.199,-1.051 1.949,-2.625 1.949,-4.274 0,-3.3 -2.926,-6 -6.449,-6 -3,0 -5.625,1.875 -6.301,4.649 L 46.574,51 c 0.301,-1.273 1.649,-2.176 3.149,-2.176 1.8,0 3.226,1.199 3.226,2.699 0,1.5 -1.426,2.7 -3.226,2.7 h -1.875 v 3.3 h 1.875 c 2.023,0 3.75,1.426 3.75,3.075 0,1.726 -1.649,3.074 -3.676,3.074 -1.801,0 -3.375,-1.125 -3.602,-2.699 l -3.148,0.523 c 0.523,3.074 3.449,5.399 6.824,5.399 3.824,0 6.899,-2.852 6.899,-6.375 -0.075,-1.875 -1.051,-3.602 -2.551,-4.727 z"
                                                style="fill:#1e88e5;fill-opacity:1;fill-rule:nonzero;stroke:none" id="path12" />
                                            <path d="M 75.148,90.227 H 37.352 V 75.152 h 37.8 z" style="fill:#fbc02d;fill-opacity:1;fill-rule:nonzero;stroke:none" id="path14" />
                                            <path d="M 90.227,75.148 V 37.352 H 75.152 v 37.8 z" style="fill:#4caf50;fill-opacity:1;fill-rule:nonzero;stroke:none" id="path16" />
                                            <path d="M 75.148,37.352 V 22.273 h -47.25 c -3.148,0 -5.699,2.551 -5.699,5.7 v 47.25 H 37.273 V 37.352 Z"
                                                style="fill:#1e88e5;fill-opacity:1;fill-rule:nonzero;stroke:none" id="path18" />
                                            <path d="M 75.148,75.148 V 90.223 L 90.223,75.148 Z" style="fill:#e53935;fill-opacity:1;fill-rule:nonzero;stroke:none" id="path20" />
                                            <path
                                                d="m 84.602,22.273 h -9.45 v 15.075 h 15.075 v -9.45 c 0,-3.148 -2.477,-5.625 -5.625,-5.625 z M 27.898,90.227 h 9.45 V 75.152 L 22.273,75.148 v 9.45 c 0,3.148 2.477,5.625 5.625,5.625 z"
                                                style="fill:#1565c0;fill-opacity:1;fill-rule:nonzero;stroke:none" id="path22" />
                                        </g>
                                    </g>
                                </svg>
                            </a>

                            <!-- Download for Outlook Calendar -->
                            <a href="https://outlook.live.com/calendar/action/compose?rru=addevent&startdt={{ $booking?->created_at }}&enddt={{ $booking?->created_at }}&subject={{ $booking?->event?->name }}&location={{ "{$booking?->event?->venue}, {$booking?->event?->address}" }}&body={{ $booking?->event?->description }}"
                                target="_blank">
                                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px">
                                    <path fill="#1976d2" d="M28,13h14.533C43.343,13,44,13.657,44,14.467v19.066C44,34.343,43.343,35,42.533,35H28V13z" />
                                    <rect width="14" height="15.542" x="28" y="17.958" fill="#fff" />
                                    <polygon fill="#1976d2" points="27,44 4,39.5 4,8.5 27,4" />
                                    <path fill="#fff"
                                        d="M15.25,16.5c-3.176,0-5.75,3.358-5.75,7.5s2.574,7.5,5.75,7.5S21,28.142,21,24 S18.426,16.5,15.25,16.5z M15,28.5c-1.657,0-3-2.015-3-4.5s1.343-4.5,3-4.5s3,2.015,3,4.5S16.657,28.5,15,28.5z" />
                                    <rect width="2.7" height="2.9" x="28.047" y="29.737" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="31.448" y="29.737" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="34.849" y="29.737" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="28.047" y="26.159" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="31.448" y="26.159" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="34.849" y="26.159" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="38.25" y="26.159" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="28.047" y="22.706" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="31.448" y="22.706" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="34.849" y="22.706" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="38.25" y="22.706" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="31.448" y="19.112" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="34.849" y="19.112" fill="#1976d2" />
                                    <rect width="2.7" height="2.9" x="38.25" y="19.112" fill="#1976d2" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="mt-5 flex justify-end gap-x-2">
                        <button
                            class="download-button py-2 px-3 inline-flex transition-all items-center gap-x-2 text-sm font-medium rounded-sm border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800"
                            onclick="printTicket()">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" x2="12" y1="15" y2="3"></line>
                            </svg>
                            Download {{ $ticket ? 'Ticket' : 'Pass' }}
                        </button>
                    </div>
                    <!-- Button -->
                    {{-- <form method="POST" action="{{ route('download.ticket', $booking->ticket_id) }}"
                        class="mt-5 flex justify-end gap-x-2">
                        @csrf
                        <button
                            class="download-button py-2 px-3 inline-flex transition-all items-center gap-x-2 text-sm font-medium rounded-sm border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800"
                            onclick="printTicket()">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" x2="12" y1="15" y2="3"></line>
                            </svg>
                            Download Ticket
                        </button>
                    </form> --}}

                    <div class="mt-5 sm:mt-10">
                        <p class="text-sm text-gray-500 dark:text-neutral-500 text-center">If you have any questions,
                            please contact us on call at <a
                                class="inline-flex items-center gap-x-1.5 text-primary decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-primary"
                                href="tel:{{ $data?->phone }}">{{ $data?->phone }}</a> or <a
                                class="inline-flex items-center gap-x-1.5 text-primary decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-primary"
                                href="mailto:{{ $data?->email }}">{{ $data?->email }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('sweetalert::alert')
    <script>
        function printTicket() {
            window.print();
        }
    </script>
</body>

</html>
