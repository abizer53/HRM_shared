

<?php $__env->startSection('title', trans('installer_messages.updater.welcome.title')); ?>
<?php $__env->startSection('container'); ?>
    <p class="paragraph text-center">
    	<?php echo e(trans('installer_messages.updater.welcome.message')); ?>

    </p>
    <div class="buttons">
        <a href="<?php echo e(route('LaravelUpdater::overview')); ?>" class="button"><?php echo e(trans('installer_messages.next')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.installer.layouts.master-update', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/q5w20afri03w/public_html/hrm/resources/views/vendor/installer/update/welcome.blade.php ENDPATH**/ ?>