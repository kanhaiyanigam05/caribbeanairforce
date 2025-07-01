<?php $data = App\Helpers\Setting::data() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <?php if (! empty(trim($__env->yieldContent('title')))): ?>
        <?php echo $__env->yieldContent('title'); ?>
    <?php else: ?>
        <title><?php echo e($data->site_name); ?></title>
    <?php endif; ?>
    <link rel="icon" href="<?php echo e(asset('/' . $data->favicon)); ?>" sizes="32x32" />
    <link rel="icon" href="<?php echo e(asset('/' . $data->favicon)); ?>" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?php echo e(asset('/' . $data->favicon)); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/tailwind/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/tailwind/tw.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/base.css')); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/normalizer.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/hamburger.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/footer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/custom-calendar/calendar.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/custom.css')); ?>">
    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->yieldPushContent('css'); ?>
    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <header class="full-width bg-black">
        <nav class="flex justify-between items-center nav-wrapper">
            <a href="<?php echo e($data->site_url); ?>">
                <img class="select-none w-full nav-logo" src="<?php echo e(asset('/' . $data->logo)); ?>" alt="site-logo" title="Unifying Caribbean People Socially Mentally $ Economically"
                    draggable="false">
            </a>
            <div class="transition nav-links-wrapper">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="text-normalize inline text-white transition nav-link">Home</a>
                <a href="<?php echo e(route('admin.all.events')); ?>"
                    class="text-normalize inline text-white transition nav-link">All Events</a>
                <?php if(Auth::check() && Auth::user()->role !== \App\Enums\Role::SUPERADMIN): ?>
                    <a href="<?php echo e(route('admin.followers')); ?>"
                        class="text-normalize inline text-white transition nav-link">All Followers</a>
                <?php endif; ?>
                <?php if(Auth::check() && Auth::user()->role == \App\Enums\Role::SUPERADMIN): ?>
                    <a href="<?php echo e(route('admin.all.users')); ?>"
                        class="text-normalize inline text-white transition nav-link">All Users</a>
                    <a href="<?php echo e(route('admin.email.index')); ?>"
                        class="text-normalize inline text-white transition nav-link">Emails</a>
                <?php endif; ?>
                <?php if(auth()->guard()->check()): ?>
                    <div class="text-normalize inline text-white transition nav-link relative" onclick="handleNotification(this)">
                        <div class="text-normalize inline text-white transition nav-link">
                            <div class="inline notification-nav btn-normalize relative nav-notification-btn">
                                <button class="inline notification-nav btn-normalize relative nav-notification-btn">
                                    <i class="fa-solid fa-bell active-notification"></i>
                                    <p class="notification-count text-white"><?php echo e(Auth::user()->unreadNotifications->count()); ?></p>
                                </button>
                            </div>

                            <?php if(Auth::user()->unreadNotifications->count() > 0): ?>
                                <div class="absolute dropdown-wrapper notification-dropdown-main-wrapper">
                                    <div
                                        class="dropdown all-notification-wrapper flex justify-start items-start flex-column p-15px">
                                        <?php $__currentLoopData = Auth::user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a class="nav-notification-item"
                                                href="<?php echo e($notification->data['object']['var'] != null ? route($notification->data['object']['route'], $notification->data['object']['var']) : route($notification->data['object']['route'])); ?>">
                                                <?php if(isset($notification->data['object']['image'])): ?>
                                                    <img class="select-none rounded-full basic-connection-image"
                                                        src="<?php echo e($notification->data['object']['image']); ?>" alt="<?php echo e($loop->iteration); ?>"
                                                        draggable="false">
                                                <?php endif; ?>
                                                <?php if(isset($notification->data['object']['video'])): ?>
                                                    <video class="select-none rounded-full basic-connection-image"
                                                        src="<?php echo e($notification->data['object']['video']); ?>"
                                                        draggable="false"></video>
                                                <?php endif; ?>
                                                <div>
                                                    <p class="notification-message-text"><?php echo e($notification->data['message']); ?>

                                                    </p>
                                                    <p class="notification-message-time"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                                                </div>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <a class="nav-notification-item nav-notification-item-read-more"
                                            href="<?php echo e(route('admin.notifications')); ?>">
                                            <p class="mx-auto">Read More</p>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>



                <?php endif; ?>
            </div>
            <?php if(auth()->guard()->check()): ?>
                <div class="transition nav-button-wrapper">
                    <a href="<?php echo e(route('admin.logout')); ?>"
                        class="text-normalize transition nav-btn flex justify-center items-center ">
                        <span class="text-white material-symbols-outlined">meeting_room</span>
                        <p>Signout</p>
                    </a>
                </div>
            <?php else: ?>
                <div class="transition nav-button-wrapper">
                    <a href="<?php echo e(route('admin.login')); ?>"
                        class="text-normalize transition nav-btn flex justify-center items-center ">
                        <span class="text-white material-symbols-outlined">meeting_room</span>
                        <p>Sign In</p>
                    </a>
                </div>
            <?php endif; ?>
            <button class="hamburger humbtn" onclick="handleHamburgerClick(this)">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </nav>
        <!-- Mobile Navbar Starts Here -->
        <nav class="mobile-navbar">
            <div class="transition mobile-nav-links-wrapper bg-white">

                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="text-normalize inline text-black transition nav-link">Home</a>
                <a href="<?php echo e(route('admin.all.events')); ?>"
                    class="text-normalize inline text-black transition nav-link">All Events</a>
                <?php if(Auth::check() && Auth::user()->role !== \App\Enums\Role::SUPERADMIN): ?>
                    <a href="<?php echo e(route('admin.followers')); ?>"
                        class="text-normalize inline text-black transition nav-link">All Followers</a>
                <?php endif; ?>
                <?php if(Auth::check() && Auth::user()->role == \App\Enums\Role::SUPERADMIN): ?>
                    <a href="<?php echo e(route('admin.all.users')); ?>"
                        class="text-normalize inline text-black transition nav-link">All Users</a>
                    <a href="<?php echo e(route('admin.email.index')); ?>"
                        class="text-normalize inline text-black transition nav-link">Emails</a>
                <?php endif; ?>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('admin.notifications')); ?>"
                        class="text-normalize inline text-black transition nav-link">
                        <div class="flex justify-between items-center">
                            <p>Notification</p>
                            <p class="text-black"><?php echo e(Auth::user()->unreadNotifications->count()); ?></p>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </nav>
        <!-- Mobile Navbar Ends Here -->
    </header>
    <!-- Navbar Section Ends Here -->
    <?php echo $__env->yieldContent('admin'); ?>
    <?php echo $__env->yieldPushContent('modals'); ?>
    

    <footer id="footer-section" style="margin-top: 0 !important;">
        <div class="footer-wrapper">
            <div class="footer-first-section">
                <div class="footer-contact-main-wrapper">
                    <div class="footer-contact-wrapper transition">
                        <p class="footer-contact-git transition">GET IN TOUCH</p>
                        <p class="footer-contact-caf transition"><?php echo e($data->site_name); ?></p>
                    </div>
                    <div class="footer-contact-wrapper transition">
                        <a href="tel:<?php echo e($data->phone); ?>" class="footer-contact-tel transition"><?php echo e($data->phone); ?></a>
                        <a href="mailto:<?php echo e($data->email); ?>" class="footer-contact-tel transition"><?php echo e($data->email); ?></a>
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
                        <a href="<?php echo e(route('privacy.policy')); ?>"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Privacy Policy</span></a>
                        <a href="https://caribbeanairforce.com/terms-and-conditions/" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Terms & Conditions (Online<br>&emsp; Ticket Sales)</span></a>
                        <a href="<?php echo e(route('faqs')); ?>"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">FAQs</span></a>
                    </div>
                    <div class="footer-nav-links-wrapper transition">
                        <a href="https://caribbeanairforce.com/services/" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Services</span></a>
                        <a href="<?php echo e(route('events.index')); ?>" class="footer-nav-link-items transition">⯈ <span
                                class="footer-nav-link-items-inner transition">Event</span></a>
                        <a href="<?php echo e(route('faqs.radio')); ?>" class="footer-nav-link-items transition">⯈ <span
                                class="footer-nav-link-items-inner transition">FAQs (Online Radio Station)</span></a>
                        <a href="https://caribbeanairforce.com/contact-us/" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Contact Us</span></a>
                        <a href="<?php echo e(route('terms.policy')); ?>" class="footer-nav-link-items transition">⯈
                            <span class="footer-nav-link-items-inner transition">Terms & Conditions (Third-Party<br>&emsp; Event Posting)</span></a>
                        <a href="<?php echo e(route('intellectual.policy')); ?>"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Intellectual Property Rights</span></a>
                    </div>
                </div>
            </div>

            <div class="footer-second-section">
                <div class="footer-logo-wrapper transition">
                    <img class="footer-logo transition" src="<?php echo e(asset('/' . $data->logo)); ?>" alt="site-logo"
                        title="Unifying Caribbean People Socially Mentally $ Economically" draggable="false">
                </div>
                <div class="footer-copyright transition">
                    <p class="footer-copyright-text transition">All rights reserved by <a href="javascript:void(0);" class="footer-copyright-text-a-tag"><?php echo e($data->site_name); ?></a>
                    </p>
                    <div class="footer-icons-wrapper transition">
                        <a href="<?php echo e($data->facebook); ?>" class="footer-icon transition"><i
                                class="fa-brands fa-facebook-f"></i></a>
                        <a href="<?php echo e($data->twitter); ?>" class="footer-icon transition"><i
                                class="fa-brands fa-twitter"></i></a>
                        <a href="<?php echo e($data->linkedin); ?>" class="footer-icon transition"><i
                                class="fa-brands fa-linkedin"></i></a>
                        <a href="<?php echo e($data->instagram); ?>" class="footer-icon transition"><i
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
    <script src="<?php echo e(asset('admins/js/general.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/js/general.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/scroll-to-top.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".event-datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            defaultDate: "today",
        });
    </script>

    
    <?php echo $__env->yieldContent('js'); ?>
    <?php echo $__env->yieldPushContent('js'); ?>
    <?php echo $__env->yieldPushContent('script'); ?>
    <?php echo $__env->make('sweetalert::alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>

</html>
<?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/layout/app.blade.php ENDPATH**/ ?>