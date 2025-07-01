<?php $__env->startPush('title'); ?>
    <title><?php echo e($meta->meta_title); ?></title>
    <meta name="keywords" content="<?php echo e($meta->meta_keywords); ?>"/>
    <meta name="description" content="<?php echo e($meta->meta_description); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('main'); ?>
    <?php echo $__env->make('layout.detail', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&amp;icon_names=share">
    <?php echo $__env->yieldPushContent('detailCss'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>
    <?php echo $__env->yieldPushContent('detailJs'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/event-detail.blade.php ENDPATH**/ ?>