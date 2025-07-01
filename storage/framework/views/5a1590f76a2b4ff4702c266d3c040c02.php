<?php $__env->startSection('profile'); ?>
    <?php if(Auth::user()->role == \App\Enums\Role::SUPERADMIN): ?>
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
            <?php echo e($events->links('vendor.pagination.custom')); ?>

        <?php else: ?>
            <section>
                <div class="flex justify-center items-center">
                    <img src="<?php echo e(asset('asset/images/no-event-found.png')); ?>" alt="">
                </div>
            </section>
        <?php endif; ?>
    <?php else: ?>
        <!-- Suggestion Section Starts Here -->
        <section class="events-section-inner suggestions-wrapper">
            <div class="suggestions-inner-wrapper">

                <div class="suggestions-heading-wrapper">
                    <h2 class="suggestions-heading">People you may know</h2>
                    <a href="<?php echo e(route('admin.suggestions')); ?>" class="see-all-suggestions">See all</a>
                </div>

                <div class="swiper user-suggestions-swiper">
                    <div class="swiper-wrapper">

                        <?php $__currentLoopData = $suggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide" id="connection-card-<?php echo e($suggestion->id); ?>">
                                <div class="swiper-slide suggestions-user-card-wrapper">
                                    <div class="suggestions-user-card-image-wrapper">
                                        <img class="suggestions-user-card-image" src="<?php echo e($suggestion->profile); ?>"
                                             alt="connection"
                                             draggable="false">
                                    </div>
                                    <div class="w-full suggestions-user-card-info-wrapper">
                                        <p class="basic-connection-name"><?php echo e($suggestion->full_name); ?></p>
                                        <button type="button"
                                                class="suggestions-connect-a-tag connection-request-<?php echo e($suggestion->id); ?>"
                                                onclick="handleFollow(event, <?php echo e($suggestion->id); ?>)">
                                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                            Follow
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Suggestion Section Ends Here -->

        <?php if(Auth::user()->role === \App\Enums\Role::ORGANIZER): ?>
            <section class="events-section-inner px-15px profile-body-content-wrapper">
                <h1 class="all-events-heading">Your Organized Events</h1>
            </section>
            <?php if($events->isNotEmpty()): ?>
                <section class="events-section-inner px-15px item-row pb-50px">
                    <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(Auth::id() === $event->organizer->id): ?>
                            <?php if (isset($component)) { $__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $attributes; } ?>
<?php $component = App\View\Components\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['event' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event),'admin' => true,'editable' => true]); ?>
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
                        <?php else: ?>
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
        <section class="events-section-inner px-15px profile-body-content-wrapper">
            <h1 class="all-events-heading">Popular Events</h1>
        </section>
        <?php if($popularEvents->isNotEmpty()): ?>
            <section class="events-section-inner px-15px item-row pb-50px">
                <?php $__currentLoopData = $popularEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
        <?php echo e($popularEvents->links('vendor.pagination.custom')); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        function handleFollow(e, id) {
            e.preventDefault();
            ajaxLoader('.connection-request-' + id, '<i class="fa-solid fa-arrow-right-from-bracket"></i> Follow');

            $.ajax({
                type: "POST",
                url: `<?php echo e(route('admin.follow', ':id')); ?>`.replace(':id', id),
                data: {
                    _token: "<?php echo e(csrf_token()); ?>"
                },
                success: function (response) {
                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });

                        // Remove the suggestion card from the DOM
                        $('#connection-card-' + id).remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>