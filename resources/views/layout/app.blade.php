@php $data = App\Helpers\Setting::data() @endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @hasSection('title')
        @yield('title')
    @else
        <title>{{ $data->site_name }}</title>
    @endif
    <link rel="icon" href="{{ asset('/' . $data->favicon) }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('/' . $data->favicon) }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('/' . $data->favicon) }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/tailwind/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/tailwind/tw.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/base.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('admins/css/normalizer.css') }}" />
    <link rel="stylesheet" href="{{ asset('admins/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/css/hamburger.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/css/custom-calendar/calendar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('admins/css/custom.css') }}">
    @yield('css')
    @stack('css')
    @stack('style')
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <header class="full-width bg-black">
        <nav class="flex justify-between items-center nav-wrapper">
            <a href="{{ $data->site_url }}">
                <img class="select-none w-full nav-logo" src="{{ asset('/' . $data->logo) }}" alt="site-logo" title="Unifying Caribbean People Socially Mentally $ Economically"
                    draggable="false">
            </a>
            <div class="transition nav-links-wrapper">
                <a href="{{ route('admin.dashboard') }}"
                    class="text-normalize inline text-white transition nav-link">Home</a>
                <a href="{{ route('admin.all.events') }}"
                    class="text-normalize inline text-white transition nav-link">All Events</a>
                @if (Auth::check() && Auth::user()->role !== \App\Enums\Role::SUPERADMIN)
                    <a href="{{ route('admin.followers') }}"
                        class="text-normalize inline text-white transition nav-link">All Followers</a>
                @endif
                @if (Auth::check() && Auth::user()->role == \App\Enums\Role::SUPERADMIN)
                    <a href="{{ route('admin.all.users') }}"
                        class="text-normalize inline text-white transition nav-link">All Users</a>
                    <a href="{{ route('admin.email.index') }}"
                        class="text-normalize inline text-white transition nav-link">Emails</a>
                @endif
                @auth
                    <div class="text-normalize inline text-white transition nav-link relative" onclick="handleNotification(this)">
                        <div class="text-normalize inline text-white transition nav-link">
                            <div class="inline notification-nav btn-normalize relative nav-notification-btn">
                                <button class="inline notification-nav btn-normalize relative nav-notification-btn">
                                    <i class="fa-solid fa-bell active-notification"></i>
                                    <p class="notification-count text-white">{{ Auth::user()->unreadNotifications->count() }}</p>
                                </button>
                            </div>

                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <div class="absolute dropdown-wrapper notification-dropdown-main-wrapper">
                                    <div
                                        class="dropdown all-notification-wrapper flex justify-start items-start flex-column p-15px">
                                        @foreach (Auth::user()->unreadNotifications as $notification)
                                            <a class="nav-notification-item"
                                                href="{{ $notification->data['object']['var'] != null ? route($notification->data['object']['route'], $notification->data['object']['var']) : route($notification->data['object']['route']) }}">
                                                @if (isset($notification->data['object']['image']))
                                                    <img class="select-none rounded-full basic-connection-image"
                                                        src="{{ $notification->data['object']['image'] }}" alt="{{ $loop->iteration }}"
                                                        draggable="false">
                                                @endif
                                                @if (isset($notification->data['object']['video']))
                                                    <video class="select-none rounded-full basic-connection-image"
                                                        src="{{ $notification->data['object']['video'] }}"
                                                        draggable="false"></video>
                                                @endif
                                                <div>
                                                    <p class="notification-message-text">{{ $notification->data['message'] }}
                                                    </p>
                                                    <p class="notification-message-time">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </a>
                                        @endforeach
                                        <a class="nav-notification-item nav-notification-item-read-more"
                                            href="{{ route('admin.notifications') }}">
                                            <p class="mx-auto">Read More</p>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>



                @endauth
            </div>
            @auth
                <div class="transition nav-button-wrapper">
                    <a href="{{ route('admin.logout') }}"
                        class="text-normalize transition nav-btn flex justify-center items-center ">
                        <span class="text-white material-symbols-outlined">meeting_room</span>
                        <p>Signout</p>
                    </a>
                </div>
            @else
                <div class="transition nav-button-wrapper">
                    <a href="{{ route('admin.login') }}"
                        class="text-normalize transition nav-btn flex justify-center items-center ">
                        <span class="text-white material-symbols-outlined">meeting_room</span>
                        <p>Sign In</p>
                    </a>
                </div>
            @endauth
            <button class="hamburger humbtn" onclick="handleHamburgerClick(this)">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </nav>
        <!-- Mobile Navbar Starts Here -->
        <nav class="mobile-navbar">
            <div class="transition mobile-nav-links-wrapper bg-white">

                <a href="{{ route('admin.dashboard') }}"
                    class="text-normalize inline text-black transition nav-link">Home</a>
                <a href="{{ route('admin.all.events') }}"
                    class="text-normalize inline text-black transition nav-link">All Events</a>
                @if (Auth::check() && Auth::user()->role !== \App\Enums\Role::SUPERADMIN)
                    <a href="{{ route('admin.followers') }}"
                        class="text-normalize inline text-black transition nav-link">All Followers</a>
                @endif
                @if (Auth::check() && Auth::user()->role == \App\Enums\Role::SUPERADMIN)
                    <a href="{{ route('admin.all.users') }}"
                        class="text-normalize inline text-black transition nav-link">All Users</a>
                    <a href="{{ route('admin.email.index') }}"
                        class="text-normalize inline text-black transition nav-link">Emails</a>
                @endif
                @auth
                    <a href="{{ route('admin.notifications') }}"
                        class="text-normalize inline text-black transition nav-link">
                        <div class="flex justify-between items-center">
                            <p>Notification</p>
                            <p class="text-black">{{ Auth::user()->unreadNotifications->count() }}</p>
                        </div>
                    </a>
                @endauth
            </div>
        </nav>
        <!-- Mobile Navbar Ends Here -->
    </header>
    <!-- Navbar Section Ends Here -->
    @yield('admin')
    @stack('modals')
    {{-- <footer id="footer-section" style="margin-top: 0 !important;">
    <div class="footer-wrapper">
        <div class="footer-first-section">
            <div class="footer-contact-main-wrapper">
                <div class="footer-contact-wrapper transition">
                    <p class="footer-contact-git transition">GET IN TOUCH</p>
                    <p class="footer-contact-caf transition">Caribbean Air Force</p>
                </div>
                <div class="footer-contact-wrapper transition">
                    <a href="tel:{{ $data->phone }}" class="footer-contact-tel transition">{{ $data->phone }}</a>
                    <a href="mailto:{{ $data->email }}" class="footer-contact-tel transition">{{ $data->email }}</a>
                </div>
            </div>
            <div class="footer-nav-links-main-wrapper transition">
                <div class="footer-nav-links-wrapper transition">
                    <a href="###" class="footer-nav-link-items transition">⯈ <span
                            class="footer-nav-link-items-inner transition">Home</span></a>
                    <a href="###" class="footer-nav-link-items transition">⯈ <span
                            class="footer-nav-link-items-inner transition">Artists</span></span></a>
                    <a href="###" class="footer-nav-link-items transition">⯈ <span
                            class="footer-nav-link-items-inner transition">Radio DJs</span></a>
                    <a href="###" class="footer-nav-link-items transition">⯈ <span
                            class="footer-nav-link-items-inner transition">Privacy Policy</span></a>
                </div>
                <div class="footer-nav-links-wrapper transition">
                    <a href="###" class="footer-nav-link-items transition">⯈ <span
                            class="footer-nav-link-items-inner transition">Services</span></span></a>
                    <a href="###" class="footer-nav-link-items transition">⯈ <span
                            class="footer-nav-link-items-inner transition">Blog</span></a>
                    <a href="###" class="footer-nav-link-items transition">⯈ <span
                            class="footer-nav-link-items-inner transition">Contact Us</span></a>
                </div>
            </div>
        </div>

        <div class="footer-second-section">
            <div class="footer-logo-wrapper transition">
                <img class="footer-logo transition"
                    src="https://caribbeanairforce.com/wp-content/uploads/2024/01/logo-25.png" alt="site-logo"
                    draggable="false">
            </div>
            <div class="footer-copyright transition">
                <p class="footer-copyright-text transition">All rights reserved by <a href="###"
                        class="footer-copyright-text-a-tag">Caribbean Air Force</a></p>
                <div class="footer-icons-wrapper transition">
                    <a href="###" class="footer-icon transition"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="###" class="footer-icon transition"><i class="fa-brands fa-twitter"></i></a>
                    <a href="###" class="footer-icon transition"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="###" class="footer-icon transition"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-third-section transition">
            <button id="scrollTopBtn" class="elevate-button transition">
                <i class="fa-solid fa-chevron-up"></i>
            </button>
        </div>

    </div>
</footer> --}}

    <footer id="footer-section" style="margin-top: 0 !important;">
        <div class="footer-wrapper">
            <div class="footer-first-section">
                <div class="footer-contact-main-wrapper">
                    <div class="footer-contact-wrapper transition">
                        <p class="footer-contact-git transition">GET IN TOUCH</p>
                        <p class="footer-contact-caf transition">{{ $data->site_name }}</p>
                    </div>
                    <div class="footer-contact-wrapper transition">
                        <a href="tel:{{ $data->phone }}" class="footer-contact-tel transition">{{ $data->phone }}</a>
                        <a href="mailto:{{ $data->email }}" class="footer-contact-tel transition">{{ $data->email }}</a>
                        <div>
                            <p class="footer-nav-link-items-inner transition footer-contact-caf  transition">Caribbean
                                Air Force
                            <p>
                            <p class="footer-nav-link-items-inner transition footer-contact-caf  transition">(Atlanta
                                Financial Center)
                            <p>
                        </div>

                        <div>
                            <p class="footer-nav-link-items-inner transition footer-contact-caf  transition">3343
                                Peachtree Rd NE Ste 145-1162 <br> Atlanta, GA 30326
                            <p>
                            <p class="footer-nav-link-items-inner transition footer-contact-caf  transition">United
                                States
                            <p>
                        </div>


                    </div>
                </div>
                <div class="footer-nav-links-main-wrapper transition">
                    <div class="footer-nav-links-wrapper transition">
                        <a href="https://caribbeanairforce.com/" class="footer-nav-link-items transition">⯈ <span
                                class="footer-nav-link-items-inner transition">Home</span></a>
                        <a href="https://caribbeanairforce.com/artists/" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Artists</span></a>
                        <a href="https://caribbeanairforce.com/radio-djs/" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Radio DJs</span></a>
                        <a href="{{ route('privacy.policy') }}"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Privacy Policy</span></a>
                        <a href="https://caribbeanairforce.com/terms-and-conditions/" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Terms & Conditions (Online<br>&emsp; Ticket Sales)</span></a>
                        <a href="{{ route('faqs') }}"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">FAQs</span></a>
                    </div>
                    <div class="footer-nav-links-wrapper transition">
                        <a href="https://caribbeanairforce.com/services/" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Services</span></a>
                        <a href="{{ route('events.index') }}" class="footer-nav-link-items transition">⯈ <span
                                class="footer-nav-link-items-inner transition">Event</span></a>
                        <a href="{{ route('faqs.radio') }}" class="footer-nav-link-items transition">⯈ <span
                                class="footer-nav-link-items-inner transition">FAQs (Online Radio Station)</span></a>
                        <a href="https://caribbeanairforce.com/contact-us/" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Contact Us</span></a>
                        <a href="{{ route('terms.policy') }}" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Terms & Conditions (Third-Party<br>&emsp; Event Posting)</span></a>
                        <a href="{{ route('intellectual.policy') }}"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Intellectual Property Rights</span></a>
                    </div>
                </div>
            </div>

            <div class="footer-second-section">
                <div class="footer-logo-wrapper transition">
                    <img class="footer-logo transition" src="{{ asset('/' . $data->logo) }}" alt="site-logo"
                        title="Unifying Caribbean People Socially Mentally $ Economically" draggable="false">
                </div>
                <div class="footer-copyright transition">
                    <p class="footer-copyright-text transition">All rights reserved by <a href="javascript:void(0);" class="footer-copyright-text-a-tag">{{ $data->site_name }}</a>
                    </p>
                    <div class="footer-icons-wrapper transition">
                        <a href="{{ $data->facebook }}" class="footer-icon transition"><i
                                class="fa-brands fa-facebook-f"></i></a>
                        <a href="{{ $data->twitter }}" class="footer-icon transition"><i
                                class="fa-brands fa-twitter"></i></a>
                        <a href="{{ $data->linkedin }}" class="footer-icon transition"><i
                                class="fa-brands fa-linkedin"></i></a>
                        <a href="{{ $data->instagram }}" class="footer-icon transition"><i
                                class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-third-section transition">
                <button id="scrollTopBtn" class="elevate-button transition">
                    <i class="fa-solid fa-chevron-up"></i>
                </button>
            </div>

        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function ajaxLoader(selector, text) {
            $(selector).html('<div class="ajax-loader"><i class="fa-solid fa-spinner fa-pulse"></i></div>');
            $(document).one('ajaxStop', function() {
                $(selector).html(text);
            });
        }

        function checkAndRefreshCsrfToken() {
            setInterval(() => {
                fetch('/refresh-csrf')
                    .then(response => response.json())
                    .then(data => {
                        const currentToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        console.log(currentToken, data.csrf_token);
                        if (currentToken !== data.csrf_token) {
                            // Update the CSRF token in the meta tag
                            document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);

                            // Reload the page to ensure the application uses the new token
                            location.reload();
                        }
                    })
                    .catch(err => console.error('Error refreshing CSRF token:', err));
            }, 2000); // Check every 60 seconds
        }

        // Call the function to start monitoring
        // checkAndRefreshCsrfToken();
    </script>
    <script src="{{ asset('admins/js/general.js') }}"></script>
    <script src="{{ asset('asset/js/general.js') }}"></script>
    <script src="{{ asset('admins/js/scroll-to-top.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".event-datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            defaultDate: "today",
        });
    </script>

    {{-- <script>
    const userTime = new Date();
const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

fetch("{{ route('set.timezone') }}", {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
        localTime: userTime.toString(),
        timezone: userTimezone
    })
})
    .then(response => response.json())
    .then(data => console.log('User timezone data sent successfully', data))
    .catch(error => console.error('Error:', error));

</script> --}}
    @yield('js')
    @stack('js')
    @stack('script')
    @include('sweetalert::alert')

</body>

</html>
