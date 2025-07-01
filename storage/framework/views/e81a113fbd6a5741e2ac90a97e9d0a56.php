

<form method="post" id="signup-store-profile">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="user_id" value="<?php if(auth()->guard()->check()): ?><?php echo e(Auth::user()->id); ?> <?php endif; ?>">
    <div id="display-picture-modal" class="modal-wrapper">
        <div class="base-modal-wrapper">
            <div class="base-modal-wrapper-2">
                <div class="dp-modal-inner-wrapper">
                    <div class="base-head-dp-modal justify-end">
                        <button type="button" class="modal-close-btn" onclick="handleHideProfileDpChangeModal()">
                            <svg width="28" height="29" viewBox="0 0 28 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="close-btn-icon">
                                <path
                                    d="M20.5998 20.6233L14.0001 14.0237M14.0001 14.0237L7.40044 7.42402M14.0001 14.0237L20.5998 7.42402M14.0001 14.0237L7.40044 20.6233"
                                    stroke="#bd191f" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="base-modal-inner-content-wrapper">
                        <!-- <div class="dp-profile-image-heading-wrapper"><h3 class="modal-heading">Choose profile picture</h3></div> -->
                        <div class="flex justify-start base-profile-dp-modal-wrapper">
                            <div class="display-image-profile-page-wrapper">
                                <img class="select-none object-cover display-image-profile-image"
                                    src="<?php echo e(Auth::user()->profile); ?>" alt="Profile Display" draggable="false"
                                    id="profile-image" />
                            </div>
                            <div>
                                <div class="dp-profile-image-heading-wrapper">
                                    <h3 class="modal-heading">Choose profile picture</h3>
                                </div>
                                <div class="profile-image-avatar-wrapper">
                                    <div class="profile-display-image-wrapper" onclick="handleAvatarImageSelect(this)">
                                        <img class="profile-dp-avtar-image"
                                            src="<?php echo e(asset('admins/images/profile/1.svg')); ?>" alt="Avatar 1"
                                            draggable="false" />
                                    </div>
                                    <div class="profile-display-image-wrapper" onclick="handleAvatarImageSelect(this)">
                                        <img class="profile-dp-avtar-image"
                                            src="<?php echo e(asset('admins/images/profile/2.svg')); ?>" alt="Avatar 2"
                                            draggable="false" />
                                    </div>
                                    <div class="profile-display-image-wrapper" onclick="handleAvatarImageSelect(this)">
                                        <img class="profile-dp-avtar-image"
                                            src="<?php echo e(asset('admins/images/profile/3.svg')); ?>" alt="Avatar 3"
                                            draggable="false" />
                                    </div>
                                    <div class="profile-display-image-wrapper" onclick="handleAvatarImageSelect(this)">
                                        <img class="profile-dp-avtar-image"
                                            src="<?php echo e(asset('admins/images/profile/4.svg')); ?>" alt="Avatar 4"
                                            draggable="false" />
                                    </div>
                                    <div class="profile-display-image-wrapper" onclick="handleAvatarImageSelect(this)">
                                        <img class="profile-dp-avtar-image"
                                            src="<?php echo e(asset('admins/images/profile/5.svg')); ?>" alt="Avatar 5"
                                            draggable="false" />
                                    </div>
                                    <div class="profile-display-image-wrapper" onclick="handleAvatarImageSelect(this)">
                                        <img class="profile-dp-avtar-image"
                                            src="<?php echo e(asset('admins/images/profile/6.svg')); ?>" alt="Avatar 6"
                                            draggable="false" />
                                    </div>
                                    <button type="button"
                                        class="profile-display-image-wrapper profile-page-upload-dp-image-btn"
                                        onclick="handleProfileDpChange()">
                                        <img class="select-none" src="<?php echo e(asset('admins/images/plus.svg')); ?>" alt=""
                                            draggable="false" />
                                    </button>
                                </div>
                                <input type="file" id="profile-dp-input-image" class="hidden" />
                                <div class="dp-profile-image-heading-wrapper">
                                    <button type="button" class="profile-dp-crop-btn hidden">Crop Image</button>
                                    <button type="submit" class="profile-dp-submit-btn hidden"
                                        id="profile-submit-btn">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/models/user-profile.blade.php ENDPATH**/ ?>