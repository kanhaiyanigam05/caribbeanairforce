

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
                        <?php echo csrf_field(); ?>
                        <div>
                            <?php if (isset($component)) { $__componentOriginal786b6632e4e03cdf0a10e8880993f28a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal786b6632e4e03cdf0a10e8880993f28a = $attributes; } ?>
<?php $component = App\View\Components\Input::resolve(['classes' => 'text-white transition dark-ibn-disabled','label' => 'Email','type' => 'email','name' => 'email','id' => 'email','value' => ''.e(Auth::user()->email).'','placeholder' => 'Email'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'iserror' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->has('email')),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('email'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal786b6632e4e03cdf0a10e8880993f28a)): ?>
<?php $attributes = $__attributesOriginal786b6632e4e03cdf0a10e8880993f28a; ?>
<?php unset($__attributesOriginal786b6632e4e03cdf0a10e8880993f28a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal786b6632e4e03cdf0a10e8880993f28a)): ?>
<?php $component = $__componentOriginal786b6632e4e03cdf0a10e8880993f28a; ?>
<?php unset($__componentOriginal786b6632e4e03cdf0a10e8880993f28a); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal786b6632e4e03cdf0a10e8880993f28a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal786b6632e4e03cdf0a10e8880993f28a = $attributes; } ?>
<?php $component = App\View\Components\Input::resolve(['classes' => 'text-white transition dark-ibn-disabled','label' => 'Username','type' => 'text','name' => 'username','id' => 'username','value' => ''.e(Auth::user()->username).'','placeholder' => 'Username'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'iserror' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->has('username')),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('username'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal786b6632e4e03cdf0a10e8880993f28a)): ?>
<?php $attributes = $__attributesOriginal786b6632e4e03cdf0a10e8880993f28a; ?>
<?php unset($__attributesOriginal786b6632e4e03cdf0a10e8880993f28a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal786b6632e4e03cdf0a10e8880993f28a)): ?>
<?php $component = $__componentOriginal786b6632e4e03cdf0a10e8880993f28a; ?>
<?php unset($__componentOriginal786b6632e4e03cdf0a10e8880993f28a); ?>
<?php endif; ?>

                            
                            <?php if (isset($component)) { $__componentOriginal786b6632e4e03cdf0a10e8880993f28a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal786b6632e4e03cdf0a10e8880993f28a = $attributes; } ?>
<?php $component = App\View\Components\Input::resolve(['classes' => 'text-white transition dark-ibn','label' => 'Address','type' => 'text','name' => 'address','id' => 'address','value' => ''.e(Auth::user()->address).'','placeholder' => 'Address'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['iserror' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->has('address')),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('address'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal786b6632e4e03cdf0a10e8880993f28a)): ?>
<?php $attributes = $__attributesOriginal786b6632e4e03cdf0a10e8880993f28a; ?>
<?php unset($__attributesOriginal786b6632e4e03cdf0a10e8880993f28a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal786b6632e4e03cdf0a10e8880993f28a)): ?>
<?php $component = $__componentOriginal786b6632e4e03cdf0a10e8880993f28a; ?>
<?php unset($__componentOriginal786b6632e4e03cdf0a10e8880993f28a); ?>
<?php endif; ?>
                            <input type="hidden" name="city" id="city" value="<?php echo e(Auth::user()->city); ?>" />

                            <div class="mb-08rem w-full transition">
                                <button id="personal-submit-btn" class="form-login-btn text-black transition dark-ibn-btn" type="submit">Update</button>
                            </div>
                        </div>
                    </form>

                    <form action="" method="post" id="password-reset-form" class="profile-rest-pass-wrapper hide-signup-wrapper hidden">
                        <?php echo csrf_field(); ?>
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
<?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/models/user-settings.blade.php ENDPATH**/ ?>