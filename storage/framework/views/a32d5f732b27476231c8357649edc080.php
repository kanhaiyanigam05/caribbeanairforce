

<form method="post" id="signup-store-cover">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="user_id" value="<?php if(auth()->guard()->check()): ?><?php echo e(Auth::user()->id); ?> <?php endif; ?>">
    <div id="display-cover-modal" class="modal-wrapper">
        <div class="base-modal-wrapper">
            <div class="base-modal-wrapper-2">
                <div class="dp-modal-inner-wrapper">
                    <div class="base-head-dp-modal justify-end">
                        <button type="button" class="modal-close-btn"
                            onclick="handleHideProfileCoverPhotoChangeModal()">
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
                        <div class="flex justify-start base-cover-image-modal-wrapper">
                            <div class="cover-profile-page-wrapper">
                                <img class="select-none cover-image-profile-page" src="<?php echo e(Auth::user()->banner); ?>"
                                    alt="Profile Display" id="cover-image" draggable="false" />
                            </div>
                            <div class="cover-image-avtar-base-wrapper cover-image-avtar-base-wrapper-50">
                                <div class="cover-image-avtar-wrapper" onclick="handleCoverAvatarSelect(this)">
                                    <img class="cover-image-avtar-image" src="<?php echo e(asset('admins/images/cover-2.jpg')); ?>"
                                        alt="Avatar 1" draggable="false" />
                                </div>
                                <div class="cover-image-avtar-wrapper cover-image-avtar-base-wrapper-50"
                                    onclick="handleCoverAvatarSelect(this)">
                                    <img class="cover-image-avtar-image" src="<?php echo e(asset('admins/images/cover-3.jpg')); ?>"
                                        alt="Avatar 1" draggable="false" />
                                </div>
                                <button type="button"
                                    class="cover-image-avtar-wrapper cover-image-avtar-base-wrapper-100 cover-image-avtar-upload-btn"
                                    onclick="handleCoverPictureChange()">
                                    <img class="select-none" src="<?php echo e(asset('admins/images/plus.svg')); ?>" alt=""
                                        draggable="false" />
                                </button>
                            </div>
                            <div>
                                <input type="file" id="cover-input-image" class="hidden" />
                                <div class="dp-profile-image-heading-wrapper">
                                    <button type="button" class="cover-image-crop-btn hidden">Crop Image</button>
                                    <button type="submit" class="cover-image-submit-btn hidden"
                                        id="cover-submit-btn">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/models/user-cover.blade.php ENDPATH**/ ?>