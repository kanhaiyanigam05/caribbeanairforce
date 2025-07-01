<?php $__env->startSection('events'); ?>
    <?php if(Auth::user()->role === \App\Enums\Role::SUPERADMIN): ?>
        <section class="events-section-inner px-15px profile-body-content-wrapper bottom-edge-shadow ">
            <h1 class="all-events-heading">All Events</h1>
            <div class="all-events-heading-wrapper">
                <div class="profile-tab-menu-wrapper" style="flex: 0 0 0">
                    <div class="relative">
                        <a href="<?php echo e(route('admin.all.events')); ?>" class="active-tab">
                            <p>All Events</p>
                        </a>
                    </div>
                    <div class="relative">
                        <a href="<?php echo e(route('admin.pending.events')); ?>" class="">
                            <p>Pending Events</p>
                        </a>
                    </div>
                    <div class="relative">
                        <a href="<?php echo e(route('admin.accepted.events')); ?>" class="">
                            <p>Accpeted Events</p>
                        </a>
                    </div>
                    <div class="relative">
                        <a href="<?php echo e(route('admin.rejected.events')); ?>" class="">
                            <p>Rejected Events</p>
                        </a>
                    </div>
                </div>
                <form action="<?php echo e(route('admin.search')); ?>" method="post" class="search-wrapoper-form">
                    <?php echo csrf_field(); ?>
                    <div class="search-wrapoper">
                        <div class="relative">
                            <input class="search-input" type="text" name="search" placeholder="Search Event?"
                                   oninput="handleSearchDropdown(this)">
                            <button class="search-icon-button" type="submit">
                                <img class="search-icon" src="<?php echo e(asset('admins/images/search.svg')); ?>" alt="search">
                            </button>
                            <div class="search-dropdown-main-wrapper">
                                <div class="search-items-inner-wrapper">
                                    <div class="search-no-results hidden">
                                        <p>No Events Found</p>
                                    </div>
                                    <div class="search-results hidden">
                                        <div class="search-dropdown-wrapper">
                                            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="javascript:void(0);"><?php echo e($event->name); ?></a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <?php if($events->isNotEmpty()): ?>
            <section class="events-section-inner px-15px profile-body-content-wrapper item-row pb-50px">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $attributes; } ?>
<?php $component = App\View\Components\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['event' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event),'admin' => true,'isSuperAdmin' => true,'editable' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64)): ?>
<?php $attributes = $__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64; ?>
<?php unset($__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64)): ?>
<?php $component = $__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64; ?>
<?php unset($__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </section>
        <?php else: ?>
            <section>
                <div class="flex justify-center items-center">
                    <img src="<?php echo e(asset('asset/images/no-event-found.png')); ?>" alt="">
                </div>
            </section>
        <?php endif; ?>
        <?php echo e($events->links('vendor.pagination.custom')); ?>

        <?php echo $__env->make('models.events', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <section class="events-section-inner px-15px profile-body-content-wrapper">
            <div class="all-events-heading-wrapper">
                <h1 class="all-events-heading">All Events</h1>
                <form action="<?php echo e(route('admin.search')); ?>" method="post" class="search-wrapoper-form">
                    <?php echo csrf_field(); ?>
                    <div class="search-wrapoper">
                        <div class="relative">
                            <input class="search-input" type="text" name="search" placeholder="Search Event?"
                                   oninput="handleSearchDropdown(this)">
                            <button class="search-icon-button" type="submit">
                                <img class="search-icon" src="<?php echo e(asset('admins/images/search.svg')); ?>" alt="search">
                            </button>
                            <div class="search-dropdown-main-wrapper">
                                <div class="search-items-inner-wrapper">
                                    <div class="search-no-results hidden">
                                        <p>No Events Found</p>
                                    </div>
                                    <div class="search-results hidden">
                                        <div class="search-dropdown-wrapper">
                                            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="javascript:void(0);"><?php echo e($event->name); ?></a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <?php if($events->isNotEmpty()): ?>
            <section class="events-section-inner px-15px profile-body-content-wrapper item-row pb-50px">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if (isset($component)) { $__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $attributes; } ?>
<?php $component = App\View\Components\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['event' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event),'admin' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64)): ?>
<?php $attributes = $__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64; ?>
<?php unset($__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64)): ?>
<?php $component = $__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64; ?>
<?php unset($__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </section>
        <?php else: ?>
            <section>
                <div class="flex justify-center items-center">
                    <img src="<?php echo e(asset('asset/images/no-event-found.png')); ?>" alt="">
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.events', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/admin/all-events.blade.php ENDPATH**/ ?>