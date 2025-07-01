<!-- Post Event Modal Menu Starts Here -->
<form method="post" action="{{ route('admin.events.booking', $event->slug) }}" id="event-booking-form"
    enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="" id="event-id">
    <div id="create-event-modal" class="modal-wrapper">
        <div class="base-event-modal-wrapper">
            <div class="bg-white" id="create-event-container">
                <div class="base-event-dp-modal">
                    <button type="button" class="modal-event-back-btn hidden" onclick="handleBackEventCreateModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000"
                            class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8">
                            </path>
                        </svg>
                    </button>

                    <button type="button" class="modal-event-close-btn" onclick="handleHideEventCreateModal()">
                        <svg width="28" height="29" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="close-btn-icon">
                            <path
                                d="M20.5998 20.6233L14.0001 14.0237M14.0001 14.0237L7.40044 7.42402M14.0001 14.0237L20.5998 7.42402M14.0001 14.0237L7.40044 20.6233"
                                stroke="#bd191f" stroke-width="1.5" stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>
                <div id="create-event-modal-inner">

                    <!-- Event Preview -->
                    <div id="event-preview-wrapper" class="modal-inner-content-wrapper border-box scale-0 hidden"
                        style="max-height: 95vh; overflow-y: auto">
                        <h3 class="modal-heading border-box">Ticket Id: <span id="preview-ticketid">{{ 'TKT' .
                                str_pad(random_int(1, 9999999), 7, '0', STR_PAD_LEFT) }}</span></h3>
                        <div class="base-form-event-wrapper border-box">
                            <div class="mb-1 transition flex flex-column gap-05 justify-start items-start border-box">
                                <div class="w-full">
                                    <!-- Main Preview Content Starts Here -->
                                    <div class="overflow-hidden w-full feed-img-wrapper">
                                        <img id="preview-image" class="w-full select-none object-cover feed-img"
                                            src="{{ $event->image }}" alt="" draggable="false">
                                    </div>
                                    <!-- Slider Starts Here -->
                                    <div class="swiper create-event-preview-slider">
                                        <div class="swiper-wrapper" id="event-preview-media-slider"></div>
                                        <!-- Navigation Buttons -->
                                        <div class="swiper-button-next preview-event-navigation-next more-feeds-next">
                                        </div>
                                        <div class="swiper-button-prev preview-event-navigation-prev more-feeds-next">
                                        </div>
                                    </div>
                                    <!-- Slider Ends Here -->
                                    <div class="event-preview-body">
                                        <div class="event-preview-title-body">
                                            <div class="event-preview-title-wrapper">
                                                <!-- Event Title Here -->
                                                <h4 id="preview-name">Alana Carey</h4>
                                            </div>

                                            <div class="event-preview-location-time-wrapper">
                                                <div class="event-preview-location-wrapper">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    <!-- Event Location, Date & Time -->
                                                    <p class="text-wrap preview-venue">Theodore George, Aut alias autem
                                                        volu</p>
                                                </div>
                                                <!-- Event Date Time -->
                                                <div class="event-preview-location-wrapper">
                                                    <!-- Event Time -->
                                                    <p class="feed-time">10:22 PM - 7:12 PM</p>
                                                    <!-- Event Date -->
                                                    <p class="feed-date">Friday, July 6, 1990 - Tuesday, May 9, 1989</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="event-media-display-wrapper" id="banner-display-img-2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="transition flex flex-column gap-05 justify-start items-start border-box">
                                <button type="submit"
                                    class="mt-1 transition text-white base-form-event-wrapper-btn w-full border-box">
                                    Join Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Post Event Modal Menu Ends Here -->

{{-- <section class="events-section-inner px-15px mt-7">
    <div class="py-1 mb-1 relative">
        <h1 class="welcome-heading">Discover More Events You Might Like</h1>
        <div class="svg-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="shape-fill"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="shape-fill"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </div>
    <div class="swiper more-feeds">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="feed-card-wrapper">
                    <a href="./all-events-by-user.html" class="text-normalize text-black inline">
                        <div class="flex justify-start items-center gap-05">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="./images/connection-12.png" alt="Profile image of Daniel Scott" draggable="false">
                            <div class="flex flex-column justify-start items-center gap-03">
                                <p class="basic-connection-name">Daniel Scott</p>
                                <p class="basic-connection-time">
                                    <span>13 sep</span> at <span>21:13</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="feed-body">
                        <div class="overflow-hidden feed-img-wrapper relative">
                            <img class="w-full select-none object-cover feed-img" src="./images/feed-1.jpg"
                                alt="Event image for Weekend Wellness Workshop" draggable="false">
                            <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
                                <button class="feed-card-menu-drop-downmenu-btn" aria-label="Menu">
                                    <span class="material-symbols-outlined"> more_vert </span>
                                </button>
                                <div class="absolute card-dropdown-wrapper">
                                    <div class="dropdown card-dropdown-inner-wrapper">
                                        <button onclick="handleEventEditAction()">
                                            <span class="material-symbols-outlined"> edit </span>
                                            <p>Edit</p>
                                        </button>
                                        <a href="###">
                                            <span class="material-symbols-outlined"> delete </span>
                                            <p>Delete</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-content-body-wrapper">
                            <div class="feed-content-title-date-time-wrapper">
                                <h4 class="feed-title feed-title-min text-wrap">Weekend Wellness Workshop</h4>
                            </div>
                        </div>
                        <div class="feed-content-location-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="text-wrap">Greenfield Community Center, 123 Elm Street, Hometown</p>
                        </div>
                        <div class="feed-interaction-wrapper">
                            <a href="./upcoming-events-inner.html"
                                class="card-unfollow-btn-lg feed-follow-btn w-full">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="swiper-button-next more-feeds-next"></div>
            <div class="swiper-button-prev more-feeds-next"></div>
        </div>
    </div>
</section> --}}
