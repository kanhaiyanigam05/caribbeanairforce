<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/swiper-v11/swiper.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/post-reset.css')); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/hamburger.css')); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin'); ?>
    <main>
        <!-- Banner Section Starts Here -->
        <section class="relative full-width max-h-400px">
            <div class="h-250px flex justify-end items-center">
                <img class="w-full select-none object-cover h-250px" id="cover-image-display"
                    src="<?php echo e(Auth::user()->banner); ?>" alt="banner" draggable="false" />
                <button class="transition absolute cover-image-upload-button-mobile"
                    onclick="handleProfilePageCoverPhotoChange()">
                    <i class="fa-solid fa-camera"></i>
                </button>
            </div>
            <div class="events-section-inner flex justify-between items-end gap-1 main-profile-details-wrapper">
                <div class="relative rounded-full user-profile-img-wrapper">
                    <button class="absolute transition profile-image-upload-button" onclick="handleProfilePageDPChange()">
                        <i class="fa-solid fa-camera"></i>
                    </button>
                    <div class="relative rounded-full profile-display-image">
                        <img class="absolute select-none rounded-full w-full h-full object-cover" id="profile-image-display"
                            src="<?php echo e(Auth::user()->profile); ?>" alt="" draggable="false" />
                    </div>
                </div>
                <div class="w-full flex justify-start items-start flex-column gap-2-3-rem translate-Y-35px">
                    <button class="transition cover-image-upload-button cover-image-upload-button-lg"
                        onclick="handleProfilePageCoverPhotoChange()">
                        <i class="fa-solid fa-camera"></i>
                        <p>Edit Cover Photo</p>
                    </button>
                    <div class="w-full flex justify-between items-center details-wrapper-main">
                        <div class="details-wrapper">
                            <div class="flex justify-start items-center gap-1">
                                <h5 class="user-name"><?php echo e(Auth::user()->full_name); ?></h5>
                                <h5 class="user-name-2"><?php echo e(Auth::user()->username); ?></h5>
                            </div>
                            <p class="designation">
                                <?php if(Auth::user()->role === \App\Enums\Role::SUPERADMIN): ?>
                                    Super Admin
                                <?php elseif(Auth::user()->role === \App\Enums\Role::ORGANIZER): ?>
                                    Event Organizer
                                <?php else: ?>
                                    User
                                <?php endif; ?>
                            </p>
                            <div class="mb-03rem flex justify-start items-center gap-05 profile-connections-wrapper">
                                <p class="connections"><?php echo e(Auth::user()->followers->count()); ?> <span>follower
                                        <?php echo e(Auth::user()->followers->count() > 1 ? 's' : ''); ?></span>
                                </p>
                                <div class="flex justify-start items-center">
                                    <?php $__currentLoopData = Auth::user()?->followers?->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $follower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <img class="select-none object-cover rounded-full thub-connections-img"
                                            src="<?php echo e($follower->profile); ?>" alt="<?php echo e($follower->full_name); ?>" draggable="false" />
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="profile-connect-button-wrapper">
                            <button class="profile-settings-button" onclick="handleProfileUpdate()"><span
                                    class="material-symbols-outlined">settings</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Banner Section Ends Here -->
        <!-- Main Section Starts Here -->
        <section class="events-section-inner profile-tab-menu-main">
            <div class="bottom-edge-shadow flex items-center gap-3rem nav-2-post-event">
                <?php if(Auth::user()->role !== \App\Enums\Role::SUPERADMIN): ?>
                    <div class="profile-tab-menu-wrapper" style="flex: 0 0 0">
                        <div class="relative" onclick="handleDropdown(this)">
                            <a href="javascript:void(0);" class="active-tab">
                                <p>Events</p>
                                <i class="fa-solid fa-chevron-down"></i>
                            </a>
                            <div class="absolute dropdown-wrapper">
                                <div class="dropdown">
                                    <a href="<?php echo e(route('admin.events.upcoming')); ?>">Upcoming Events</a>
                                    <a href="<?php echo e(route('admin.events.past')); ?>">Past Events</a>
                                    <a href="<?php echo e(route('admin.events.index')); ?>">All Events</a>
                                </div>
                            </div>
                        </div>
                        <div class="relative" onclick="handleDropdown(this)">
                            <a href="javascript:void(0);" class="">
                                <p>Followers</p>
                                <i class="fa-solid fa-chevron-down"></i>
                            </a>
                            <div class="absolute dropdown-wrapper">
                                <div class="dropdown">
                                    <a href="<?php echo e(route('admin.suggestions')); ?>">Suggestions</a>
                                    <a href="<?php echo e(route('admin.following')); ?>">Following</a>
                                    <a href="<?php echo e(route('admin.followers')); ?>">All Followers</a>
                                </div>
                            </div>
                        </div>
                        <button class="profile-settings-button on-sm" onclick="handleProfileUpdate()"><span
                                class="material-symbols-outlined">settings</span></button>
                    </div>
                <?php endif; ?>
                <?php if(Auth::user()->role !== \App\Enums\Role::USER || Auth::user()->block == true): ?>
                    <div class="profile-tab-menu-wrapper" style="flex: 1">
                        <div class="flex justify-start items-center gap-1 w-full">
                            <img class="select-none object-cover rounded-full basic-connection-image"
                                src="<?php echo e(Auth::user()->profile); ?>" alt="Profile Image" draggable="false" />
                            <button class="post-an-event-base-btn"
                                onclick="handleEventFormNextSlide(2); handleCreateEventModalShow()">
                                Post A New Event?
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php echo $__env->yieldContent('profile'); ?>
    </main>
    <?php echo $__env->make('models.user-profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('models.user-cover', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('models.user-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('models.events', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('admins/js/swiper-v11/swiper.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/swiper-v11/swiper-settings.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/tinymce-v7.3.0/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/tinymce-v7.3.0/settings.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/drag.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/tab-switch.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="<?php echo e(asset('admins/js/custom-calendar/calendar.js')); ?>"></script>
    <script src="<?php echo e(asset('admins/js/swiper-v11/event-form.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.0/purify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#signup-store-profile').on('submit', function(e) {
                e.preventDefault();
                ajaxLoader('#profile-submit-btn', 'Upload');
                const form = this;
                $('.text-primary').text('');
                const formData = new FormData(this);
                formData.append("profile", $('#profile-image').attr('src'));
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('admin.signup.store.profile')); ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            Swal.fire({
                                title: "Success!",
                                text: data.message,
                                icon: "success"
                            });
                            $(form).trigger('reset');
                            $('#profile-image-display').attr('src', data.profile);
                            handleHideProfileDpChangeModal();
                        }
                    },
                    error: function(xhr, status, error) {
                        $(form).trigger('reset');
                        console.log(xhr);
                        if (xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, error) {
                                let $field = $('#' + field);
                                $field.next('.text-primary').text(error[0]);
                                // $('#text_' + field).text(error[0]);
                            });
                        }
                    }
                });
            });
        })
        $(document).ready(function() {
            $('#signup-store-cover').on('submit', function(e) {
                e.preventDefault();
                ajaxLoader('#cover-submit-btn', 'Upload');
                const form = this;
                $('.text-primary').text('');
                const formData = new FormData(this);
                formData.append("cover", $('#cover-image').attr('src'));
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('admin.signup.store.cover')); ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            Swal.fire({
                                title: "Success!",
                                text: data.message,
                                icon: "success"
                            });
                            $(form).trigger('reset');
                            $('#cover-image-display').attr('src', data.cover);
                            handleHideProfileCoverPhotoChangeModal();
                        }
                    },
                    error: function(xhr, status, error) {
                        $(form).trigger('reset');
                        console.log(xhr);
                        if (xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, error) {
                                let $field = $('#' + field);
                                $field.next('.text-primary').text(error[0]);
                                // $('#text_' + field).text(error[0]);
                            });
                        }
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#personal-info-form').on('submit', function(e) {
                e.preventDefault();
                ajaxLoader('#personal-submit-btn', 'Update');
                const form = this;
                $('.text-primary').text('');
                const formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('admin.signup.store.setting')); ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log(data);
                        $(form).trigger('reset');
                        handleHideProfileModal();
                        if (data.success) {
                            Swal.fire({
                                title: "Success!",
                                text: data.message,
                                icon: "success"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $(form).trigger('reset');
                        console.log(xhr);
                        if (xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, error) {
                                let $field = $('#' + field);
                                $field.next('.text-primary').text(error[0]);
                                // $('#text_' + field).text(error[0]);
                            });
                        }
                    }
                })
            })
        });

        $(document).ready(function() {
            $('#password-reset-form').on('submit', function(e) {
                e.preventDefault();
                ajaxLoader('#reset-password-submit-btn', 'Update');
                const form = this;
                $('.text-primary').text('');
                const formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('admin.signup.store.password')); ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log(data);
                        $(form).trigger('reset');
                        handleHideProfileModal();
                        if (data.success) {
                            Swal.fire({
                                title: "Success!",
                                text: data.message,
                                icon: "success"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        if (xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, error) {
                                let $field = $('#' + field);
                                $field.next('.text-primary').text(error[0]);
                            });
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
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
                            let city = suggestion.properties.city || suggestion.properties.state || '';
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
            $('#address').after('<div class="list" id="address-suggestions"><ul></ul></div>');
            $('#address').before(
                '<div id="preloader" class="preloader" style="display: none;"><img src = "https://taxigo.thepreview.pro/front/images/icons/loader.gif" alt = "Loading..." ></div>');
            setupInputHandlers($('#address'), $('#city'), $('#address-suggestions ul'), $('#event-preloader'));

            $('#event-address').before(
                '<div id="preloader" class="preloader" style="display: none;"><img src = "https://taxigo.thepreview.pro/front/images/icons/loader.gif" alt = "Loading..." ></div>');
            $('#event-address').before('<div class="list" id="event-address-suggestions"><ul></ul></div>');
            setupInputHandlers($('#event-address'), $('#event-city'), $('#event-address-suggestions ul'), $('#event-preloader'));


            $('#purchase-location').before(
                '<div id="preloader" class="preloader" style="display: none;"><img src = "https://taxigo.thepreview.pro/front/images/icons/loader.gif" alt = "Loading..." ></div>');
            $('#purchase-location').before('<div class="list" id="purchase-location-suggestions"><ul></ul></div>');
            setupInputHandlers($('#purchase-location'), $('#purchase-city'), $('#purchase-location-suggestions ul'), $('#event-preloader'));

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/layout/profile.blade.php ENDPATH**/ ?>