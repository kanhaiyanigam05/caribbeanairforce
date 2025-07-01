<div class="mb-08rem w-full transition relative">
    <label for="<?php echo e($id); ?>" class="mb-2px block transition"><?php echo e($label); ?></label>
    <input class="form-login-input text-white transition <?php echo e($classes); ?>" <?php if($type==='number' ): ?> type="text"
        oninput="allowIntegerOnly(this)" <?php else: ?> type="<?php echo e($type); ?>" <?php endif; ?> name="<?php echo e($name); ?>" id="<?php echo e($id); ?>"
        placeholder="<?php echo e($placeholder); ?>" value="<?php echo e($value); ?>" <?php echo e($attributes); ?> />
    <span class="text-primary <?php echo e($name); ?>" id="error_<?php echo e($name); ?>"></span>
</div>
<?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/components/input.blade.php ENDPATH**/ ?>