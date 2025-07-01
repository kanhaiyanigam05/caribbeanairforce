{{-- handleProfileUpdate() --}}

<!-- Update User Profile Form -->
<div id="profile-modal" class="modal-wrapper">
    <div class="base-modal-wrapper">
        <div class="base-modal-wrapper-2">
            <div class="dp-modal-inner-wrapper">
                <div class="base-head-dp-modal justify-end">
                    <button type="button" class="modal-close-btn" onclick="handleHideProfileModal()">
                        <svg width="28" height="29" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="close-btn-icon">
                            <path d="M20.5998 20.6233L14.0001 14.0237M14.0001 14.0237L7.40044 7.42402M14.0001 14.0237L20.5998 7.42402M14.0001 14.0237L7.40044 20.6233" stroke="#bd191f"
                                stroke-width="1.5" stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>
                <div class="base-modal-inner-content-wrapper">
                    <div class="dp-profile-image-heading-wrapper flex justify-between items-center">
                        <button class="modal-heading tab-item-personal-item personal-info-title">Personal Info</button>
                        <button class="tab-item-personal-item password-reset-title" onclick="handleTabMenu(this)">Reset Password?</button>
                    </div>
                    <form action="" method="post" id="personal-info-form" class="profile-info-wrapper show-signup-wrapper">
                        @csrf
                        <div>
                            <x-input classes="text-white transition dark-ibn-disabled" disabled label="Email" type="email" name="email" id="email" value="{{ Auth::user()->email }}"
                                placeholder="Email" :iserror="$errors->has('email')" :message="$errors->first('email')" />
                            <x-input classes="text-white transition dark-ibn-disabled" disabled label="Username" type="text" name="username" id="username" value="{{ Auth::user()->username }}"
                                placeholder="Username" :iserror="$errors->has('username')" :message="$errors->first('username')" />

                            {{-- <div class="mb-08rem w-full transition">
                                <label for="country" class="mb-2px block transition">Country</label>
                                <select name="country" id="country" class="transition dark-ibn venue-country-signup">
                                    @if (Auth::user()->country === null)
                                        <option value="">Select a country</option>
                                    @else
                                        <option value="{{ Auth::user()->country }}">{{ Auth::user()->country }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="mb-08rem w-full transition">
                                <label for="state" class="mb-2px block transition">State</label>
                                <select name="state" id="state" class="transition dark-ibn venue-state-signup">
                                    @if (Auth::user()->state === null)
                                        <option value="">Select a state</option>
                                    @else
                                        <option value="{{ Auth::user()->state }}">{{ Auth::user()->state }}</option>
                                    @endif
                                </select>
                            </div>
                            <x-input classes="text-white transition dark-ibn" label="Zip Code" type="number" name="zipcode" id="zipcode" value="{{ Auth::user()->zipcode }}"
                                placeholder="Zip Code" :iserror="$errors->has('zipcode')" :message="$errors->first('zipcode')" /> --}}
                            <x-input classes="text-white transition dark-ibn" label="Address" type="text" name="address" id="address" value="{{ Auth::user()->address }}"
                                placeholder="Address" :iserror="$errors->has('address')" :message="$errors->first('address')" />
                            <input type="hidden" name="city" id="city" value="{{ Auth::user()->city }}" />

                            <div class="mb-08rem w-full transition">
                                <button id="personal-submit-btn" class="form-login-btn text-black transition dark-ibn-btn" type="submit">Update</button>
                            </div>
                        </div>
                    </form>

                    <form action="" method="post" id="password-reset-form" class="profile-rest-pass-wrapper hide-signup-wrapper hidden">
                        @csrf
                        <div>
                            <div class="mb-08rem w-full transition">
                                <label for="current_password" class="mb-2px block transition">Current Password</label>
                                <input class="form-login-input text-white transition dark-ibn" type="password" name="current_password" id="current_password" placeholder="**********" />
                                <span class="text-primary"></span>
                            </div>

                            <div class="mb-08rem w-full transition">
                                <label for="password" class="mb-2px block transition">New Password</label>
                                <div class="relative login-password-input-visibility-wrapper block">
                                    <input class="form-login-input text-white transition dark-ibn" type="password" name="password" id="password" placeholder="**********" />
                                    <span class="text-primary"></span>
                                    <button type="button" class="absolute" onclick="handlePasswordVisibility()">
                                        <span class="material-symbols-outlined color-black" id="password-toggle">
                                            visibility_off
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-08rem w-full transition">
                                <label for="password_confirmation" class="mb-2px block transition">Repeat Password</label>
                                <input class="form-login-input text-white transition dark-ibn" type="password" name="password_confirmation" id="password_confirmation" placeholder="**********" />
                                <span class="text-primary"></span>
                            </div>

                            <div class="mb-08rem w-full transition">
                                <button id="reset-password-submit-btn" class="form-login-btn text-black transition dark-ibn-btn" type="submit">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
