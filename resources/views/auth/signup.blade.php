@extends('layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admins/css/swiper-v11/swiper.css') }}"/>
    <link rel="stylesheet" href="{{ asset('admins/css/post-reset.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <link rel="stylesheet" href="{{ asset('admins/css/hamburger.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css"/>
@endsection
@section('admin')
    <!-- Navbar Section Ends Here -->
    <main class="full-width bg-black flex justify-center items-center py-3 transition signup-main-wrapper">
        <div class="relative flex justify-center items-center transition ">
            <div class="absolute left-side-shape transition">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#BD191F"
                          d="M40.7,-54.3C55.1,-45.5,70.9,-36.8,77.2,-23.6C83.6,-10.4,80.6,7.4,73,21.5C65.3,35.6,53.2,46,40.2,56.5C27.3,67,13.7,77.6,-1.9,80.2C-17.4,82.8,-34.8,77.3,-46,66.3C-57.3,55.2,-62.3,38.5,-67.8,21.9C-73.3,5.3,-79.2,-11.2,-77.3,-27.6C-75.4,-44.1,-65.6,-60.4,-51.4,-69.2C-37.2,-78.1,-18.6,-79.4,-2.7,-75.6C13.1,-71.8,26.3,-63,40.7,-54.3Z"
                          transform="translate(100 100)"/>
                </svg>
            </div>
            <div id="login-wrapper" class="transition sign-up-parent-wrapper-main">

                <!-- Sign-Up Main Menu Starts Here -->
                <div id="sign-up-main" class="base-signup-main-wrapper show-signup-wrapper">
                    <div class="login-head text-center w-full transition">
                        <a href="{{ route('admin.dashboard') }}">
                            <img class="select-none w-full max-w-100px mx-auto"
                                 src="https://caribbeanairforce.com/wp-content/uploads/2024/01/logo-25.png"
                                 alt="site-logo"
                                 draggable="false">
                        </a>
                        <h1 class="text-white text-center text-3xl font-bold transition">Sign-up</h1>
                    </div>
                    <div class="w-full transition">
                        <div class="mb-08rem w-full transition">
                            <button id="join-as-an-event-manager-btn" class="form-login-btn text-black transition"
                                    type="submit" onclick="switchEventManagerSignup()">Join as an Event Manager
                            </button>
                        </div>
                        <div class="mb-08rem w-full transition">
                            <button id="join-as-an-attendee-btn" class="form-login-btn text-black transition"
                                    type="submit"
                                    onclick="switchAttendeeSignup()">Join as an Attendee
                            </button>
                        </div>
                        <div class="w-full transition text-center mx-auto">
                            <p>Already have an account? <a href="{{ route('admin.login') }}"
                                                           class="forget-password-link">login?</a></p>
                        </div>
                    </div>
                </div>
                <!-- Sign-Up Main Menu Ends Here -->

                <!-- Join as an Attendee Starts Here -->
                <div id="sign-up-attendee" class="base-signup-main-wrapper hide-signup-wrapper hidden">
                    <div class="login-head text-center w-full transition">
                        <a href="{{ route('admin.dashboard') }}">
                            <img class="select-none w-full max-w-100px mx-auto"
                                 src="https://caribbeanairforce.com/wp-content/uploads/2024/01/logo-25.png"
                                 alt="site-logo"
                                 draggable="false">
                        </a>
                        <h1 class="text-white text-center text-3xl font-bold transition">Join as an Attendee</h1>
                    </div>

                    <div class="w-full transition">
                        <form class="admin-store-user w-full transition" method="post">
                            @csrf
                            <input type="hidden" name="user" value="{{ \App\Enums\Role::USER }}">
                            <x-input label="First Name" type="text" name="fname" id="fname" value="{{ old('fname') }}"
                                     placeholder="First Name" :iserror="$errors->has('fname')"
                                     :message="$errors->first('fname')"/>
                            <x-input label="Last Name" type="text" name="lname" id="lname" value="{{ old('lname') }}"
                                     placeholder="Last Name" :iserror="$errors->has('lname')"
                                     :message="$errors->first('lname')"/>
                            <x-input label="Username" type="text" name="username" id="username"
                                     value="{{ old('username') }}"
                                     placeholder="Username" :iserror="$errors->has('username')"
                                     :message="$errors->first('username')"/>
                            <x-input label="Email" type="email" name="email" id="email" value="{{ old('email') }}"
                                     placeholder="Email" :iserror="$errors->has('email')"
                                     :message="$errors->first('email')"/>
                            <div class="mb-08rem w-full transition">
                                <label for="password" class="mb-2px block transition">Password</label>
                                <div class="relative login-password-input-visibility-wrapper block">
                                    <input class="form-login-input text-white transition" type="password" name="password"
                                           id="password" placeholder="**********">
                                    <span class="text-primary password" id="error_password"></span>
                                    <button type="button" class="absolute" onclick="handlePasswordVisibility()">
                                        <span class="material-symbols-outlined" id="password-toggle"> visibility_off </span>
                                    </button>
                                </div>
                            </div>
                            <x-input label="Confirm Password" type="password" name="password_confirmation"
                                     id="password_confirmation" placeholder="**********"
                                     :iserror="$errors->has('password_confirmation')"
                                     :message="$errors->first('password_confirmation')"/>
                                     
                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                            <span class="text-primary recaptcha g-recaptcha-response" id="error_g-recaptcha-response"></span>
                            <div class="mb-08rem w-full transition">
                                <button class="form-login-btn text-black transition admin-store-user-btn" type="submit">Sign-up
                                </button>
                            </div>
                            <div class="w-full transition text-center mx-auto">
                                <p>Already have an account? <a href="{{ route('admin.login') }}"
                                                               class="forget-password-link">login?</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Join as an Attendee Ends Here -->

                <!-- Join as an Event Manager Starts Here -->
                <div id="sign-up-event-manager"
                     class="base-signup-main-wrapper hide-signup-wrapper block hide-signup-wrapper hidden">
                    <div class="login-head text-center w-full transition">
                        <a href="{{ route('admin.dashboard') }}">
                            <img class="select-none w-full max-w-100px mx-auto"
                                 src="https://caribbeanairforce.com/wp-content/uploads/2024/01/logo-25.png"
                                 alt="site-logo" draggable="false">
                        </a>
                        <h1 class="text-white text-center text-3xl font-bold transition">Join as an Event Manager</h1>
                    </div>

                    <form class="admin-store-user w-full transition" method="post">
                        @csrf
                        <input type="hidden" name="user" value="{{ \App\Enums\Role::ORGANIZER }}">
                        <x-input label="First Name" type="text" name="fname" id="fname" value="{{ old('fname') }}"
                                 placeholder="First Name" :iserror="$errors->has('fname')"
                                 :message="$errors->first('fname')"/>
                        <x-input label="Last Name" type="text" name="lname" id="lname" value="{{ old('lname') }}"
                                 placeholder="Last Name" :iserror="$errors->has('lname')"
                                 :message="$errors->first('lname')"/>
                        <x-input label="Username" type="text" name="username" id="username"
                                 value="{{ old('username') }}"
                                 placeholder="Username" :iserror="$errors->has('username')"
                                 :message="$errors->first('username')"/>
                        <x-input label="Email" type="email" name="email" id="email" value="{{ old('email') }}"
                                 placeholder="Email" :iserror="$errors->has('email')"
                                 :message="$errors->first('email')"/>
                        <div class="mb-08rem w-full transition">
                            <label for="password" class="mb-2px block transition">Password</label>
                            <div class="relative login-password-input-visibility-wrapper block">
                                <input class="form-login-input text-white transition" type="password" name="password"
                                       id="password" placeholder="**********">
                                <span class="text-primary password" id="error_password"></span>
                                <button type="button" class="absolute" onclick="handlePasswordVisibility()">
                                    <span class="material-symbols-outlined" id="password-toggle"> visibility_off </span>
                                </button>
                            </div>
                        </div>
                        <x-input label="Confirm Password" type="password" name="password_confirmation"
                                 id="password_confirmation" placeholder="**********"
                                 :iserror="$errors->has('password_confirmation')"
                                 :message="$errors->first('password_confirmation')"/>
                                 
                        <!-- reCAPTCHA Widget -->
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        <span class="text-primary recaptcha g-recaptcha-response" id="error_g-recaptcha-response"></span>
                        <div class="mb-08rem w-full transition">
                            <button class="form-login-btn text-black transition admin-store-user-btn" type="submit">Sign-up
                            </button>
                        </div>
                        <div class="w-full transition text-center mx-auto">
                            <p>Already have an account? <a href="{{ route('admin.login') }}"
                                                           class="forget-password-link">login?</a></p>
                        </div>
                    </form>
                </div>
                <!-- Join as an Event Manager Ends Here -->
            </div>
            <div class="absolute right-side-shape transition">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#F1C21B"
                          d="M40.1,-48.7C53.6,-45.4,67.3,-35.9,67,-24.7C66.6,-13.4,52.3,-0.5,46.8,14.8C41.3,30.2,44.7,48.2,38.3,53.6C32,59.1,16,52.1,0.4,51.5C-15.1,50.9,-30.3,56.7,-44.3,53.7C-58.4,50.8,-71.4,39.1,-75.9,24.7C-80.5,10.4,-76.8,-6.7,-71.5,-23.4C-66.3,-40.1,-59.6,-56.4,-47.4,-60.2C-35.3,-63.9,-17.6,-55,-2.2,-52C13.3,-49,26.6,-52,40.1,-48.7Z"
                          transform="translate(100 100)"/>
                </svg>
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script src="{{ asset('admins/js/swiper-v11/swiper.js') }}"></script>
    <script src="{{ asset('admins/js/swiper-v11/swiper-settings.js') }}"></script>
    <script src="{{ asset('admins/js/tinymce-v7.3.0/tinymce.min.js') }}"></script>
    <script src="{{ asset('admins/js/tinymce-v7.3.0/settings.js') }}"></script>
    <script src="{{ asset('admins/js/drag.js') }}"></script>
    <script src="{{ asset('admins/js/tab-switch.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="{{ asset('admins/js/swiper-v11/event-form.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.0/purify.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        $(document).ready(function () {
            $('.admin-store-user').on('submit', function (e) {
                e.preventDefault();
                const form = this;
                ajaxLoader($(form).find('.admin-store-user-btn'), 'Sign Up');
                $('.text-primary').text(''); // Clear previous errors
            
                const formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.signup.store.user') }}",
                    data: formData,
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                title: "Success!",
                                text: data.message,
                                icon: "success"
                            });
                            $(form).trigger('reset');
                            window.location.href = "{{ route('admin.login') }}";
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: data.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (field, error) {
                                let $field = $('#' + field);
                                $(form).find('.' + field).text(error[0]);
                                // $field.next('.text-primary').text(error[0]);
                                // $('#text_' + field).text(error[0]);
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: xhr.responseJSON.message,
                                icon: "error"
                            });
                        }
                    }
                });
            });

        })
    </script>
@endsection
