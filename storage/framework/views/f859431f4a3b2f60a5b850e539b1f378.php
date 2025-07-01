<?php $__env->startSection('css'); ?>
    <script src="<?php echo e(asset('admins/css/custom-calendar/calendar.css')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/swiper-v11/swiper.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/post-reset.css')); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?php echo e(asset('admins/css/hamburger.css')); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin'); ?>
    <?php echo $__env->yieldContent('events'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/layout/events.blade.php ENDPATH**/ ?>