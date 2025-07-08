@props(['event' => [], 'admin' => false, 'editable' => false, 'isSuperAdmin' => false, 'varient' => 'card'])
@php
    if (Route::currentRouteName() === 'events.index') {
        $route = route('events.index', $event->slug);
    } else {
        $route = route('admin.events.show', $event->slug);
    }
@endphp
@if ($varient === 'card')
    <div class="ticket-card-wrapper">
        @if ($admin)
            <a href="{{ route('admin.profile', $event->organizer?->username) }}" class="ticket-card-header-wrapper">
                <div class="ticket-card-header-inner-wrapper">
                    <img class="ticket-card-header-icon" src="{{ $event->organizer?->profile }}" alt="{{ $event->organizer?->full_name }}" draggable="false" />
                    <div class="ticket-card-header-icon-content-wrapper">
                        <p class="ticket-card-header-name">{{ $event->organizer?->full_name }}</p>
                        <p class="ticket-card-header-date"><span>{{ $event->created_at?->format('d M') }}</span> at <span>{{ $event->created_at?->format('H:i') }}</span></p>
                    </div>
                </div>
            </a>
        @endif

        <div class="ticket-card-body-wrapper">
            <div class="ticket-card-body-image-wrapper">
                <a href="{{ $route }}">
                    <img src="{{ $event->image }}" alt="Event image for Weekend Wellness Workshop" draggable="false" />
                </a>
                @if ($editable)
                    <div class="ticket-card-menu-wrapper" onclick="handleTicketCardMenu(this)">
                        <button class="ticket-card-menu-btn" id="event-btn-{{ $event->id }}" aria-label="Menu">
                            <span class="material-symbols-outlined"> more_vert </span>
                        </button>

                        <div class="menu-wrapper">
                            <div class="ticket-card-menu-dropdown main-menu-wrapper">
                                <div class="card-menu-dropdown">
                                    @if ($isSuperAdmin)
                                        <a href="javascript:void(0);"
                                            onclick="handleEventStatus(event, {{ $event->id }}, '{{ \App\Enums\Status::PENDING }}')"
                                            @if ($event->status == \App\Enums\Status::PENDING) class="active" @endif>
                                            <span class="material-symbols-outlined"> pending </span>
                                            <p>Pending</p>
                                        </a>
                                        <a href="javascript:void(0);"
                                            onclick="handleEventStatus(event, {{ $event->id }}, '{{ \App\Enums\Status::ACCEPTED }}')"
                                            @if ($event->status == \App\Enums\Status::ACCEPTED) class="active" @endif>
                                            <span class="material-symbols-outlined"> check </span>
                                            <p>Approve</p>
                                        </a>
                                        <a href="javascript:void(0);"
                                            onclick="handleEventStatus(event, {{ $event->id }}, '{{ \App\Enums\Status::REJECTED }}')"
                                            @if ($event->status == \App\Enums\Status::REJECTED) class="active" @endif>
                                            <span class="material-symbols-outlined"> close </span>
                                            <p>Reject</p>
                                        </a>
                                    @endif
                                    <button type="button" class="edit-menu-btn">
                                        <span class="material-symbols-outlined"> edit </span>
                                        <p>Edit</p>
                                    </button>
                                    @if ($isSuperAdmin)
                                        <a href="javascript:void(0);" onclick="handleEventDelete(event, {{ $event->id }})">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="ticket-card-menu-dropdown edit-menu-wrapper">
                                <div class="card-menu-dropdown">

                                    <div>
                                        <button type="button" class="cards-menu-back-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    <button type="button" onclick="handleCreateEventModalShow(); handleEventFormNextSlide(-1); setEventId({{ $event->id }});">Edit Organizer Info</button>
                                    <button type="button" onclick="handleCreateEventModalShow(); handleEventFormNextSlide(0); setEventId({{ $event->id }});">Edit Event Name</button>
                                    <button type="button" onclick="handleCreateEventModalShow(); handleEventFormNextSlide(1); setEventId({{ $event->id }});">Edit Event Duration</button>
                                    <button type="button" onclick="handleCreateEventModalShow(); handleEventFormNextSlide(2); setEventId({{ $event->id }});">Edit Ticket Pricing</button>
                                    <button type="button" onclick="handleCreateEventModalShow(); handleEventFormNextSlide(3); setEventId({{ $event->id }});">Edit Event Location</button>
                                    <button type="button" onclick="handleCreateEventModalShow(); handleEventFormNextSlide(4); setEventId({{ $event->id }});">Edit Event Description</button>
                                    <button type="button" onclick="handleCreateEventModalShow(); handleEventFormNextSlide(5); setEventId({{ $event->id }});">Edit Banner Image</button>
                                    <button type="button" onclick="handleCreateEventModalShow(); handleEventFormNextSlide(6); setEventId({{ $event->id }});">Edit Event Images</button>
                                    <button type="button" onclick="handleCreateEventModalShow(); handleEventFormNextSlide(7); setEventId({{ $event->id }});">Edit Event Mode</button>
                                </div>
                            </div>
                        </div>


                    </div>
                @endif

                <div class="cards-share-btn-wrapper">
                    <button class="cards-share-btn" onclick="openShareModal(this, '{{ route('events.index', $event->slug) }}')">
                        <span class="material-symbols-outlined">share</span>
                    </button>
                </div>
            </div>

            <div class="cards-content-wrapper">
                <div class="cards-content-date-time-wrapper">
                    <a href="{{ $route }}">
                        <h4 class="cards-content-date">{{ $event->title }}</h4>
                    </a>
                    @if ($event->category)
                        <h5 class="">{{ $event->category?->title }}</h5>
                    @endif
                    @if ($event->next_slot)
                        <p class="cards-content-time">
                            @if ($event->type === 'pass')
                                {{ $event->next_slot ? "{$event->next_slot?->start_date?->format('D, M j')}, {$event->next_slot?->start_time?->format('h:i A')}" : '' }}
                            @else
                                {{ $event->next_slot ? "{$event->next_slot?->date?->format('D, M j')}, {$event->next_slot?->start_time?->format('h:i A')}" : '' }}
                            @endif
                        </p>
                    @endif
                </div>

                <p class="ticket-card-price">$ {{ $event->price }} <span class="text-black">(starts from)</span></p>


                <div class="cards-content-date-time-wrapper">
                    <div class="cards-ticket-followers-wrapper">
                        <div class="cards-ticket-followers-image-wrapper">
                            @foreach ($event->organizer?->followers?->take(3) as $follower)
                                <img class="cards-ticket-followers-image" draggable="false"
                                    src="{{ $follower->profile }}" alt="{{ $follower->full_name }}" />
                            @endforeach
                        </div>
                        @php $totalFollowers = $event->organizer?->followers?->count(); @endphp
                        <p>{{ \App\Helpers\Setting::formatFollowers($totalFollowers) }} follower{{ $totalFollowers > 1 ? 's' : '' }}</p>
                    </div>
                    <div class="cards-ticket-joined-wrapper">
                        <p>{{ \App\Helpers\Setting::formatFollowers($event->bookings_count) }} {{ $event->bookings_count > 1 ? 'people' : 'person' }} joined ðŸ“ˆ</p>
                        <p>{!! $event->paid_tickets <= 10 && $event->paid_tickets > 0 ? $event->paid_tickets . ' Tickets Left' : '' !!} </p>
                        @if ($event->ticket_info)
                            <p>{{ $event->ticket_info }}</p>
                        @endif
                    </div>
                </div>

                <div class="cards-ticket-read-more-wrapper">
                    @php $ticket = \Illuminate\Support\Facades\Crypt::encrypt($event->slug); @endphp
                    @if ($event->paid_tickets !== null && $event->paid_tickets > 0 && $event->next_slot)
                        @if (Auth::check() && Auth::user()->role == \App\Enums\Role::SUPERADMIN)
                            @if (Route::currentRouteName() === 'events.index')
                                <a class="cards-ticket-read-more" href="{{ route('ticket.booking', $ticket) }}">
                                    Buy Ticket
                                </a>
                            @endif
                        @else
                            <a class="cards-ticket-read-more" href="{{ route('ticket.booking', $ticket) }}">
                                Buy Ticket
                            </a>
                        @endif
                        {{-- <button class="cards-ticket-read-more ticket_booking" data-slug="{{ $event->slug }}">
                        Buy Ticket
                    </button> --}}
                    @endif
                    @if (Auth::user()?->role === \App\Enums\Role::SUPERADMIN || Auth::id() === $event->organizer_id)
                        <a class="cards-ticket-read-more" href="{{ route('download.qr.code', $event->slug) }}">Download QR Code</a>
                    @endif
                </div>
            </div>
        </div>

    </div>
@elseif($varient === 'list')
    @once
        @push('css')
            <style>
                .landscape-card-item {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 1rem;
                    border-radius: 4px;
                    transition: box-shadow .24s cubic-bezier(.4, 0, .3, 1), background-color .24s cubic-bezier(.4, 0, .3, 1), -webkit-box-shadow .24s cubic-bezier(.4, 0, .3, 1);
                }

                .landscape-card-item:hover {
                    box-shadow: 0 4px 15px 0 rgba(40, 44, 53, .06), 0 2px 2px 0 rgba(40, 44, 53, .08);
                }

                .landscape-card-item .left-side {
                    display: flex;
                    flex-direction: column;
                    gap: 0.8rem;
                }

                .landscape-card-item .right-side {
                    display: flex;
                    flex-direction: column;
                    gap: 0.8rem;
                }

                .landscape-card-item .right-side img {
                    max-width: 300px;
                    width: 300px;
                    aspect-ratio: 400 / 210;
                    object-fit: cover;
                    border-radius: 4px;
                    user-select: none;
                }

                .landscape-card-item .right-side .share-like {
                    display: flex;
                    justify-content: flex-end;
                    align-items: center;
                    gap: 1rem;
                }

                .landscape-card-item .right-side .share-like button {
                    font-size: 16px;
                    height: 44px;
                    width: 44px;
                    transition: all .4s cubic-bezier(.4, 0, .3, 1);
                    border: 1px solid #dbdae3;
                    border-radius: 50px;
                    padding: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                }

                .landscape-card-item .right-side .share-like button:hover {
                    background-color: #f8f7fa;
                }

                .landscape-card-item .left-side .title {
                    font-size: 18px;
                    font-weight: 600;
                    color: #212121;
                }

                .landscape-card-item .left-side .title:hover {
                    text-decoration: underline;
                }

                .landscape-card-item .left-side .timing {
                    font-size: 14px;
                    color: rgb(189, 25, 31);
                    font-weight: 500;
                }

                .landscape-card-item .left-side .location {
                    font-size: 14px;
                    color: rgb(111, 114, 135);
                    font-weight: 400;
                }

                .landscape-card-item .left-side .left-side-top-wrapper,
                .landscape-card-item .left-side .organizer-wrapper {
                    display: flex;
                    flex-direction: column;
                    gap: 0.35rem;
                }

                .landscape-card-item .left-side .organizer {
                    font-size: 14px;
                    color: rgb(57, 54, 79);
                    font-weight: 600;
                }

                .landscape-card-item .left-side .following-wrapper {
                    display: flex;
                    align-items: center;
                    gap: 1.25rem;
                }

                .landscape-card-item .left-side .following-wrapper i,
                .landscape-card-item .left-side .following-wrapper p {
                    font-size: 14px;
                    color: rgb(57, 54, 79);
                }

                .hidden {
                    display: none;
                }

                @media only screen and (max-width: 700px) {
                    .landscape-card-item {
                        flex-direction: column-reverse;
                        width: 100%;
                    }

                    .landscape-card-item>div {
                        width: 100%;
                    }

                    .landscape-card-item .right-side img {
                        max-width: 100%;
                        width: 100%;
                    }
                }
            </style>
        @endpush
    @endonce
    <div {{ $attributes->merge(['class' => 'landscape-card-item']) }}>
        <div class="">
            <div class="left-side">
                <div class="left-side-top-wrapper">
                    <a href="{{ $route }}" class="title">{{ $event->title }}</a>
                    @if ($event->category)
                        <h5 class="">{{ $event->category?->title }}</h5>
                    @endif
                    <p class="timing">
                        @if ($event->type === 'pass')
                            {{ $event->next_slot ? "{$event->next_slot?->start_date?->format('D, M j')}, {$event->next_slot?->start_time?->format('h:i A')}" : '' }}
                        @else
                            {{ $event->next_slot ? "{$event->next_slot?->date?->format('D, M j')}, {$event->next_slot?->start_time?->format('h:i A')}" : '' }}
                        @endif
                    </p>
                    <p class="location">Little Shop of Stories â€¢ Decatur, GA</p>
                </div>
                <div class="organizer-wrapper">
                    <p class="organizer">{{ $event->organizer?->full_name }}</p>
                    <div class="following-wrapper">
                        <img class="cards-ticket-followers-image" draggable="false" src="{{ $event->organizer?->profile }}" alt="{{ $event->organizer?->full_name }}" />
                        @php $totalFollowers = $event->organizer?->followers?->count(); @endphp
                        <p>{{ \App\Helpers\Setting::formatFollowers($totalFollowers) }} follower{{ $totalFollowers > 1 ? 's' : '' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-side">
            <img src="{{ $event->image }}" alt="{{ $event->title }}" draggable="false" loading="lazy">
            <div class="share-like">
                @php $ticket = \Illuminate\Support\Facades\Crypt::encrypt($event->slug); @endphp
                @if ($event->paid_tickets !== null && $event->paid_tickets > 0 && $event->next_slot)
                    @if (Auth::check() && Auth::user()->role == \App\Enums\Role::SUPERADMIN)
                        @if (Route::currentRouteName() === 'events.index')
                            <a class="cards-ticket-read-more" style="width: fit-content;font-weight: 500;padding: 6px 20px;" href="{{ route('ticket.booking', $ticket) }}">Buy Ticket</a>
                        @endif
                    @else
                        <a class="cards-ticket-read-more" style="width: fit-content;font-weight: 500;padding: 6px 20px;" href="{{ route('ticket.booking', $ticket) }}">Buy Ticket</a>
                    @endif
                    {{-- <button class="cards-ticket-read-more ticket_booking" data-slug="{{ $event->slug }}">Buy Ticket</button> --}}
                @endif
                <button type="button" onclick="openShareModal(this, '{{ route('events.index', $event->slug) }}')"><i class="fa-solid fa-share-nodes"></i></button>
            </div>
        </div>
    </div>
@endif
@once
    @push('modals')
        @include('models.share')
        {{-- @include('models.ticket-booking') --}}
    @endpush
    @push('style')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="{{ asset('admins/css/cards.css') }}">
    @endpush
    @push('script')
        @if ($admin)
            {{-- <script src="{{ asset('asset/js/general.js') }}"></script> --}}
            <script>
                function handleEventDelete(e, id) {
                    e.preventDefault();
                    const btn = $(e.currentTarget).closest('.feed-card-wrapper').find('.feed-card-menu-drop-downmenu-btn').html();
                    ajaxLoader('#event-btn-' + id, btn);
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `{{ route('admin.events.destroy', ':id') }}`.replace(':id', id),
                                type: 'POST',
                                data: {
                                    _method: 'DELETE',
                                    _token: "{{ csrf_token() }}",
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#event-' + id).remove();

                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Your event has been deleted.",
                                            icon: "success",
                                            confirmButtonColor: "#3085d6",
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr);
                                    Swal.fire({
                                        title: "Error!",
                                        text: "There was an error deleting the event.",
                                        icon: "error",
                                        confirmButtonColor: "#3085d6",
                                    });
                                }
                            });
                        }
                    });
                }

                function setEventId(id) {
                    $.ajax({
                        type: 'GET',
                        url: `{{ route('admin.events.edit', ':id') }}`.replace(':id', id),
                        success: function({
                            success,
                            event
                        }) {
                            console.log(event);
                            if (success) {
                                let eventDate, eventStartTime, eventEndTime, defaultPrice = null;

                                // Step 1
                                $form = $('#event-create-form');
                                $form.find('.event-heading-name').html('Edit Event');
                                $form.find('input[name="id"]').val(event.id);
                                $form.find('input[name="organizer_name"]').val(event.organizer_name);
                                $form.find('input[name="organizer_email"]').val(event.organizer_email);
                                $form.find('input[name="organizer_phone"]').val(event.organizer_phone);
                                $form.find('input[name="title"]').val(event.title);
                                $form.find('select[name="category"]').val(event.category_id);
                                $form.find('textarea[name="ticket_info"]').val(event.ticket_info);

                                $form.find('input[name="seating_map"]').val(event.seating_map);
                                $form.find('input[name="seating_plan"]').val(event.seating_plan);
                                // console.log(seatingPlanClass);

                                // seatingPlanClass.setSeatingPlanData(JSON.parse(event.seating_map), event.seating_plan);
                                $form.find('#reserved-seating-switch').prop('checked', event.reserved);
                                switchEditCreateSeatingMapWrapper();

                                // Step 2
                                const validator = new FormValidator();

                                $timing = $form.find('select[name="timing"]');
                                if (event.slots?.length > 0) {

                                    $form.find('select[name="start_time"]').val(event.slots[0].time[0].start_time);
                                    $form.find('select[name="end_time"]').val(event.slots[0].time[0].end_time);
                                    if (event.type === 'ticket') {
                                        $form.find(".type-of-event-btn[value='ticket']").addClass("active").trigger('click');

                                        // $form.find(".type-of-event-btn[value='ticket'] i").addClass("fa fa-check").removeClass("fa-regular fa-circle");
                                        $timing.val(event.timing).trigger('change');

                                        if ($timing.val() === 'single') {
                                            const wrapper = document.querySelector(".custom-calendar-wrapper");
                                            const multiRangeButton = wrapper.querySelector(".calender-input-button");
                                            const calendar = new CustomCalendar(multiRangeButton);
                                            calendar.singleDaySelection();
                                            calendar.setOptions("single-date", {
                                                disablePastDates: false,
                                                selectedDate: event.slots[0].date,
                                            });
                                        } else if ($timing.val() === 'daily') {
                                            const firstDate = event.slots[0].date;
                                            const lastDate = event.slots[event.slots.length - 1].date;
                                            const wrapper = document.querySelector(".custom-calendar-wrapper");
                                            const multiRangeButton = wrapper.querySelector(".calender-input-button");
                                            multiRangeButton.setAttribute("data-calendar-type", "range");
                                            const calendar = new CustomCalendar(multiRangeButton);
                                            calendar.rangeSelection();
                                            calendar.setOptions("range", {
                                                defaultDate: firstDate,
                                                disablePastDates: false,
                                                selectedDates: {
                                                    startDate: firstDate,
                                                    endDate: lastDate,
                                                },
                                            });
                                        } else if ($timing.val() === 'weekly') {
                                            const firstDate = event.slots[0].date;
                                            const lastDate = event.slots[event.slots.length - 1].date;
                                            $form.find('.week-day-select-wrapper').removeClass('hidden');
                                            console.log(new Date(firstDate).getDay());
                                            let daysOfWeek = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
                                            $form.find('select[name="week-day"]').val(daysOfWeek[new Date(firstDate).getDay()]);
                                            const wrapper = document.querySelector(".custom-calendar-wrapper");
                                            const multiRangeButton = wrapper.querySelector(".calender-input-button");
                                            multiRangeButton.setAttribute("data-calendar-type", "range");
                                            const calendar = new CustomCalendar(multiRangeButton);
                                            calendar.rangeSelection();
                                            calendar.setOptions("range", {
                                                defaultDate: firstDate,
                                                disablePastDates: false,
                                                selectedDates: {
                                                    startDate: firstDate,
                                                    endDate: lastDate,
                                                },
                                            });

                                        } else if ($timing.val() === 'monthly') {
                                            const firstDate = event.slots[0].date;
                                            const lastDate = event.slots[event.slots.length - 1].date;
                                            $form.find('.month-date-select-wrapper').removeClass('hidden');
                                            $form.find('select[name="month-day"]').val(new Date(firstDate).getDate());
                                            const wrapper = document.querySelector(".custom-calendar-wrapper");
                                            const multiRangeButton = wrapper.querySelector(".calender-input-button");
                                            multiRangeButton.setAttribute("data-calendar-type", "range");
                                            const calendar = new CustomCalendar(multiRangeButton);
                                            calendar.rangeSelection();
                                            calendar.setOptions("range", {
                                                disablePastDates: false,
                                                selectedDates: {
                                                    startDate: firstDate,
                                                    endDate: lastDate,
                                                },
                                            });
                                        }
                                    } else if (event.type === "pass") {
                                        $form.find(".type-of-event-btn[value='pass']").trigger('click');
                                        // $form.find(".type-of-event-btn[value='pass'] i").addClass("fa fa-check").removeClass("fa-regular fa-circle");
                                        $form.find('input[name="type"]').val(event.type);
                                        const wrapper = document.querySelector(".custom-calendar-wrapper");
                                        const multiRangeButton = wrapper.querySelector(".calender-input-button");
                                        const calendar = new CustomCalendar(multiRangeButton);
                                        calendar.multiRangeSelection();
                                        let allDates = event.slots.map(function(slot) {
                                            return {
                                                startDate: slot.start_date,
                                                endDate: slot.end_date
                                            };
                                        });
                                        calendar.setOptions("multi-range", {
                                            disablePastDates: false,
                                            selectedDates: {
                                                allDates: allDates
                                            },
                                        });
                                    }
                                    // const val = validator.handleEventChangescheduleBy(event.timing);

                                }



                                // Step 3
                                console.log(event.packages);
                                $wrapper = $form.find('.add-ticket-bottom.tickets');
                                if (event.packages?.length > 0) {
                                    const packagesLength = event.packages.filter(pkg => pkg.type === "paid").length;
                                    for (let i = 0; i < packagesLength - 1; i++) {
                                        $form.find('.create-new-category-btn').trigger('click');
                                    }
                                    for (let i = 0; i < packagesLength; i++) {
                                        // if (i === 0) {
                                        //     defaultPrice = event.packages[i]?.price;
                                        // }
                                        if (event.packages[i].type === 'paid') {
                                            $item = $wrapper.find(".add-ticket-paid-items").eq(i);
                                            $item.find(`[name="package_name[]"]`).val(event.packages[i]?.name);
                                            $item.find(`[name="package_qty[]"]`).val(event.packages[i]?.qty);
                                            $item.find(`[name="package_price[]"]`).val(event.packages[i]?.price);
                                            const $input = $item.find(`[name="package_amenities[]"]`);
                                            $input.val(JSON.stringify(event.packages[i]?.amenities) || '');

                                            // Dispatch change event using DOM element
                                            const inputEl = $input[0];
                                            if (inputEl) {
                                                const changeEvent = new Event('change', { bubbles: true });
                                                inputEl.dispatchEvent(changeEvent);
                                            }

                                        }
                                    }
                                }
                                const freePackage = event.packages?.filter(pkg => pkg.type === "free")[0];
                                $('#add-ticket-free-available-quantity').val(event.free_tickets);

                                const $freeInput = $('[name="free_tickets_amenities"]');
                                $freeInput.val(JSON.stringify(freePackage?.amenities) || '');
                                const freeInputEl = $freeInput[0];
                                if (freeInputEl) {
                                    freeInputEl.dispatchEvent(new Event('change', { bubbles: true }));
                                }

                                $('#add-ticket-donation-available-quantity').val(event.donated_tickets);
                                const donatedPackage = event.packages?.filter(pkg => pkg.type === "donated")[0];

                                const $donatedInput = $('[name="donated_tickets_amenities"]');
                                $donatedInput.val(JSON.stringify(donatedPackage?.amenities) || '');
                                const donatedInputEl = $donatedInput[0];
                                if (donatedInputEl) {
                                    donatedInputEl.dispatchEvent(new Event('change', { bubbles: true }));
                                }
                                $wrapper = $form.find('.amenities-icon-wrapper');
                                $wrapper.find(".item").each(function(i, element) {
                                    const checkboxValue = $(element).find('input[name="amenities[]"]').prop('checked', false);
                                    console.log(checkboxValue);
                                });
                                if (event.amenities.length > 0) {
                                    $wrapper.find(".item").each(function(i, element) {
                                        const checkboxValue = $(element).find('input[name="amenities[]"]').val();
                                        const existsInAmenities = event.amenities.some(function(amenity) {
                                            return amenity.id == checkboxValue;
                                        });
                                        if (existsInAmenities) {
                                            $(element).find('input[name="amenities[]"]').prop('checked', true);
                                        }
                                    });
                                    $wrapper = $form.find('.personalized-amenities-wrapper .amenities-icon-wrapper');
                                    if (event.amenities.some(amenity => amenity.type === 'custom')) {
                                        $form.find('.personalized-amenities-wrapper').removeClass('hidden');
                                    }
                                    for (let i = 0; i < event.amenities.length; i++) {
                                        if (event.amenities[i].type === 'custom') {
                                            const image = `{{ asset('uploads/amenities/') }}/${event.amenities[i]?.image}`;
                                            const amenityHtml = `
                                                <div class="item">
                                                    <input type="checkbox" name="amenities[]" value="${event.amenities[i]?.id}" class="hidden amenities-checkbox" checked="">
                                                    <button class="amenities-btn" type="button" title="${event.amenities[i]?.name}">
                                                        <img class="amenities-icon" src="${image}" alt="${event.amenities[i]?.name}" draggable="false">
                                                        <p>${event.amenities[i]?.name}</p>
                                                        <i class="delete-icon">x</i>
                                                    </button>
                                                </div>
                                            `;
                                            $wrapper.append(amenityHtml);
                                        }
                                    }
                                    $wrapper.on('click', '.delete-icon', function() {
                                        $(this).closest('.item').remove();
                                        if ($wrapper.find('.item').length === 0) {
                                            $form.find('.personalized-amenities-wrapper').addClass('hidden');
                                        }
                                    });
                                }


                                // Step 4
                                $form.find('input[name="venue"]').val(event.venue);
                                $form.find('input[name="address"]').val(event.address);
                                $form.find('input[name="city"]').val(event.city);
                                $form.find('input[name="venue_map"]').val(event.venue_map);


                                // Step 5
                                $('textarea[name="description"]').html(event.description);
                                tinymce.get('event-description').setContent(event.description);

                                // Step 6
                                event.banner && $form.find('.header-image-prev').attr('src', `{{ asset('uploads/events') }}/${event.banner}`).attr('data-src',
                                    `{{ asset('uploads/events') }}/${event.banner}`);


                                // Step 7
                                $imageContainer = $form.find('.display-img-create-order');
                                // $imageContainer2 = $form.find('#banner-display-img-2');
                                let imgElement = undefined;
                                event.images?.forEach(image => {
                                    if (image.type === 'video') {
                                        imgElement = `
                                    <div class="media-container" style="position: relative; display: inline-block; margin: 5px;" id="image-${image.id}">
                                        <video src="{{ asset('uploads/events') }}/${image.image}" controls="" class="media-item" draggable="false" style="width: 100px; height: 100px; object-fit: cover; margin: 5px;"></video>
                                        <i onclick="handleEventImageDelete(event, ${image.id})" class="fa-solid fa-trash a-icon no-bg" style="position: absolute; top: 10px; right: 10px;"></i>
                                    </div>
                                `;
                                    } else if (image.type === 'image') {
                                        imgElement = `
                                    <div class="media-container" style="position: relative; display: inline-block; margin: 5px;" id="image-${image.id}">
                                        <img src="{{ asset('uploads/events') }}/${image.image}" class="media-item" draggable="false" style="width: 100px; height: 100px; object-fit: cover; margin: 5px;">
                                        <i onclick="handleEventImageDelete(event, ${image.id})" class="fa-solid fa-trash a-icon no-bg" style="position: absolute; top: 10px; right: 10px;"></i>
                                    </div>
                                `;
                                    }
                                    $imageContainer.append(imgElement);
                                    // imageContainer2.append(imgElement);
                                });


                                // Step 8
                                $form.find('select[name="ticket_mode"]').val(event.ticket_mode);
                                event.ticket_mode === `{{ \App\Enums\TicketMode::OFFLINE }}` && $form.find('#purchase-location-wrapper').removeClass('hidden');
                                $form.find('input[name="ticket_location"]').val(event.ticket_location);
                                $form.find('input[name="ticket_location_map"]').val(event.ticket_location_map);
                                $form.find('select[name="refund"]').val(event.refund);


                                // Step 9
                                if (event.faqs?.length > 0) {
                                    for (let i = 0; i < (event.faqs.length - 1); i++) {
                                        $form.find('.create-new-faq-btn').trigger('click');
                                    }
                                    for (let i = 0; i < event.faqs?.length; i++) {
                                        $item = $(".event-faq-wrapper").eq(i);
                                        $item.find(`[name="question[]"]`).val(event.faqs[i]?.question);
                                        $item.find(`[name="answer[]"]`).val(event.faqs[i]?.answer);
                                    }
                                }

                                // Step 10
                                $(`input[name="meta_title"]`).val(event.meta_title);
                                $(`input[name="meta_keywords"]`).val(event.meta_keywords);
                                $(`input[name="meta_description"]`).val(event.meta_description);

                                // Step 11: Event Preview
                                const bannerMedia = [];
                                event.images?.forEach(image => {
                                    bannerMedia.push({
                                        src: `{{ asset('uploads/events') }}/${image.image}`,
                                        type: image.type,
                                    });
                                });
                                const faqs = [];
                                event.faqs?.forEach(faq => {
                                    faqs.push({
                                        question: faq.question,
                                        answer: faq.answer,
                                    });
                                });
                                let duration = 0;
                                if (event.slots?.length > 0) {
                                    duration = calculateDurationInHours(event.slots[0].time[0].start_time, event.slots[0].time[0].end_time);
                                }
                                const valuesToDisplay = {
                                    bannerMedia: bannerMedia,
                                    eventName: event.name,
                                    scheduleBy: event.timing,
                                    eventDate: eventDate,
                                    timeDuration: duration,
                                    defaultPrice: defaultPrice,
                                    venueName: event.venue,
                                    description: event.description,
                                    faq: faqs,
                                };
                                passDataToObject(valuesToDisplay);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                        }
                    })
                }

                function covertTimestampToDate(timestamp) {
                    var startsDatetime = new Date(timestamp);
                    return startsDatetime.toISOString().slice(0, 16);
                }

                function handleEventImageDelete(event, eventId) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `{{ route('admin.events.destroy.image', ':id') }}`.replace(':id', eventId),
                                type: 'POST',
                                data: {
                                    _method: 'DELETE',
                                    _token: "{{ csrf_token() }}",
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: response.message
                                        });
                                        $(`#image-${eventId}`).remove();
                                    }
                                }
                            })
                        }
                    })
                }

                function handleEventStatus(event, eventId, status) {
                    event.preventDefault();
                    const btn = $(event.currentTarget).closest('.feed-card-wrapper').find('.feed-card-menu-drop-downmenu-btn').html();
                    ajaxLoader('#event-btn-' + eventId, btn);
                    $.ajax({
                        url: `{{ route('admin.events.status', ':id') }}`.replace(':id', eventId),
                        type: 'POST',
                        data: {
                            _method: 'PUT',
                            _token: "{{ csrf_token() }}",
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Event Status Changed',
                                    text: response.message
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })
                            }
                        }
                    })
                }
            </script>
        @endif
        <script>
            function handleTicketCardMenu(wrapper) {
                const menuWrapper = wrapper.querySelector(".menu-wrapper");
                const mainMenuWrapper = menuWrapper.querySelector(".main-menu-wrapper");
                const editMenuBtn = menuWrapper.querySelector(".edit-menu-btn");
                const editMenuWrapper = menuWrapper.querySelector(".edit-menu-wrapper");
                const backBtn = menuWrapper.querySelector(".cards-menu-back-btn");

                mainMenuWrapper.classList.add("show");

                editMenuBtn.addEventListener("click", () => {
                    editMenuWrapper.classList.add("show");

                    backBtn.removeEventListener("click", closeEditMenu);
                    backBtn.addEventListener("click", closeEditMenu);

                    function closeEditMenu() {
                        editMenuWrapper.classList.remove("show");
                    }
                });

                // Event listener to close the menu if clicked outside
                document.addEventListener("click", (event) => {
                    if (!mainMenuWrapper.contains(event.target) && !wrapper.contains(event.target)) {
                        mainMenuWrapper.classList.remove("show");
                    }
                    if (!editMenuWrapper.contains(event.target) && !wrapper.contains(event.target)) {
                        editMenuWrapper.classList.remove("show");
                    }
                });
            }
        </script>
    @endpush
@endonce
