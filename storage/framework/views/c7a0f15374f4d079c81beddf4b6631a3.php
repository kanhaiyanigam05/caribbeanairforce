<!-- Post Event Modal Menu Starts Here -->
<form method="post" action="<?php echo e(route('admin.events.store')); ?>" enctype="multipart/form-data" id="event-create-form">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="seating_map" value="" id="seating_map" />
    <input type="hidden" name="seating_plan" value="" id="seating_plan" />
    <div id="create-event-modal" class="modal-wrapper">
        <div class="base-event-modal-wrapper">
            <div class="bg-white" id="create-event-container">
                <div class="base-event-dp-modal">
                    <button type="button" class="hidden modal-event-back-btn" onclick="handleBackEventCreateModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000"
                            class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8">
                            </path>
                        </svg>
                    </button>
                    <!-- 14-11-2024 -->
                    <button type="button" class="modal-event-close-btn default-close-btn"
                        onclick="handleHideEventCreateModal(); resetEventForm()">
                        <svg width="28" height="29" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="close-btn-icon">
                            <path
                                d="M20.5998 20.6233L14.0001 14.0237M14.0001 14.0237L7.40044 7.42402M14.0001 14.0237L20.5998 7.42402M14.0001 14.0237L7.40044 20.6233"
                                stroke="#bd191f" stroke-width="1.5" stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>
                <!-- 14-11-2024 -->
                <div id="create-event-modal-inner">
                    <!-- Organizer's Info -->
                    <div id="organizer-name-wrapper" class="modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Event Organizer's Information</h3>
                        <div class="base-form-event-wrapper border-box">
                            <div
                                class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box organizer-item">
                                <label for="organizer-name" class="transition border-box">Name</label>
                                <input type="text" name="organizer_name" id="organizer-name"
                                    value="<?php echo e(Auth::user()->full_name); ?>"
                                    class="w-full transition event-input border-box" placeholder="Your Name" />
                                <p class="error-text border-box"></p>
                            </div>
                            <div
                                class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box organizer-item">
                                <label for="organizer-email" class="transition border-box">Email</label>
                                <input type="email" name="organizer_email" id="organizer-email"
                                    value="<?php echo e(Auth::user()->email); ?>" class="w-full transition event-input border-box"
                                    placeholder="demo@nowhere.com" />
                                <p class="error-text border-box"></p>
                            </div>
                            <div
                                class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box organizer-item">
                                <label for="organizer-phone" class="transition border-box">Phone</label>
                                <input type="text" name="organizer_phone" id="organizer-phone"
                                    value="<?php echo e(Auth::user()->phone); ?>" class="w-full transition event-input border-box"
                                    placeholder="+91 9876543210" />
                                <p class="error-text border-box"></p>
                            </div>
                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                    onclick="handleEventCheckNext(0)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                    <!-- Event Name -->
                    <div id="event-name-wrapper" class="hidden scale-0 modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Create Event</h3>
                        <div class="base-form-event-wrapper border-box">
                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                <label for="event-name" class="transition border-box">Event title</label>
                                <input type="text" name="title" id="event-name"
                                    class="w-full transition event-input border-box"
                                    placeholder="Enter the name of your event" />
                                <p class="error-text border-box"></p>
                            </div>

                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                <label for="event-category" class="transition border-box">Event category</label>
                                <select name="category" id="event-category"
                                    class="w-full transition event-input border-box">
                                    <option value="">Select event category</option>
                                    <?php $__currentLoopData = App\Models\EventCategory::where('status', true)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p class="error-text border-box"></p>
                            </div>

                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                <label for="event-short-description" class="transition border-box">Ticket Info</label>
                                <textarea name="ticket_info" id="event-short-description"
                                    class="w-full transition event-input border-box event-short-description"
                                    placeholder="Enter a short description of the event" rows="5"></textarea>
                                <p class="error-text border-box"></p>
                            </div>

                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                    onclick="handleEventCheckNext(1)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                    <!-- Event Duration -->
                    <!-- 26-11-2024 -->
                    <div id="event-duration-wrapper"
                        class="hidden scale-0 create-event-item modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Event Duration</h3>
                        
                        <div class="base-form-event-wrapper border-box">
                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                <label for="type-of-event" class="transition border-box">Type of event</label>
                                <div class="type-of-event-wrapper">
                                    <button class="transition type-of-event-btn" value="ticket" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                            <path fill-rule=""
                                                d="M22.666 8.667V6h-2.667v2.667h-8V6H9.333v2.667H6.666V26h18.667V8.667h-2.667Zm0 14.666H9.333V14h13.333v10.667-1.334Z"
                                                clip-rule="evenodd"></path>
                                            <path d="M11 16h2v2h-2z"></path>
                                        </svg>
                                        <div class="type-of-event-text">
                                            <p class="title">Event Ticket</p>
                                            <p class="info">Get your ticket for one date</p>
                                        </div>
                                        <i class="fa-regular fa-circle"></i>
                                    </button>
                                    <button class="transition type-of-event-btn" value="pass" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                            <path fill-rule="evenodd"
                                                d="M22.666 8.667V6h-2.667v2.667h-8V6H9.333v2.667H6.666V26h18.667V8.667h-2.667Zm0 14.666H9.333V14h13.333v10.667-1.334Z"
                                                clip-rule="evenodd"></path>
                                            <path
                                                d="M19 16h2v2h-2zM19 20h2v2h-2zM11 16h2v2h-2zM11 20h2v2h-2zM15 16h2v2h-2zM15 20h2v2h-2z">
                                            </path>
                                        </svg>
                                        <div class="type-of-event-text">
                                            <p class="title">Event Pass</p>
                                            <p class="info">Join events on multiple dates</p>
                                        </div>
                                        <i class="fa-regular fa-circle"></i>
                                    </button>
                                </div>
                                <p class="error-text border-box type-of-event-btn-error"></p>
                                <input type="hidden" name="type" id="event-type" value="ticket">
                            </div>

                            <div class="hidden mb-1 create-event-type-wapper">
                                <div
                                    class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box schedule-by-wrapper ticket-type">
                                    <label for="schedule-by" class="transition border-box">Schedule By</label>
                                    <select name="timing" id="schedule-by"
                                        class="w-full transition event-input border-box">
                                        <option value="">Schedule Event</option>
                                        <option value="single">Single Day</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                    <p class="error-text border-box"></p>
                                </div>

                                <div
                                    class="flex items-start justify-start transition flex-column gap-05 border-box ticket-type">
                                    <div class="w-full mb-1 week-day-select-wrapper">
                                        <div
                                            class="flex items-start justify-start transition flex-column gap-05 border-box">
                                            <label for="week-day" class="transition border-box">Week Day</label>
                                            <select name="week-day" id="week-day"
                                                class="w-full transition event-input border-box week-day-select">
                                                <option value="">Day</option>
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tuesday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                                <option value="sunday">Sunday</option>
                                            </select>
                                            <p class="error-text week-day-select-error border-box"></p>
                                        </div>
                                    </div>

                                    <div class="w-full mb-1 month-date-select-wrapper">
                                        <div
                                            class="flex items-start justify-start transition flex-column gap-05 border-box">
                                            <label for="month-date" class="transition border-box">Month Date</label>
                                            <select name="month-day" id="month-date"
                                                class="w-full transition event-input border-box month-date-select">
                                                <option value="">Month Date</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                            </select>
                                            <p class="error-text month-date-select-error border-box"></p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box event-type-items">
                                    <label for="event-date" class="transition border-box">Event Date</label>

                                    <div class="w-full custom-calendar-wrapper">
                                        <button
                                            class="w-full transition cursor-pointer calender-input-button event-date date-input input-btn event-input border-box"
                                            data-calendar-type="single-date" type="button">
                                            <p class="text"></p>
                                        </button>
                                    </div>
                                    <p class="calender-error-text border-box"></p>
                                </div>

                                <!-- Start Time Section -->
                                <div
                                    class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box event-type-items">
                                    <label for="event-start-time" class="transition border-box">Start Time</label>
                                    <select name="start_time"
                                        class="w-full transition event-start-time default event-time-select event-input border-box">
                                        <option value="">Start Time</option>
                                        <!-- Add options here -->
                                        <option value="12:00 AM">12:00 AM</option>
                                        <option value="12:30 AM">12:30 AM</option>
                                        <option value="1:00 AM">1:00 AM</option>
                                        <option value="1:30 AM">1:30 AM</option>
                                        <option value="2:00 AM">2:00 AM</option>
                                        <option value="2:30 AM">2:30 AM</option>
                                        <option value="3:00 AM">3:00 AM</option>
                                        <option value="3:30 AM">3:30 AM</option>
                                        <option value="4:00 AM">4:00 AM</option>
                                        <option value="4:30 AM">4:30 AM</option>
                                        <option value="5:00 AM">5:00 AM</option>
                                        <option value="5:30 AM">5:30 AM</option>
                                        <option value="6:00 AM">6:00 AM</option>
                                        <option value="6:30 AM">6:30 AM</option>
                                        <option value="7:00 AM">7:00 AM</option>
                                        <option value="7:30 AM">7:30 AM</option>
                                        <option value="8:00 AM">8:00 AM</option>
                                        <option value="8:30 AM">8:30 AM</option>
                                        <option value="9:00 AM">9:00 AM</option>
                                        <option value="9:30 AM">9:30 AM</option>
                                        <option value="10:00 AM">10:00 AM</option>
                                        <option value="10:30 AM">10:30 AM</option>
                                        <option value="11:00 AM">11:00 AM</option>
                                        <option value="11:30 AM">11:30 AM</option>
                                        <option value="12:00 PM">12:00 PM</option>
                                        <option value="12:30 PM">12:30 PM</option>
                                        <option value="1:00 PM">1:00 PM</option>
                                        <option value="1:30 PM">1:30 PM</option>
                                        <option value="2:00 PM">2:00 PM</option>
                                        <option value="2:30 PM">2:30 PM</option>
                                        <option value="3:00 PM">3:00 PM</option>
                                        <option value="3:30 PM">3:30 PM</option>
                                        <option value="4:00 PM">4:00 PM</option>
                                        <option value="4:30 PM">4:30 PM</option>
                                        <option value="5:00 PM">5:00 PM</option>
                                        <option value="5:30 PM">5:30 PM</option>
                                        <option value="6:00 PM">6:00 PM</option>
                                        <option value="6:30 PM">6:30 PM</option>
                                        <option value="7:00 PM">7:00 PM</option>
                                        <option value="7:30 PM">7:30 PM</option>
                                        <option value="8:00 PM">8:00 PM</option>
                                        <option value="8:30 PM">8:30 PM</option>
                                        <option value="9:00 PM">9:00 PM</option>
                                        <option value="9:30 PM">9:30 PM</option>
                                        <option value="10:00 PM">10:00 PM</option>
                                        <option value="10:30 PM">10:30 PM</option>
                                        <option value="11:00 PM">11:00 PM</option>
                                        <option value="11:30 PM">11:30 PM</option>
                                    </select>
                                    <p class="error-text border-box"></p>
                                </div>

                                <!-- End Time Section -->
                                <div
                                    class="flex items-start justify-start transition flex-column gap-05 border-box event-type-items mb-1">
                                    <label for="event-end-time" class="transition border-box">End Time</label>
                                    <select name="end_time"
                                        class="w-full transition event-end-time default event-time-select event-input border-box">
                                        <option value="">End Time</option>
                                        <!-- Add options here -->
                                        <option value="12:00 AM">12:00 AM</option>
                                        <option value="12:30 AM">12:30 AM</option>
                                        <option value="1:00 AM">1:00 AM</option>
                                        <option value="1:30 AM">1:30 AM</option>
                                        <option value="2:00 AM">2:00 AM</option>
                                        <option value="2:30 AM">2:30 AM</option>
                                        <option value="3:00 AM">3:00 AM</option>
                                        <option value="3:30 AM">3:30 AM</option>
                                        <option value="4:00 AM">4:00 AM</option>
                                        <option value="4:30 AM">4:30 AM</option>
                                        <option value="5:00 AM">5:00 AM</option>
                                        <option value="5:30 AM">5:30 AM</option>
                                        <option value="6:00 AM">6:00 AM</option>
                                        <option value="6:30 AM">6:30 AM</option>
                                        <option value="7:00 AM">7:00 AM</option>
                                        <option value="7:30 AM">7:30 AM</option>
                                        <option value="8:00 AM">8:00 AM</option>
                                        <option value="8:30 AM">8:30 AM</option>
                                        <option value="9:00 AM">9:00 AM</option>
                                        <option value="9:30 AM">9:30 AM</option>
                                        <option value="10:00 AM">10:00 AM</option>
                                        <option value="10:30 AM">10:30 AM</option>
                                        <option value="11:00 AM">11:00 AM</option>
                                        <option value="11:30 AM">11:30 AM</option>
                                        <option value="12:00 PM">12:00 PM</option>
                                        <option value="12:30 PM">12:30 PM</option>
                                        <option value="1:00 PM">1:00 PM</option>
                                        <option value="1:30 PM">1:30 PM</option>
                                        <option value="2:00 PM">2:00 PM</option>
                                        <option value="2:30 PM">2:30 PM</option>
                                        <option value="3:00 PM">3:00 PM</option>
                                        <option value="3:30 PM">3:30 PM</option>
                                        <option value="4:00 PM">4:00 PM</option>
                                        <option value="4:30 PM">4:30 PM</option>
                                        <option value="5:00 PM">5:00 PM</option>
                                        <option value="5:30 PM">5:30 PM</option>
                                        <option value="6:00 PM">6:00 PM</option>
                                        <option value="6:30 PM">6:30 PM</option>
                                        <option value="7:00 PM">7:00 PM</option>
                                        <option value="7:30 PM">7:30 PM</option>
                                        <option value="8:00 PM">8:00 PM</option>
                                        <option value="8:30 PM">8:30 PM</option>
                                        <option value="9:00 PM">9:00 PM</option>
                                        <option value="9:30 PM">9:30 PM</option>
                                        <option value="10:00 PM">10:00 PM</option>
                                        <option value="10:30 PM">10:30 PM</option>
                                        <option value="11:00 PM">11:00 PM</option>
                                        <option value="11:30 PM">11:30 PM</option>
                                    </select>
                                    <p class="error-text border-box"></p>
                                </div>

                                <!-- Pass Selection -->
                                <div
                                    class="flex flex-wrap items-start justify-start mb-1 transition flex-column gap-05 border-box custom-pass-selector-wrapper pass-type hidden">
                                    <label class="transition border-box">Custom Pass</label>
                                    <div
                                        class="flex flex-wrap items-start justify-start transition gap-05 custom-pass-area">
                                        <div class="create-custom-pass m-auto" onclick="handleAddCustompass()">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                    </div>

                                    <p class="error-text border-box"></p>
                                    <input type="hidden" class="custom-passes" name="custom_passes" value="[]">
                                </div>

                                <div class="add-custom-pass-sidebar opacity-0">
                                    <h4 class="add-ticket-heading">Create Custom Pass</h4>
                                    <div class="flex flex-col gap-2">
                                        <div class="add-ticket-paid-items mt-2">
                                            <div
                                                class=" mb-1 transition flex flex-column gap-05 justify-start items-start border-box">
                                                <label for="add-pass-name" class=" transition border-box">Pass
                                                    Name</label>
                                                <input type="text" name="pass_name[]" id="add-pass-name"
                                                    class="transition w-full border-box pass-name"
                                                    placeholder="Enter pass name">
                                                <p class="error-text border-box"></p>
                                            </div>
                                            <div
                                                class="mb-1 transition flex flex-column gap-05 justify-start items-start border-box">
                                                <label for="add-pass-day" class=" transition border-box ">Pass
                                                    Day</label>
                                                <input type="number" name="pass_days[]" id="add-pass-day"
                                                    class="transition w-full  border-box pass-day"
                                                    placeholder="Enter pass day">
                                                <p class="error-text border-box custom-days-error"></p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="flex gap-05 mt-2">
                                        <button type="button" class="add-tickets-bottom-btn cancel"
                                            onclick="handlePassCancel()">Cancel</button>
                                        <button type="button" class="add-tickets-bottom-btn save"
                                            onclick="handlePassSave()">Save</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1 mt-5 flex items-center gap-1">
                                <div>
                                    <h4 class="reserved-seating">Reserved seating</h4>
                                    <p class="reserved-seating-info">Use your venue map to set price tiers for each section and choose whether attendees can pick their seat.</p>
                                </div>
                                <div>
                                    <div class="caribbean-switch-wrapper">
                                        <input type="checkbox" name="reserved" value="1" id="reserved-seating-switch">
                                    </div>
                                </div>
                            </div>

                            <div class="venue-map-wrapper">
                                <div class="venue-map-container create-venue-map hidden">
                                    <img src="https://showcaseonline.xyz/caribbean-airforce/abc.png" alt="Venue Map Image" class="venue-map-image">

                                    <h4 class="venue-map-heading">No seating maps found for this event</h4>
                                    <p class="venue-map-description">Create a seating map to get started.</p>

                                    <button type="button"
                                        class="text-white transition base-form-event-wrapper-btn border-box create-event-default-btn open-venue-map">
                                        Create Seating Map
                                    </button>

                                </div>

                                <div class="venue-map-container edit-venue-map hidden">
                                    <img src="https://showcaseonline.xyz/caribbean-airforce/abc.png" alt="Venue Map Image" class="venue-map-image">

                                    <h4 class="venue-map-heading">Edit your seating map</h4>
                                    <p class="venue-map-description">Please, go to your seating map and edit to start creating tickets</p>
                                    <button type="button" id="launch-venue-map-designer" class="text-white transition base-form-event-wrapper-btn border-box create-event-default-btn">
                                        Launch Seating Map Designer
                                    </button>


                                </div>
                                <p class="error-text border-box" id="seating-validation-error"></p>
                            </div>



                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn "
                                    onclick="handleEventCheckNext(2)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                    <!-- 26-11-2024 -->
                    <!-- Create tickets -->
                    <div id="event-create-tickets-wrapper"
                        class="hidden scale-0 create-event-item modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Create tickets</h3>
                        <p style="margin: 15px 0; font-size: 15px;">Choose a ticket type or build a section with
                            multiple
                            ticket types.</p>
                        <div class="base-form-event-wrapper border-box">
                            <div class="create-tickets-button-main-wrapper">
                                <div>
                                    <button type="button" class="flex mb-1 transition border-box create-tickets-button">
                                        <div class="create-tickets-button-left">
                                            <svg width="63" height="63" viewBox="0 0 63 63" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect width="63" height="63" rx="8" fill="#3659E3" fill-opacity="0.08">
                                                </rect>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M34.65 14.175C34.65 14.175 34.65 19.6875 29.925 19.6875C25.2 19.6875 25.2 14.175 25.2 14.175H17.325V45.675H25.2C25.1747 44.4468 25.6384 43.259 26.4891 42.3728C27.3399 41.4866 28.5078 40.9748 29.736 40.95H29.925C31.1532 40.9247 32.341 41.3884 33.2272 42.2391C34.1134 43.0899 34.6252 44.2578 34.65 45.486V45.675H42.525V14.175H34.65ZM44.1 17.325V47.25H37.8V48.825H45.675V17.325H44.1ZM26.9325 47.2503C27.4409 45.3611 28.7707 43.8 30.555 42.9978C31.1169 43.233 31.6062 43.6135 31.9725 44.1003C29.8673 44.7219 28.4037 46.6309 28.35 48.8253H20.475V47.2503H26.9325ZM25.2 30.7125V29.1375H22.05V30.7125H25.2ZM28.35 30.7125V29.1375H31.5V30.7125H28.35ZM37.8 29.1375H34.65V30.7125H37.8V29.1375ZM36.225 44.1H40.95V15.75H36.225C35.595 18.4275 33.8625 21.2625 29.925 21.2625C25.9875 21.2625 24.255 18.4275 23.625 15.75H18.9V44.1H23.625C24.1956 41.1381 26.9218 39.0935 29.925 39.375C32.9282 39.0935 35.6543 41.1381 36.225 44.1Z"
                                                    fill="#6898F7"></path>
                                            </svg>
                                            <div class="create-tickets-button-inner-wrapper">
                                                <h6 class="create-tickets-button-inner-heading">Paid</h6>
                                                <p class="create-tickets-button-inner-paragraph">Create a ticket that
                                                    people have to pay
                                                    for.</p>
                                            </div>
                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                                <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"></path>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="flex mb-1 transition border-box create-tickets-button">
                                        <div class="create-tickets-button-left">
                                            <svg width="63" height="63" viewBox="0 0 63 63" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect width="63" height="63" rx="6.38" fill="#F2E7FE"
                                                    fill-opacity="0.8"></rect>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M36.0746 26.775H39.5489C39.4388 24.066 36.3104 21.5775 33.0248 20.7743V17.325H29.8807V20.727C29.0476 20.916 28.1672 21.1995 27.4598 21.5775L29.7707 23.8928C30.4152 23.625 31.2013 23.4675 32.1445 23.4675C34.9428 23.4675 35.9803 24.8063 36.0746 26.775ZM18.8764 20.9947L24.2842 26.4127C24.2842 29.6887 26.7366 31.4685 30.4309 32.571L35.9488 38.0992C35.4143 38.8552 34.2982 39.5325 32.1445 39.5325C28.906 39.5325 27.6327 38.0835 27.4598 36.225H24.0012C24.1899 39.6742 26.8624 41.6115 29.8807 42.2572V45.675H33.0248V42.2887C34.534 42.0052 37.3637 41.4225 38.3541 40.5247L41.844 44.0212L44.0763 41.7847L21.1087 18.7582L18.8764 20.9947Z"
                                                    fill="#9374E7"></path>
                                            </svg>
                                            <div class="create-tickets-button-inner-wrapper">
                                                <h6 class="create-tickets-button-inner-heading">Free</h6>
                                                <p class="create-tickets-button-inner-paragraph">Create a ticket that no
                                                    one has to pay
                                                    for.</p>
                                            </div>
                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                                <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"></path>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="flex mb-1 transition border-box create-tickets-button">
                                        <div class="create-tickets-button-left">
                                            <svg width="63" height="63" viewBox="0 0 63 63" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect width="63" height="63" rx="6.3" fill="#C5162E"
                                                    fill-opacity="0.08"></rect>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M38.5875 17.7188C33.4687 17.7188 31.5 21.6562 31.5 21.6562C31.5 21.6562 28.7437 17.7188 24.4125 17.7188C19.6875 17.7188 15.75 20.9176 15.75 25.5977C15.75 28.7768 16.554 30.3353 18.9 32.6812L31.5181 45.2812L44.1 32.6812C46.446 30.3353 47.25 28.7437 47.25 25.5937C47.25 20.9176 43.3125 17.7188 38.5875 17.7188ZM45.675 25.5938C45.675 28.2035 45.1222 29.432 42.9857 31.5685L31.5165 43.0542L20.0135 31.5677C17.8526 29.4068 17.325 28.235 17.325 25.5977C17.325 22.0043 20.3718 19.2938 24.4125 19.2938C29.1131 19.2938 31.5 24.8063 31.5 24.8063C31.5 24.8063 33.8869 19.2938 38.5875 19.2938C42.525 19.2938 45.675 22.002 45.675 25.5938Z"
                                                    fill="#FAAFA0"></path>
                                            </svg>
                                            <div class="create-tickets-button-inner-wrapper">
                                                <h6 class="create-tickets-button-inner-heading">Donation</h6>
                                                <p class="create-tickets-button-inner-paragraph">Let people pay any
                                                    amount for their
                                                    ticket.</p>
                                            </div>
                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                                <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"></path>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div class="opacity-0 add-ticket-sidebar tickets">
                                <h4 class="add-ticket-heading">Add Tickets</h4>
                                <div class="add-ticket-tab-wrapper tab-wrapper">
                                    <div class="add-ticket-button-wrapper tab-header">
                                        <button type="button"
                                            class="transition add-ticket-button tab-btns">Paid</button>
                                        <button type="button"
                                            class="transition add-ticket-button tab-btns">Free</button>
                                        <button type="button"
                                            class="transition add-ticket-button tab-btns">Donation</button>
                                    </div>
                                    <div class="tab-body">
                                        <div class="add-ticket-tab-bottom tab-body-item add-ticket-paid">
                                            <div>
                                                <button class="transition create-new-category-btn" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                                        <path
                                                            d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                                                    </svg> Create New Category </button>
                                            </div>
                                            <div class="add-ticket-bottom tickets">
                                                <div class="add-ticket-paid-items default">
                                                    <div
                                                        class="flex items-start justify-start mb-1 transition add-ticket-input-item-wrapper flex-column gap-05 border-box">
                                                        <label for="add-ticket-paid-name"
                                                            class="transition add-ticket-paid-label border-box">Name</label>
                                                        <input type="text" name="package_name[]"
                                                            id="add-ticket-paid-name"
                                                            class="w-full transition add-ticket-paid-input event-input border-box"
                                                            placeholder="General Admission">
                                                        <p class="error-text border-box"></p>
                                                    </div>
                                                    <div
                                                        class="flex items-start justify-start mb-1 transition add-ticket-input-item-wrapper flex-column gap-05 border-box">
                                                        <label for="add-ticket-paid-available-quantity"
                                                            class="transition add-ticket-paid-label border-box">Available
                                                            quantity</label>
                                                        <input type="text" name="package_qty[]"
                                                            id="add-ticket-paid-available-quantity"
                                                            class="w-full transition add-ticket-paid-input event-input border-box"
                                                            placeholder="1" oninput="validateInteger(this, 0)"
                                                            onpaste="validateInteger(this, 0)">
                                                        <p class="error-text border-box"></p>
                                                    </div>
                                                    <div
                                                        class="flex items-start justify-start mb-1 transition add-ticket-input-item-wrapper flex-column gap-05 border-box">
                                                        <label for="add-ticket-paid-price"
                                                            class="transition add-ticket-paid-label border-box">Ticket
                                                            Price</label>
                                                        <div class="ticket-price-wrapper">
                                                            <input type="text" name="package_price[]"
                                                                id="add-ticket-paid-price"
                                                                class="w-full transition add-ticket-paid-price default add-ticket-paid-input event-input border-box"
                                                                placeholder="250" oninput="validatePrice(this)"
                                                                onpaste="validatePrice(this)">
                                                            <i class="absolute fa-solid fa-dollar-sign"></i>
                                                        </div>
                                                        <p id="add-ticket-paid-price-error"
                                                            class="error-text border-box"></p>
                                                    </div>
                                                    <div
                                                        class="flex items-start justify-start mb-1 transition flex-column gap-1 border-box mt-1">
                                                        <p class="transition add-ticket-paid-label border-box">Standard
                                                            Amenities</p>

                                                        <div class="amenities-icon-wrapper">
                                                            <?php $__currentLoopData = App\Models\Amenity::where('type', 'static')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="item">
                                                                    <input type="checkbox" name="amenities[]"
                                                                        value="<?php echo e($amenity->id); ?>"
                                                                        class="hidden amenities-checkbox">
                                                                    <button class="amenities-btn" type="button"
                                                                        title="<?php echo e($amenity->name); ?>">
                                                                        <img class="amenities-icon" src="<?php echo e(asset("uploads/amenities/{$amenity->image}")); ?>" alt="" draggable="false">
                                                                        <p><?php echo e($amenity->name); ?></p>
                                                                    </button>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>

                                                    </div>

                                                    <div class="personalized-amenities-wrapper hidden mt-1">
                                                        <div
                                                            class="flex items-start justify-start mb-1 transition flex-column gap-1 border-box">
                                                            <p class="transition add-ticket-paid-label border-box">
                                                                Personalized Amenities</p>
                                                            <div class="amenities-icon-wrapper"></div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="flex items-start justify-start mb-1 transition flex-column gap-1 border-box custom-amenities-wrapper mt-1">
                                                        <p class="transition add-ticket-paid-label border-box">Custom Amenities</p>

                                                        <div
                                                            class="flex items-start justify-start transition flex-column gap-05 border-box w-full">
                                                            <div class="w-full">
                                                                <input class="custom-amenities-input" type="file" name="custom_amenities" id="custom-amenities" hidden>
                                                                <div class="flex justify-start items-center gap-05">
                                                                    <img class="display-icon"
                                                                        src="<?php echo e(asset('admins/images/placeholder-icon.png')); ?>"
                                                                        alt="" draggable="false">
                                                                    <label class="icon-upload-btn"
                                                                        for="custom-amenities">Upload Icon</label>
                                                                </div>
                                                                <p class="error-text border-box img-error"></p>
                                                            </div>
                                                            <input type="text" name="" id=""
                                                                class="w-full transition event-input border-box custom-amenities-text"
                                                                placeholder="Free WiFi">
                                                            <p class="error-text border-box label-error"></p>
                                                        </div>
                                                        <div class="border-box w-full">
                                                            <button type="button"
                                                                class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn custom-amenities-btn">Create</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="hidden create-event-item add-ticket-tab-bottom tab-body-item add-ticket-free">
                                            <div
                                                class="flex items-start justify-start transition flex-column gap-05 border-box">
                                                <label for="add-ticket-free-available-quantity"
                                                    class="transition border-box">Available
                                                    quantity</label>
                                                <input type="text" name="free_tickets"
                                                    id="add-ticket-free-available-quantity"
                                                    class="w-full transition event-input border-box" placeholder="1"
                                                    oninput="validateInteger(this, 0)"
                                                    onpaste="validateInteger(this, 0)">
                                                <p class="error-text border-box"></p>
                                            </div>
                                        </div>
                                        <div
                                            class="hidden create-event-item add-ticket-tab-bottom tab-body-item add-ticket-donation">
                                            <div
                                                class="flex items-start justify-start transition flex-column gap-05 border-box">
                                                <label for="add-ticket-donation-available-quantity"
                                                    class="transition border-box">Available quantity</label>
                                                <input type="text" name="donated_tickets"
                                                    id="add-ticket-donation-available-quantity"
                                                    class="w-full transition event-input border-box" placeholder="1"
                                                    oninput="validateInteger(this, 0)"
                                                    onpaste="validateInteger(this, 0)">
                                                <p class="error-text border-box"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-tickets-bottom-btns-wrapper">
                                    <button type="button" class="add-tickets-bottom-btn cancel">Cancel</button>
                                    <button type="button" class="add-tickets-bottom-btn save">Save</button>
                                </div>
                            </div>



                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                    onclick="handleEventCheckNext(3)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                    <!-- Create tickets -->
                    <!-- Event Location -->
                    <div id="event-location-wrapper"
                        class="hidden scale-0 create-event-item modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Event Location</h3>
                        <div class="base-form-event-wrapper border-box">
                            <div
                                class="flex items-start justify-start mb-1 transition item-wrapper flex-column gap-05 border-box">
                                <label for="event-name" class="transition border-box">Venue name</label>
                                <input type="text" name="venue" id="event-venue-name"
                                    class="w-full transition event-venue-name event-input border-box"
                                    placeholder="e.g. The Blue Moon Cafe" />
                                <p class="error-text border-box"></p>
                            </div>
                            <div
                                class="flex items-start justify-start mb-1 transition item-wrapper flex-column gap-05 border-box">
                                <label for="event-address" class="transition border-box">Venue Address</label>
                                <input type="text" name="address" id="event-venue-address"
                                    class="w-full transition event-venue-address event-input border-box"
                                    placeholder="e.g. 123 Main St, Suite 4" />
                                <p class="error-text border-box"></p>
                            </div>
                            <div
                                class="flex items-start justify-start mb-1 transition item-wrapper flex-column gap-05 border-box">
                                <label for="event-city" class="transition border-box">Venue City</label>
                                <input type="text" name="city" id="event-venue-city"
                                    class="w-full transition event-venue-city event-input border-box"
                                    placeholder="e.g. London" />
                                <p class="error-text border-box"></p>
                            </div>
                            <div
                                class="flex items-start justify-start mb-1 transition item-wrapper flex-column gap-05 border-box">
                                <label for="event-map-link" class="transition border-box">Venue Address Map Link</label>
                                <input type="text" name="venue_map" id="event-map-link"
                                    class="w-full transition event-map-link event-input border-box"
                                    placeholder="e.g. https://goo.gl/maps/abc123" />
                                <p class="error-text border-box"></p>
                            </div>
                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                    onclick="handleEventCheckNext(4)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                    <!-- Event Description -->
                    <div id="event-description-wrapper"
                        class="hidden scale-0 create-event-item modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Event Description</h3>
                        <div class="base-form-event-wrapper border-box">
                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                <!-- <label for="event-name" class="transition border-box">Venue name</label> -->
                                <textarea name="description" id="event-description" class="w-full event-input"
                                    placeholder="Enter a brief description of your event"></textarea>
                                <p class="error-text border-box" id="event-description-error-text"></p>
                            </div>
                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                    onclick="handleEventCheckNext(5)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                    <!-- Event Header Image -->
                    <div id="event-banner-wrapper"
                        class="hidden scale-0 create-event-item modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Event Header Image</h3>
                        <div class="base-form-event-wrapper border-box choose-image-wrapper">
                            <div class="flex justify-start max-w-full base-cover-image-modal-wrapper">
                                <div class="w-full cover-profile-page-wrapper">
                                    <img class="w-full select-none header-image-prev prev-img"
                                        src="<?php echo e(asset('admins/images/profile/placeholder.png')); ?>" alt="Profile Display"
                                        draggable="false">
                                </div>
                                <div class="w-full cover-image-avtar-base-wrapper-50">
                                    <label for="cover-input-image" class="w-full">
                                        <button type="button"
                                            class="w-full cover-image-avtar-wrapper header-img-btn cover-image-avtar-base-wrapper-100 cover-image-avtar-upload-btn upload-btn">
                                            <img class="select-none" src="<?php echo e(asset('admins/images/plus.svg')); ?>" alt=""
                                                draggable="false">
                                        </button>
                                    </label>
                                    <p class="text-info" style="margin: 15px 0 7px 0;">Please upload image with a
                                        resolution of
                                        1024 x 576 pixels for optimal display.</p>
                                    <p class="error-text border-box event-header-error"></p>
                                </div>
                                <div>
                                    <input type="file" name="banner" id="cover-input-image"
                                        class="hidden input-img event-header-input-image">
                                </div>
                            </div>
                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                    onclick="handleEventCheckNext(6)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                    <!-- Event Banner -->
                    <div id="event-banner-wrapper"
                        class="hidden scale-0 create-event-item modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Event Banner</h3>
                        <div class="base-form-event-wrapper border-box">
                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                <label for="event-name" class="transition border-box">Choose or upload an image</label>
                                <div class="h-full drag-image-main-wrapper">
                                    <div class="drag-image-wrapper">
                                        <i class="fa-solid fa-cloud-arrow-up upload-drag-icon"></i>
                                        <div class="text-center">
                                            <p class="text-black up-head">Upload any image or Video..</p>
                                        </div>
                                    </div>
                                    <input type="file" name="images[]" id="event-banner"
                                        class="hidden input-images-create multi-image-select-add-product-input"
                                        multiple="" />
                                    <div class="event-media-display-wrapper">
                                        <div class="select-none display-img-create-order"></div>
                                    </div>
                                </div>
                                <p class="text-info">Please upload images with a resolution of 1024 x 576 pixels for
                                    optimal
                                    display.</p>
                                <p class="error-text border-box" id="event-banner-error-text"></p>
                            </div>
                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                    onclick="handleEventCheckNext(7)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                    <!-- Event payment Type -->
                    <div id="event-payment-wrapper"
                        class="hidden scale-0 create-event-item modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Select Event Payment Mode</h3>
                        <div class="base-form-event-wrapper border-box">
                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                <label for="event-name" class="transition border-box">Payment Mode</label>
                                <select name="ticket_mode" id="payment-mode"
                                    class="w-full transition event-input border-box">
                                    <option value="">Select Payment Mode</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                </select>
                                <p class="error-text border-box"></p>
                            </div>
                            <div id="purchase-location-wrapper" class="hidden">
                                <div
                                    class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                    <label for="purchase-location" class="transition border-box">Ticket Location</label>
                                    <input type="text" name="ticket_location" id="purchase-location"
                                        class="w-full transition event-input border-box"
                                        placeholder="e.g. The Blue Moon Cafe" />
                                    <p class="error-text border-box"></p>
                                </div>
                                <div
                                    class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                    <label for="ticket_location_map" class="transition border-box">Ticket Map
                                        Location</label>
                                    <input type="text" name="ticket_location_map" id="ticket_location_map"
                                        class="w-full transition ticket-location-map event-input border-box"
                                        placeholder="e.g. https://goo.gl/maps/abc123" />
                                    <p class="ticket-location-map-error-text error-text border-box"></p>
                                </div>
                            </div>
                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                <label for="refund-option" class="transition border-box">Refund</label>
                                <select name="refund" id="refund-option"
                                    class="w-full transition event-input border-box">
                                    <option value="">Select Refund Option</option>
                                    <option value="Yes - 10 Days Before Event">Yes - 10 Days Before Event</option>
                                    <option value="No Refund">No Refund</option>
                                </select>
                                <p class="error-text border-box"></p>
                            </div>
                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                    onclick="handleEventCheckNext(8)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                    <!-- Create FAQ -->
                    <div id="event-create-faq-wrapper"
                        class="hidden scale-0 create-event-item modal-inner-content-wrapper border-box">
                        <div class="flex items-center justify-between" style="padding: 0 1rem;">
                            <h3 class="modal-heading border-box">Create Tickets FAQ</h3>
                            <button class="create-new-faq-btn" type="button" title="Create A New FAQ"
                                onclick="createNewFaq();">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" width="35px"
                                    viewBox="0 -960 960 960" fill="#5f6368">
                                    <path
                                        d="M451.31-451.31H233.69q-12.64 0-21.16-8.76-8.53-8.77-8.53-20.81t8.53-20.43q8.52-8.38 21.16-8.38h217.62v-217.62q0-12.09 8.56-20.89t20.31-8.8q11.74 0 20.63 8.8 8.88 8.8 8.88 20.89v217.62h217.62q11.67 0 20.18 8.58t8.51 20.62q0 12.04-8.51 20.61t-20.18 8.57H509.69v217.62q0 11.67-8.85 20.18-8.86 8.51-21.04 8.51-11.75 0-20.12-8.51-8.37-8.51-8.37-20.18v-217.62Z" />
                                </svg>
                            </button>
                        </div>
                        <div class="event-faq-inner-wrapper border-box">
                            <div class="event-faq-items-wrapper">
                                <div class="event-faq-wrapper default">
                                    <div
                                        class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box">
                                        <label for="event-faq-question"
                                            class="transition border-box create-event-faq-label">Question</label>
                                        <input type="text" name="question[]" id="event-faq-question"
                                            class="w-full transition event-faq-question event-input border-box create-event-faq-input"
                                            placeholder="Are there any service fees or additional charges?">
                                        <p class="error-text border-box"></p>
                                    </div>
                                    <div
                                        class="flex items-start justify-start transition flex-column gap-05 border-box">
                                        <label for="event-faq-answer"
                                            class="transition border-box create-event-faq-label">Answer</label>
                                        <input type="text" name="answer[]" id="event-faq-answer"
                                            class="w-full transition event-faq-answer event-input border-box create-event-faq-input"
                                            placeholder="Yes, a service fee may apply to your ticket purchase. The total cost, including any fees, will be displayed during checkout.">
                                        <p class="error-text border-box"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start justify-start mt-1 transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="button"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                    onclick="handleEventCheckNext(9)">Next</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>



                    <!-- 30-10-2024 -->
                    <!-- Event Preview -->
                    <div id="event-preview-wrapper"
                        class="hidden scale-0 create-event-item modal-inner-content-wrapper border-box"
                        style="max-height: 80vh; overflow-y: auto">
                        <h3 class="modal-heading border-box">Event Preview</h3>
                        <div class="base-form-event-wrapper border-box">
                            <section
                                class="my-10 max-w-[1500px] mx-auto w-full px-2 transition-all duration-500 flex justify-start items-start flex-col lg:flex-row gap-10">
                                <div>
                                    <div class="swiper carousel">
                                        <div class="swiper-wrapper event-prev-banner-item-wrapper">
                                            <!-- Event Banner Media Will Be Populated Here -->
                                        </div>
                                        <div
                                            class="swiper-button-next bg-primary shadow-2xl px-[22px] py-2 rounded-full">
                                            <i class="text-sm text-white fa-solid fa-chevron-right"></i>
                                        </div>
                                        <div
                                            class="swiper-button-prev bg-primary shadow-2xl px-[22px] py-2 rounded-full">
                                            <i class="text-sm text-white fa-solid fa-chevron-left"></i>
                                        </div>
                                    </div>
                                    <h2
                                        class="text-2xl font-bold text-black capitalize screen768:text-3xl my-2rem event-prev-display-title">
                                    </h2>
                                    <aside class="rounded-[4px] py-10 px-7 min-w-[100%] lg:min-w-80 mb-2rem"
                                        style="display: grid; grid-template-columns: repeat(2, 1fr); box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                                        <div class="mb-1-5rem">
                                            <h5 class="mb-1 font-semibold">Starting Price</h5>
                                            <p class="event-prev-display-starting-price"></p>
                                        </div>
                                        <div class="mb-1-5rem">
                                            <h5 class="mb-1 font-semibold">Date</h5>
                                            <p class="event-prev-display-starting-date"></p>
                                        </div>
                                        <div class="mb-1-5rem">
                                            <h5 class="mb-1 font-semibold">Duration</h5>
                                            <p class="event-prev-display-duration-time"></p>
                                        </div>
                                        <div class="mb-1-5rem">
                                            <h5 class="mb-1 font-semibold">Venue Name</h5>
                                            <p class="event-prev-display-venue-name"></p>
                                        </div>
                                    </aside>
                                    <div class="event-prev-display-description">
                                        <!-- Event Description Will Be Populated Here -->
                                    </div>
                                    <!-- Faq Starts Here -->
                                    <div class="my-10">
                                        <h2 class="my-5 text-2xl font-bold text-black capitalize screen768:text-3xl">
                                            Frequently
                                            Asked Questions</h2>
                                        <div class="faq-wrapper event-prev-faq-item-wrapper">
                                            <div class="border-b border-gray-100 faq-item">
                                                <div
                                                    class="flex items-center justify-between py-4 pr-4 cursor-pointer faq-question-wrapper">
                                                    <h3 class="text-lg font-semibold">Will there be food and drinks
                                                        available?</h3>
                                                    <span class="text-gray-500">
                                                        <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                                    </span>
                                                </div>
                                                <div class="faq-answer-wrapper hide-faq-answer">
                                                    <p class="py-4 pr-4 text-gray-700">Yes, we’re pleased to offer a
                                                        selection of food and
                                                        drinks throughout the event! Guests can enjoy a catered lunch
                                                        featuring a variety of
                                                        options, including gourmet sandwiches, seasonal salads, and a
                                                        selection of desserts.
                                                        There will also be complimentary beverages, including coffee,
                                                        tea, and soft drinks.
                                                        Additionally, we have options to accommodate various dietary
                                                        preferences, including
                                                        vegetarian, vegan, and gluten-free choices. We want to ensure
                                                        everyone has a
                                                        delightful experience, so feel free to reach out if you have any
                                                        specific dietary
                                                        needs!</p>
                                                </div>
                                            </div>
                                            <div class="border-b border-gray-100 faq-item">
                                                <div
                                                    class="flex items-center justify-between py-4 pr-4 cursor-pointer faq-question-wrapper">
                                                    <h3 class="text-lg font-semibold">Are children allowed at the event?
                                                    </h3>
                                                    <span class="text-gray-500">
                                                        <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                                    </span>
                                                </div>
                                                <div class="faq-answer-wrapper hide-faq-answer">
                                                    <p class="py-4 pr-4 text-gray-700">Yes, children are welcome at the
                                                        event! We
                                                        encourage families to join us for a fun and engaging experience.
                                                        Children under the
                                                        age of 12 can attend for free, but we kindly ask that they be
                                                        accompanied by an
                                                        adult at all times. There will also be designated activities and
                                                        areas for kids to
                                                        enjoy, ensuring that everyone has a great time! If you have any
                                                        questions about
                                                        specific arrangements for children, please feel free to reach
                                                        out.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Faq Ends Here -->
                                </div>
                            </section>
                        </div>
                        <div
                            class="sticky flex items-start justify-start transition gap-05 border-box bottom-15 left-full w-fit-content">
                            <div class="hgt6d">
                                <button type="button"
                                    class="text-white transition base-prev-event-wrapper-btn border-box"
                                    onclick="handleEventEditAction()">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <div class="hidden details-edit-event-wrapper">
                                    <button type="button" onclick="handleEventFormNextSlide(-1);">Organizer's
                                        Information</button>
                                    <button type="button" onclick="handleEventFormNextSlide(0);">Event Name</button>
                                    <button type="button" onclick="handleEventFormNextSlide(1);">Duration</button>
                                    <button type="button" onclick="handleEventFormNextSlide(2);">Tickets</button>
                                    <button type="button" onclick="handleEventFormNextSlide(3);">Location</button>
                                    <button type="button" onclick="handleEventFormNextSlide(4);">Description</button>
                                    <button type="button" onclick="handleEventFormNextSlide(5);">Header Image</button>
                                    <button type="button" onclick="handleEventFormNextSlide(6);">Banner</button>
                                    <button type="button" onclick="handleEventFormNextSlide(7);">Payment Mode</button>
                                    <button type="button" onclick="handleEventFormNextSlide(8);">FAQ</button>
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white potransition base-prev-event-wrapper-btn border-box">
                                <i class="fa-solid fa-check"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="modal-wrapper show-modal reserved-top-modal hidden">
        <div class="base-modal-wrapper w-full">
            <div class="bg-white reserved-modal relative">
                <div class="flex justify-between items-center top">
                    
                    <button type="button" class="close-btn">
                        <svg width="28" height="29" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="close-btn-icon">
                            <path d="M20.5998 20.6233L14.0001 14.0237M14.0001 14.0237L7.40044 7.42402M14.0001 14.0237L20.5998 7.42402M14.0001 14.0237L7.40044 20.6233" stroke="#bd191f"
                                stroke-width="1.5"
                                stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>

                <div class="venue-map-slider-wrapper">
                    <div>
                        <h5 class="modal-heading border-box">Choose a layout type</h5>
                        <div class="base-form-event-wrapper border-box layout-type">
                            <button type="button" onclick="handleReservedNext(0)" data-value="table">
                                <img src="https://cdn.evbstatic.com/s3-build/prod/1918174-rc2025-04-02_20.04-py27-6dac8f6/django/images/reserved/quick_start/table-chair.png" alt="">
                                <span>Table & Chair</span>
                            </button>
                            <button type="button" onclick="handleReservedNext(1)" data-value="section">
                                <img src="https://cdn.evbstatic.com/s3-build/prod/1918174-rc2025-04-02_20.04-py27-6dac8f6/django/images/reserved/quick_start/section-row.png" alt="">
                                <span>Sections & Rows</span>
                            </button>
                            <button type="button" onclick="handleReservedNext(2)" data-value="mixed">
                                <img src="https://cdn.evbstatic.com/s3-build/prod/1918174-rc2025-04-02_20.04-py27-6dac8f6/django/images/reserved/quick_start/mixed.png" alt="">
                                <span>Mixed Seating</span>
                            </button>
                            <button type="button" onclick="handleReservedNext(3)" data-value="blank">
                                <img src="https://cdn.evbstatic.com/s3-build/prod/1918174-rc2025-04-02_20.04-py27-6dac8f6/django/images/reserved/quick_start/blank.png" alt="">
                                <span>Blank Canvas</span>
                            </button>
                        </div>
                    </div>

                    <div class="reserved-layout-options hidden">
                        
                        <button type="button" class="back-btn close-btn" onclick="handleReservedNext(-1)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8">
                                </path>
                            </svg>
                        </button>
                        <div>
                            <h5 class="modal-heading border-box">Table & Chair</h5>
                            <div class="base-form-event-wrapper border-box">
                                <div class="mt-5 table">
                                    <div>
                                        <div class="flex justify-between items-center">
                                            <p>Number of tables:</p>
                                            <input type="number" class="transition event-input border-box seat-map--input no-of-table" name="tables" min="1" max="50"
                                                value="14">
                                        </div>
                                        <p class="error-text border-box">Your venue can have up to 50 tables.</p>
                                    </div>
                                    <div class="mt-5">
                                        <div class="flex justify-between items-center">
                                            <p>Seats per table:</p>
                                            <input type="number" class="transition event-input border-box seat-map--input no-of-seats" name="seats" min="1" max="30"
                                                value="8">
                                        </div>
                                        <p class="error-text border-box">Each table can have up to 30 seats.</p>
                                    </div>

                                    <div class="mt-5">
                                        <div>
                                            <h6 class="also-add text-center">Also Add</h6>

                                            <div class="stencil-wrapper" id="stencilWrapper">
                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="seating-amenities[]" value="stage" id="stage-1" class="hidden toggle-box" checked>
                                                    <label for="stage-1" class="stencil-item">
                                                        <i class="material-symbols-outlined">mic_external_on</i>
                                                        <p>Stage</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="seating-amenities[]" value="food" id="stage-2" class="hidden toggle-box">
                                                    <label for="stage-2" class="stencil-item">
                                                        <i class="material-symbols-outlined">restaurant</i>
                                                        <p>Food</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="seating-amenities[]" value="exit" id="stage-3" class="hidden toggle-box">
                                                    <label for="stage-3" class="stencil-item">
                                                        <i class="material-symbols-outlined">logout</i>
                                                        <p>Exit</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="seating-amenities[]" value="bathroom" id="stage-4" class="hidden toggle-box">
                                                    <label for="stage-4" class="stencil-item">
                                                        <i class="material-symbols-outlined">wc</i>
                                                        <p>Bathroom</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="seating-amenities[]" value="bar" id="stage-5" class="hidden toggle-box">
                                                    <label for="stage-5" class="stencil-item">
                                                        <i class="material-symbols-outlined">local_bar</i>
                                                        <p>Bar</p>
                                                    </label>
                                                </button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 flex items-start justify-start transition flex-column gap-05 border-box">
                            <button type="button" class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn show-seat-map-btn">Next</button>
                        </div>
                    </div>

                    <div class="hidden">
                        <button type="button" class="back-btn" onclick="handleReservedNext(-1)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8">
                                </path>
                            </svg>
                        </button>
                        <div>
                            <h5 class="modal-heading border-box">Sections & Rows</h5>
                            <div class="base-form-event-wrapper border-box">
                                <div class="mt-5">
                                    <div>
                                        <div class="flex justify-between items-center">
                                            <p>Number of sections:</p>
                                            <input type="number" class="transition event-input border-box no-of-table" min="1" max="50" value="14">
                                        </div>
                                        <p class="error-text border-box">Add up to 50 sections.</p>
                                    </div>
                                    <div class="mt-5">
                                        <div class="flex justify-between items-center">
                                            <p>Seats per table:</p>
                                            <input type="number" class="transition event-input border-box no-of-seats" min="1" max="50" value="5">
                                        </div>
                                        <p class="error-text border-box">Add up to 50 rows.</p>
                                    </div>
                                    <div class="mt-5">
                                        <div class="flex justify-between items-center">
                                            <p>Seats per row:</p>
                                            <input type="number" class="transition event-input border-box no-of-seats" min="1" max="50" value="10">
                                        </div>
                                        <p class="error-text border-box">Add up to 50 seats.</p>
                                    </div>
                                    <div class="mt-5">
                                        <div>
                                            <h6 class="also-add text-center">Also Add</h6>

                                            <div class="stencil-wrapper" id="stencilWrapper">
                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="stage" id="stage-6" class="hidden toggle-box">
                                                    <label for="stage-6" class="stencil-item">
                                                        <i class="material-symbols-outlined">mic_external_on</i>
                                                        <p>Stage</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="food" id="stage-7" class="hidden toggle-box">
                                                    <label for="stage-7" class="stencil-item">
                                                        <i class="material-symbols-outlined">restaurant</i>
                                                        <p>Food</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="exit" id="stage-8" class="hidden toggle-box">
                                                    <label for="stage-8" class="stencil-item">
                                                        <i class="material-symbols-outlined">logout</i>
                                                        <p>Exit</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="bathroom" id="stage-9" class="hidden toggle-box">
                                                    <label for="stage-9" class="stencil-item">
                                                        <i class="material-symbols-outlined">wc</i>
                                                        <p>Bathroom</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="bar" id="stage-10" class="hidden toggle-box">
                                                    <label for="stage-10" class="stencil-item">
                                                        <i class="material-symbols-outlined">sports_bar</i>
                                                        <p>Bar</p>
                                                    </label>
                                                </button>
                                            </div>
                                            <h6 class="also-add text-center">Total: <span class="total-tablesxseats">1</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 flex items-start justify-start transition flex-column gap-05 border-box">
                            <button type="button" class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                onclick="handleReservedNext(3)">Next</button>
                        </div>
                    </div>

                    <div class="hidden">
                        <button type="button" class="back-btn" onclick="handleReservedNext(-1)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8">
                                </path>
                            </svg>
                        </button>
                        <div>
                            <h5 class="modal-heading border-box">Mixed Seating</h5>
                            <div class="base-form-event-wrapper border-box">
                                <div class="mt-5">
                                    <div>
                                        <div>
                                            <p class="biuo">Sections</p>
                                            <div>
                                                <div class="flex justify-between items-center">
                                                    <p>Number of sections:</p>
                                                    <input type="number" class="transition event-input border-box no-of-table" min="1" max="50" value="14">
                                                </div>
                                                <p class="error-text border-box">Add up to 50 sections.</p>
                                            </div>
                                            <div class="mt-5">
                                                <div class="flex justify-between items-center">
                                                    <p>Rows per section:</p>
                                                    <input type="number" class="transition event-input border-box no-of-seats" min="1" max="50" value="5">
                                                </div>
                                                <p class="error-text border-box">Add up to 50 rows.</p>
                                            </div>
                                            <div class="mt-5">
                                                <div class="flex justify-between items-center">
                                                    <p>Seats per row:</p>
                                                    <input type="number" class="transition event-input border-box no-of-seats" min="1" max="50" value="10">
                                                </div>
                                                <p class="error-text border-box">Add up to 50 seats.</p>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <p class="biuo">Tables</p>
                                            <div>
                                                <div class="flex justify-between items-center">
                                                    <p>Number of tables:</p>
                                                    <input type="number" class="transition event-input border-box no-of-table" min="1" max="50" value="10">
                                                </div>
                                                <p class="error-text border-box">Add up to 50 tables.</p>
                                            </div>
                                            <div class="mt-5">
                                                <div class="flex justify-between items-center">
                                                    <p>Seats per table:</p>
                                                    <input type="number" class="transition event-input border-box no-of-seats" min="1" max="50" value="8">
                                                </div>
                                                <p class="error-text border-box">Add up to 30 seats.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div>
                                            <h6 class="also-add text-center">Also Add</h6>

                                            <div class="stencil-wrapper" id="stencilWrapper">
                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="stage" id="stage-11" class="hidden toggle-box">
                                                    <label for="stage-11" class="stencil-item">
                                                        <i class="material-symbols-outlined">mic_external_on</i>
                                                        <p>Stage</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="food" id="stage-12" class="hidden toggle-box">
                                                    <label for="stage-12" class="stencil-item">
                                                        <i class="material-symbols-outlined">restaurant</i>
                                                        <p>Food</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="exit" id="stage-13" class="hidden toggle-box">
                                                    <label for="stage-13" class="stencil-item">
                                                        <i class="material-symbols-outlined">logout</i>
                                                        <p>Exit</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="bathroom" id="stage-14" class="hidden toggle-box">
                                                    <label for="stage-14" class="stencil-item">
                                                        <i class="material-symbols-outlined">wc</i>
                                                        <p>Bathroom</p>
                                                    </label>
                                                </button>

                                                <button class="stencil-btn" type="button">
                                                    <input type="checkbox" name="bar" id="stage-15" class="hidden toggle-box">
                                                    <label for="stage-15" class="stencil-item">
                                                        <i class="material-symbols-outlined">sports_bar</i>
                                                        <p>Bar</p>
                                                    </label>
                                                </button>
                                            </div>
                                            <h6 class="also-add text-center">Total: <span class="total-tablesxseats">1</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 flex items-start justify-start transition flex-column gap-05 border-box">
                            <button type="button" class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn"
                                onclick="handleReservedNext(3)">Next</button>
                        </div>
                    </div>

                    <div class="hidden">
                        <div class="seat-map-wrapper">
                            
                            <button type="button" class="back-btn " onclick="handleReservedNext(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8">
                                    </path>
                                </svg>
                            </button>
                            <div class="top-section">
                                <div class="left">
                                    <button class="item map-item active" type="button"
                                        onclick="tabMenuSwitch('tiers-item', this)"
                                        data-value="tier">Tiers
                                    </button>
                                    <button class="item map-item" type="button"
                                        onclick="tabMenuSwitch('holds-item', this)"
                                        data-value="hold">Holds
                                    </button>
                                </div>
                                <div class="right">
                                    <button class="save-btn" type="button">Save</button>
                                </div>
                            </div>

                            <div class="bottom-section">
                                <div class="left-side">
                                    <div class="zoom-btns">
                                        <button type="button" id="zoomInBtn">+</button>
                                        <button type="button" id="zoomOutBtn">-</button>
                                    </div>
                                    <div class="seating-plan-container"></div>
                                </div>
                                <aside class="right-side relative">
                                    <div id="tiers-item" class="item tiers-wrapper">
                                        <div class="tiers-header">
                                            <h4 class="heading">Tiers</h4>
                                            <button class="create-new-tiers-btn tier transition" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                                    <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"></path>
                                                </svg> Create New Tier
                                            </button>
                                        </div>

                                        <div class="tiers-sidebar tiers"></div>
                                    </div>

                                    <div id="holds-item" class="item tiers-wrapper hidden">
                                        <div class="tiers-header">
                                            <h4 class="heading">Held</h4>
                                            <button class="create-new-tiers-btn hold transition" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                                    <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"></path>
                                                </svg> Create New Hold
                                            </button>
                                        </div>

                                        <div class="holds-sidebar holds"></div>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Post Event Modal Menu Ends Here -->

</form>



<?php $__env->startPush('css'); ?>
    <style>
        canvas {
            font-family: 'Material Symbols Outlined', sans-serif;
        }

        .hidden {
            display: none !important;
        }

        .block {
            display: block !important;
        }

        .checkbox-wrapper-16 {
            width: fit-content;
        }

        .checkbox-wrapper-16 *,
        .checkbox-wrapper-16 *:after,
        .checkbox-wrapper-16 *:before {
            box-sizing: border-box;
        }

        .checkbox-wrapper-16 .checkbox-input {
            clip: rect(0 0 0 0);
            -webkit-clip-path: inset(100%);
            clip-path: inset(100%);
            height: 1px;
            overflow: hidden;
            position: absolute;
            white-space: nowrap;
            width: 1px;
        }

        .checkbox-wrapper-16 .checkbox-input:checked+.checkbox-tile {
            border-color: #bd191f;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            color: #bd191f;
        }

        .checkbox-wrapper-16 .checkbox-input:checked+.checkbox-tile:before {
            transform: scale(1);
            opacity: 1;
            background-color: #bd191f;
            border-color: #bd191f;
        }

        .checkbox-wrapper-16 .checkbox-input:checked+.checkbox-tile .checkbox-icon,
        .checkbox-wrapper-16 .checkbox-input:checked+.checkbox-tile .checkbox-label {
            color: #bd191f;
        }

        .checkbox-wrapper-16 .checkbox-input:focus+.checkbox-tile {
            border-color: #bd191f;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #bd191f63
        }

        .checkbox-wrapper-16 .checkbox-input:focus+.checkbox-tile:before {
            transform: scale(1);
            opacity: 1;
        }

        .checkbox-wrapper-16 .checkbox-tile {
            display: flex;
            /* flex-direction: column; */
            align-items: center;
            justify-content: center;
            width: fit-content;
            /* min-height: 7rem; */
            border-radius: 0.5rem;
            border: 2px solid #bd191f63;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            transition: 0.15s ease;
            cursor: pointer;
            position: relative;
            gap: 1rem;
            padding: 10px 10px;
        }

        .checkbox-wrapper-16 .checkbox-tile:before {
            content: "";
            position: absolute;
            display: block;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #bd191f63;
            background-color: #fff;
            border-radius: 50%;
            top: 0.25rem;
            left: 0.25rem;
            opacity: 0;
            transform: scale(0);
            transition: 0.25s ease;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='192' height='192' fill='%23FFFFFF' viewBox='0 0 256 256'%3E%3Crect width='256' height='256' fill='none'%3E%3C/rect%3E%3Cpolyline points='216 72.005 104 184 48 128.005' fill='none' stroke='%23FFFFFF' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'%3E%3C/polyline%3E%3C/svg%3E");
            background-size: 12px;
            background-repeat: no-repeat;
            background-position: 50% 50%;
        }

        .checkbox-wrapper-16 .checkbox-tile:hover {
            border-color: #bd191f;
        }

        .checkbox-wrapper-16 .checkbox-tile:hover:before {
            transform: scale(1);
            opacity: 1;
        }

        .checkbox-wrapper-16 .checkbox-icon {
            transition: 0.375s ease;
            color: #494949;
        }

        .checkbox-wrapper-16 .checkbox-icon svg {
            width: 3rem;
            height: 3rem;
        }

        .checkbox-wrapper-16 .checkbox-label {
            color: #707070;
            transition: 0.375s ease;
            text-align: center;
        }

        .reserved-top-modal .seat-map-wrapper .bottom-section .left-side {
            position: relative;
        }

        .reserved-top-modal .seat-map-wrapper .bottom-section .left-side .zoom-btns {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 99;
            width: 40px;
            height: 80px;
            box-shadow: 0 1px 4px rgba(40, 44, 52, 0.1), 0 0 8px 0 rgba(40, 44, 52, 0.1);
        }

        .reserved-top-modal .seat-map-wrapper .bottom-section .left-side .zoom-btns button {
            display: flex;
            width: 40px;
            height: 40px;
            background: #fff;
            border: none;
            border-bottom: 1px solid #EEEDF2;
            font-size: 30px;
            align-items: center;
            justify-content: center;
        }

        .reserved-top-modal .seat-map-wrapper .bottom-section .left-side .zoom-btns button:hover {
            background-color: #F8F7FA;
        }

        .add-ticket-paid-items {
            position: relative;
        }
        
        .add-ticket-paid-items .add-ticket-input-item-wrapper {
            padding: 0 1rem;
        }

        .add-ticket-paid-items .overlay {
            position: absolute;
            background-color: rgba(230, 230, 230, 0.75);
            cursor: pointer;
            z-index: 10;
            height: 100%;
            width: 100%;
            top: -7px;
            left: 7px;
        }

        .add-ticket-paid-items .overlay i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            color: #000;
        }

        .seating-plan-container {
            height: 100%;
            width: 100%;
        }
        
        .tiers-sidebar.tiers {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        /* .tiers-sidebar.tiers .add-ticket-paid-items {
            padding: 0 1rem;
        }
        */
        
        
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <?php echo e(csrf_token()); ?>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    
    <script src="<?php echo e(asset('admins/js/seating-plan/konva-lib.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/seating-plan/konva.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/seating-plan/seating-plan.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/seating-plan/seating-modal.js')); ?>"></script>

    <script>
        function resetEventForm() {
            new FormValidator().clearForm();
            $('.header-image-prev').attr('src', "<?php echo e(asset('admins/images/profile/placeholder.png')); ?>").data('src', "<?php echo e(asset('admins/images/profile/placeholder.png')); ?>");
            $('.display-img-create-order').html('');
            const valuesToDisplay = {
                bannerMedia: [],
                eventName: null,
                scheduleBy: null,
                eventDate: null,
                timeDuration: null,
                defaultPrice: null,
                venueName: null,
                description: null,
                faq: [],
            };
            passDataToObject(valuesToDisplay);
            $('#event-create-form').find('input[name="_token"]').val(`<?php echo e(csrf_token()); ?>`);
            $('#event-create-form').find('input[name="organizer_name"]').val('<?php echo e(Auth::user()->full_name); ?>');
            $('#event-create-form').find('input[name="organizer_email"]').val('<?php echo e(Auth::user()->email); ?>');
            $('#event-create-form').find('input[name="organizer_phone"]').val('<?php echo e(Auth::user()->phone); ?>');


        }
        // $(document).ready(function() {
        //     $('#event-create-form').on('submit', function(e) {
        //         e.preventDefault();
        //         console.log(new FormData());
        //         alert('test');

        //         const wrapper = document.querySelector("#event-duration-wrapper");
        //         const innerWrapper = wrapper.querySelector(".schedule-by-items-wrapper");
        //         const items = innerWrapper.querySelectorAll(".schedule-by-items");

        //         items.forEach(item => {
        //             const isNotActive = item.classList.contains("hidden");
        //             if (isNotActive) {
        //                 item.remove();
        //             }
        //         });
        //         // Submit the form after delay
        //         setTimeout(() => {
        //             console.log('Submitting form...');
        //             $(this).off('submit').submit();
        //         }, 1000);
        //     });
        // });

        $(document).ready(function() {
            let currentIndex = -1; // To track the currently selected suggestion


            function fetchSuggestions(query, $city, $suggestionsList, $input, $preloader) {
                $preloader.show(); // Show loader
                axios.get('https://api.geoapify.com/v1/geocode/autocomplete', {
                        params: {
                            text: query,
                            apiKey: '<?php echo e(env('GEOAPIFY_API')); ?>', // Replace with your valid API key
                        }
                    })
                    .then(function(response) {
                        let suggestions = response.data.features;
                        $suggestionsList.empty(); // Clear any old suggestions
                        currentIndex = -1; // Reset index when fetching new suggestions

                        // Loop through the suggestions and append them to the suggestion list
                        suggestions.forEach(function(suggestion, index) {
                            let formatted = suggestion.properties.formatted || '';
                            let city = suggestion.properties.city || suggestion.properties.state || suggestion.properties.country || '';
                            let latitude = suggestion.geometry.coordinates[1];
                            let longitude = suggestion.geometry.coordinates[0];

                            // Create a list item for each suggestion
                            let $listItem = $('<li></li>').addClass('suggestion-item').data({
                                'latitude': latitude,
                                'longitude': longitude,
                                'formatted': formatted,
                                'city': city,
                                'index': index
                            }).text(formatted);

                            // Append the list item to the suggestions list
                            $suggestionsList.append($listItem);

                            // When a suggestion is clicked, fill the form with the selected data
                            $listItem.on('click', function() {
                                selectSuggestion($(this), $city, $input, $suggestionsList, $preloader);
                            });
                        });

                        $preloader.hide(); // Hide loader after suggestions are displayed
                    })
                    .catch(function(error) {
                        console.error('Error fetching suggestions:', error);
                        $preloader.hide();
                    });
            }

            function selectSuggestion($listItem, $city, $input, $suggestionsList, $preloader) {
                let lat = $listItem.data('latitude');
                let lon = $listItem.data('longitude');
                let formattedAddress = $listItem.data('formatted');
                let city = $listItem.data('city');

                // Fill input fields with selected address and coordinates
                $city.val(city);
                $input.val(formattedAddress);
                $('#latitude').val(lat);
                $('#longitude').val(lon);

                // Clear suggestions and hide preloader
                $suggestionsList.empty();
                $preloader.hide();
            }

            function highlightSuggestion(index, $suggestionsList) {
                $suggestionsList.children().removeClass('highlighted'); // Remove highlight from all items
                let $item = $suggestionsList.children().eq(index);
                $item.addClass('highlighted'); // Highlight the currently selected item
            }

            function setupInputHandlers($input, $city, $suggestionsList, $preloader) {
                // Trigger suggestions fetch when typing in the input
                $input.on('input', function() {
                    let query = $(this).val();
                    if (query.length > 0) {
                        fetchSuggestions(query, $city, $suggestionsList, $input, $preloader);
                    } else {
                        $suggestionsList.empty();
                        $preloader.hide();
                    }
                });

                // Keyboard navigation
                $input.on('keydown', function(e) {
                    let suggestionsCount = $suggestionsList.children().length;
                    if (suggestionsCount > 0) {
                        if (e.key === 'ArrowDown') {
                            // Move down in the list
                            currentIndex = (currentIndex + 1) % suggestionsCount;
                            highlightSuggestion(currentIndex, $suggestionsList);
                        } else if (e.key === 'ArrowUp') {
                            // Move up in the list
                            currentIndex = (currentIndex - 1 + suggestionsCount) % suggestionsCount;
                            highlightSuggestion(currentIndex, $suggestionsList);
                        } else if (e.key === 'Enter' && currentIndex !== -1) {
                            // Select the highlighted suggestion
                            let $selectedItem = $suggestionsList.children().eq(currentIndex);
                            selectSuggestion($selectedItem, $input, $suggestionsList, $preloader);
                        }
                    }
                });

                // Hide suggestions when clicking outside the input or suggestions list
                $(document).on('click', function(e) {
                    if (!$(e.target).closest($input).length && !$(e.target).closest($suggestionsList)
                        .length) {
                        $suggestionsList.empty();
                        $preloader.hide();
                    }
                });
            }

            // Setup handlers for input and suggestions
            $('input[name="address"]').after('<div class="list" id="address_suggestions"><ul></ul></div>');
            $('input[name="address"]').before(
                '<div id="preloader" class="preloader" style="display: none;"><img src = "https://taxigo.thepreview.pro/front/images/icons/loader.gif" alt = "Loading..." ></div>');
            setupInputHandlers($('input[name="address"]'), $('input[name="city"]'), $('#address_suggestions ul'), $('#event_preloader'));

            $('input[name="ticket_location"]').before(
                '<div id="preloader" class="preloader" style="display: none;"><img src = "https://taxigo.thepreview.pro/front/images/icons/loader.gif" alt = "Loading..." ></div>');
            $('input[name="ticket_location"]').before('<div class="list" id="ticket_location_suggestions"><ul></ul></div>');
            setupInputHandlers($('input[name="ticket_location"]'), $('#event-city'), $('#ticket_location_suggestions ul'), $('#event_preloader'));

        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/models/events.blade.php ENDPATH**/ ?>