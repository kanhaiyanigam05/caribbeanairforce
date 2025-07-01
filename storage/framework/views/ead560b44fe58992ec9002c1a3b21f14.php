<?php $__env->startPush('title'); ?>
    <title><?php echo e($meta->meta_title); ?></title>
    <meta name="keywords" content="<?php echo e($meta->meta_keywords); ?>"/>
    <meta name="description" content="<?php echo e($meta->meta_description); ?>"/>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('admin'); ?>
    <?php echo $__env->make('layout.detail', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->yieldPushContent('detailCss'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/tailwind/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/tailwind/tw.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/base.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.0/purify.min.js"></script>
    <script src="<?php echo e(asset('asset/js/general.js')); ?>"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@geoapify/leaflet-geocoder/dist/leaflet-geocoder.min.js"></script>
    <?php echo $__env->yieldPushContent('detailJs'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/admin/events/show.blade.php ENDPATH**/ ?>