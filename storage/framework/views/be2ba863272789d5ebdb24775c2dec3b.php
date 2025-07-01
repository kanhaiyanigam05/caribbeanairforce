<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $__env->yieldPushContent('title'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="<?php echo e(asset('/' . $data->favicon)); ?>" sizes="32x32" />
    <link rel="icon" href="<?php echo e(asset('/' . $data->favicon)); ?>" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?php echo e(asset('/' . $data->favicon)); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/base.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/tailwind/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/tailwind/tw.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/custom.css')); ?>">
    <?php echo $__env->yieldPushContent('css'); ?>
    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body onload="handleDropdownSelect(); handleDropdownClick(); handleInputSearch(); handleCustomNumberInput();">
    <header class="bg-black text-white">
        <nav class="max-w-[1200px] mx-auto transition">
            <div
                class="py-2 px-2 flex flex-col screen768:items-center screen768:justify-between gap-3 screen768:flex-row">
                <div class="flex justify-between items-center py-1 transition"
                    style="flex-wrap: wrap; align-items: center;">
                    <div class="px-6 screen768:px-2 border-r border-stonegray transition">
                        <a class="text-sm" href="tel:<?php echo e($data->phone); ?>"><?php echo e($data->phone); ?></a>
                    </div>
                    <div class="px-6 screen768:px-2 transition">
                        <a class="text-sm" href="mailto:<?php echo e($data->email); ?>"><?php echo e($data->email); ?></a>
                    </div>
                </div>
                <div class="flex justify-between items-center gap-2 py-1 transition">
                    <a href="https://caribbeanairforce.com/listen-now/"
                        class="mobile-nav-btn w-full no-underline text-white bg-primary font-bold uppercase rounded-full text-center px-7 py-[14px] screen768:py-[10px] screen768:px-[24px] text-xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-heart"></i>
                        <p class="text-nowrap">listen live</p>
                    </a>
                    <a href="https://pod.co/truth-seekers"
                        class="mobile-nav-btn w-full no-underline text-white bg-primary font-bold uppercase rounded-full text-center px-7 py-[14px] screen768:py-[10px] screen768:px-[24px] text-xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-podcast"></i>
                        <p class="text-nowrap">poadcast</p>
                    </a>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>"
                            class="mobile-nav-btn w-full no-underline text-white bg-primary font-bold uppercase rounded-full text-center px-7 py-[14px] screen768:py-[10px] screen768:px-[24px] text-xs flex items-center justify-center gap-2">
                            <i class="fa-solid fa-dashboard"></i>
                            <p class="text-nowrap">Dashboard</p>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('admin.login')); ?>"
                            class="mobile-nav-btn w-full no-underline text-white bg-primary font-bold uppercase rounded-full text-center px-7 py-[14px] screen768:py-[10px] screen768:px-[24px] text-xs flex items-center justify-center gap-2">
                            <i class="fa-solid fa-sign-in"></i>
                            <p class="text-nowrap">Login</p>
                        </a>
                    <?php endif; ?>
                </div>
                <a href="<?php echo e($data->youtube); ?>">
                    <div
                        class="transition flex gap-2 items-center justify-center text-[15px] font-semibold screen768:pr-2">
                        <i class="fa-brands fa-youtube text-[#FF0000]"></i>
                        <p>YouTube Channel</p>
                    </div>
                </a>
            </div>

            <div class="screen768:relative screen768:flex screen768:justify-center screen768:items-center">
                <div class="w-full flex justify-between items-center px-2">
                    <a href="<?php echo e($data->site_url); ?>">
                        <div class="max-w-40 screen768:w-36">
                            <img class="object-cover w-full" src="<?php echo e(asset('/' . $data->logo)); ?>" alt="site-logo"
                                title="Unifying Caribbean People Socially Mentally $ Economically" draggable="false">
                        </div>
                    </a>

                    <button class="screen768:hidden" onclick="handleHamburgerClickAction(this)">
                        <i class="fa-solid fa-bars p-1"></i>
                    </button>

                    <div class="flex justify-center items-center gap-5 screen768:mt-5">
                        <a href="<?php echo e($data->facebook); ?>" class="bg-gray rounded-full px-[13px] py-[10px]">
                            <i class="fa-brands fa-facebook text-white text-base"></i>
                        </a>
                        <a href="<?php echo e($data->twitter); ?>" class="bg-gray rounded-full px-[13px] py-[10px]">
                            <i class="fa-brands fa-twitter text-white text-base"></i>
                        </a>
                    </div>
                </div>

                <div class="hidden bg-white screen768:bg-transparent screen768:flex flex-col nav-shadow screen768:absolute screen768:flex-row screen768:mt-5"
                    id="nav-list-menu">
                    <a href="https://caribbeanairforce.com/"
                        class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] screen768:border-none screen768:text-white screen768:px-[10px] screen768:py-6">Home</a>
                    <a href="https://caribbeanairforce.com/artists/"
                        class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] screen768:border-none screen768:text-white screen768:px-[10px] screen768:py-6">Artists</a>
                    <a href="https://caribbeanairforce.com/radio-djs/"
                        class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] screen768:border-none screen768:text-white screen768:px-[10px] screen768:py-6">Radio
                        DJs</a>
                    <div class="group screen768:flex screen768:justify-center screen768:items-center transition font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] screen768:border-none screen768:text-white"
                        onclick="handleDetailsMenu(event, this)">
                        <div class="p-[15px] screen768:px-[10px] screen768:pb-5 screen768:py-6">
                            <div class="flex justify-start items-center gap-2 mycustomdroppdown cursor-pointer">
                                <a href="javascript:void(0);">
                                    <p>Services</p>
                                </a>
                                <i class="fa-solid fa-chevron-down text-xs py-3 pr-3 screen768:p-0"></i>
                            </div>
                        </div>
                        <div
                            class="services-details-d hidden screen768:group-hover:block bg-white nav-shadow screen768:absolute z-10 screen768:top-16 screen768:min-w-[300px] screen768:rounded-sm dropdown-details">
                            <div class="transition flex flex-col">
                                <a href="https://caribbeanairforce.com/services/radio/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap">Radio</a>
                                <a href="https://caribbeanairforce.com/services/music/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap">Music</a>
                                <a href="https://caribbeanairforce.com/services/news/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap">News</a>
                                <a href="https://caribbeanairforce.com/services/comedy/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap">Comedy</a>
                                <a href="https://caribbeanairforce.com/services/sport/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap">Sport</a>
                                <a href="https://caribbeanairforce.com/services/events-1/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap">Events</a>
                                <a href="https://caribbeanairforce.com/services/radio-djs/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap">Radio
                                    DJs</a>
                                <a href="https://caribbeanairforce.com/services/souvenirs/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap">Souvenirs</a>
                                <a href="https://caribbeanairforce.com/services/latest-video/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap">Latest Video</a>
                                <a href="https://caribbeanairforce.com/music-videos-festivals-events-2025/"
                                    class="transition p-[15px] font-medium capitalize text-black hover:text-primary text-nowrap">Music Videos Festivals Events 2025</a>
                            </div>
                        </div>
                    </div>
                    <div class="group screen768:flex screen768:justify-center screen768:items-center transition font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] screen768:border-none screen768:text-white"
                        onclick="handleDetailsMenu(event, this)">
                        <div class="p-[15px] screen768:px-[10px] screen768:pb-5 screen768:py-6">
                            <div class="flex justify-start items-center gap-2 mycustomdroppdown cursor-pointer">
                                <a href="<?php echo e(route('events.index')); ?>">
                                    <p>Events</p>
                                </a>
                                <i class="fa-solid fa-chevron-down text-xs py-3 pr-3 screen768:p-0"></i>
                            </div>
                        </div>
                        <div
                            class="event-d-details-d hidden screen768:group-hover:block bg-white nav-shadow screen768:absolute z-10 screen768:top-16 screen768:min-w-[300px] screen768:rounded-sm dropdown-details">
                            <div class="transition flex flex-col">
                                <?php $searchCities = \App\Models\City::all(); ?>
                                <?php $__currentLoopData = $searchCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('events.index', $city->name)); ?>"
                                        class="transition p-[15px] font-medium capitalize text-black hover:text-primary border-b border-[#c4c4c4] text-nowrap"><?php echo e($city->name); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <a href="https://caribbeanairforce.com/contact-us/"
                        class="transition p-[15px] font-medium capitalize text-black hover:text-primary screen768:text-white screen768:px-[10px] screen768:py-6">Contact
                        Us</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <?php echo $__env->yieldContent('main'); ?>
        <?php echo $__env->yieldPushContent('modals'); ?>
    </main>

    <footer class="w-full px-2 transition-all duration-500 bg-black py-[50px]">
        <div class="max-w-[1200px] mx-auto">
            <div
                class="border-b border-gray pb-4 screen768:flex screen768:items-start screen768:gap-8 lg:justify-between">
                <div class="flex justify-between items-start px-5 screen768:gap-8 screen1367:w-1/2">
                    <div class="flex flex-col gap-5 w-full">
                        <p class="text-[15px] text-white font-medium uppercase lg:text-lg screen1367:text-2xl">GET
                            IN TOUCH</p>
                        <p class="text-[15px] text-white font-normal capitalize lg:text-[17px] screen1367:text-xl">
                            <?php echo e($data->site_name); ?></p>
                    </div>
                    <div class="flex flex-col gap-4 w-full">
                        <a href="tel:<?php echo e($data->phone); ?>"
                            class="text-[15px] text-white font-medium lg:text-lg screen1367:text-[22px]"><?php echo e($data->phone); ?></a>
                        <a href="mailto:<?php echo e($data->email); ?>"
                            class="text-[15px] text-white font-medium lg:text-lg screen1367:text-[22px]"><?php echo e($data->email); ?></a>
                        <div>
                            <p class="text-[15px] text-white font-normal capitalize lg:text-[17px] screen1367:text-xl hover:text-primary">
                                Caribbean Air Force
                            <p>
                            <p class="text-[15px] text-white font-normal capitalize lg:text-[17px] screen1367:text-xl hover:text-primary">
                                (Atlanta Financial Center)
                            <p>
                        </div>

                        <div>
                            <p class="text-[15px] text-white font-normal capitalize lg:text-[17px] screen1367:text-xl hover:text-primary">
                                3343 Peachtree Rd NE Ste 145-1162 <br> Atlanta, GA 30326
                            <p>
                            <p class="text-[15px] text-white font-normal capitalize lg:text-[17px] screen1367:text-xl hover:text-primary">
                                United States
                            <p>
                        </div>
                        <i class="fa-e-icon-list-icon-size text-white"></i>
                    </div>
                </div>
                <div class="flex justify-between items-start px-5 mt-3 screen768:gap-8 lg:w-1/2">
                    <div class="flex flex-col gap-2 w-full">
                        <a href="https://caribbeanairforce.com/"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Home</span></a>
                        <a href="https://caribbeanairforce.com/artists/"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Artists</span></a>
                        <a href="https://caribbeanairforce.com/radio-djs/"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Radio DJs</span></a>
                        <a href="<?php echo e(route('privacy.policy')); ?>"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Privacy Policy</span></a>
                        <a href="<?php echo e(route('terms.policy')); ?>"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Terms & Conditions (Online<br>&emsp;Ticket Sales)</span></a>
                        <a href="<?php echo e(route('faqs')); ?>"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">FAQs</span></a>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <a href="https://caribbeanairforce.com/services/"
                            class="text-[15px] text-primary lg:text-base screen1367:text-lg font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Services</span></a>
                        <a href="<?php echo e(route('events.index')); ?>"
                            class="text-[15px] text-primary lg:text-base screen1367:text-lg font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Event</span></a>
                        <a href="<?php echo e(route('faqs.radio')); ?>"
                            class="text-[15px] text-primary lg:text-base screen1367:text-lg font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">FAQs (Online Radio Station)</span></a>
                        <a href="https://caribbeanairforce.com/contact-us/"
                            class="text-[15px] text-primary lg:text-base screen1367:text-lg font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Contact Us</span></a>
                        <a href="https://caribbeanairforce.com/terms-and-conditions/"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Terms & Conditions (Third-Party<br>&emsp; Event Posting)</span></a>
                        <a href="<?php echo e(route('intellectual.policy')); ?>"
                            class="text-[15px] lg:text-base screen1367:text-lg text-primary font-medium text-nowrap">&#11208;
                            <span class="text-white hover:text-primary">Intellectual Property Rights</span></a>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-start px-5 mt-8 lg:items-center">
                <div class="flex flex-col gap-5 w-full">
                    <img class="select-none w-full max-w-20 lg:max-w-[222px]" src="<?php echo e(asset('/' . $data->logo)); ?>"
                        title="Unifying Caribbean People Socially Mentally $ Economically" alt="site-logo" draggable="false">
                </div>
                <div class="flex flex-col gap-5 w-full lg:w-1/2 items-end">
                    <p
                        class="text-[13px] lg:text-base screen1367:text-lg text-white font-medium capitalize text-justify">
                        All rights reserved by <a href="###"
                            class="text-[13px] lg:text-base screen1367:text-lg text-white font-medium"><?php echo e($data->site_name); ?></a>
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="<?php echo e($data->facebook); ?>" target="_blank"
                            class="text-lg text-white font-medium hover:text-primary"><i
                                class="fa-brands fa-facebook-f"></i></a>
                        <a href="<?php echo e($data->twitter); ?>" target="_blank"
                            class="text-lg text-white font-medium hover:text-primary"><i
                                class="fa-brands fa-twitter"></i></a>
                        <a href="<?php echo e($data->linkedin); ?>" target="_blank"
                            class="text-lg text-white font-medium hover:text-primary"><i
                                class="fa-brands fa-linkedin"></i></a>
                        <a href="<?php echo e($data->instagram); ?>" target="_blank"
                            class="text-lg text-white font-medium hover:text-primary"><i
                                class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="px-5 mt-8">
                <button id="scrollTopBtn" class="bg-blue-600 px-3 py-1 rounded-sm fixed bottom-7 z-50">
                    <i class="fa-solid fa-chevron-up text-white text-[15px]"></i>
                </button>
            </div>

        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?php echo e(asset('asset/js/general.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/js/custom.js')); ?>"></script>
    <?php echo $__env->make('sweetalert::alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('js'); ?>
    <?php echo $__env->yieldPushContent('script'); ?>
    <script>
        function ajaxLoader(selector, text) {
            // Set the loading state manually before the AJAX call
            $(selector).html('<div class="ajax-loader"><i class="fa-solid fa-spinner fa-pulse"></i></div>');

            // After the AJAX call, restore the original text
            $(document).one('ajaxStop', function() {
                $(selector).html(text);
            });
        }
        setInterval(() => {
            fetch('/refresh-csrf').then(response => {
                // Optionally handle response
            });
        }, 600000);
    </script>
    

</body>

</html>
<?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/layout/front.blade.php ENDPATH**/ ?>