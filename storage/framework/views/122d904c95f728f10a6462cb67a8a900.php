<?php if($paginator->hasPages()): ?>
    <div class="paginator-wrapper">
        
        <?php if($paginator->onFirstPage()): ?>
            <span class="paginator-btn disabled"><i class="fa-solid fa-chevron-right"></i>
                <p>Previous</p>
            </span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="paginator-btn">
                <i class="fa-solid fa-chevron-right"></i>
                <p>Previous</p>
            </a>
        <?php endif; ?>

        
        <?php $__currentLoopData = $paginator->links()->elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(is_string($element)): ?>
                <a href="javascript:void(0);" class="paginator-btn">.</a>
            <?php endif; ?>

            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <a href="javascript:void(0);" class="paginator-btn active-paginator-btn"><?php echo e($page); ?></a>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" class="paginator-btn"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="paginator-btn">
                <p>Next</p> <i class="fa-solid fa-chevron-right"></i>
            </a>
        <?php else: ?>
            <span class="paginator-btn disabled">
                <p>Next</p> <i class="fa-solid fa-chevron-right"></i>
            </span>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/vendor/pagination/custom.blade.php ENDPATH**/ ?>