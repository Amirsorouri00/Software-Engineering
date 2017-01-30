<?php $__env->startSection('content'); ?>



    <div class="form-group">



        <a class="navbar-brand" href="<?php echo e(url('/enterround')); ?>">
            ورود به دور
        </a>


        <a class="navbar-brand" href="<?php echo e(url('/baskets')); ?>">
            بروزرسانی سبد
        </a> <a class="navbar-brand"  >
            خروج
        </a>


    </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>