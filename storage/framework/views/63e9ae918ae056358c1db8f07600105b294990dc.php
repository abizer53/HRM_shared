

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Working Days')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('working-day.update')); ?>" method="POST">
        <?php echo method_field('post'); ?>
        <?php echo csrf_field(); ?>
        <div class="px-3">
            <table class="table">
                <tr>
                    <td>#</td>
                    <th><?php echo e(__('Day')); ?></th>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="monday" <?php if($workingDay->monday): ?> checked <?php endif; ?>>
                    </td>
                    <td><?php echo e(__('Monday')); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tuesday" <?php if($workingDay->tuesday): ?> checked <?php endif; ?>>
                    </td>
                    <td><?php echo e(__('Tuesday')); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="wednesday" <?php if($workingDay->wednesday): ?> checked <?php endif; ?>>
                    </td>
                    <td><?php echo e(__('Wednesday')); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="thursday" <?php if($workingDay->thursday): ?> checked <?php endif; ?>>
                    </td>
                    <td><?php echo e(__('Thursday')); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="friday" <?php if($workingDay->friday): ?> checked <?php endif; ?>>
                    </td>
                    <td><?php echo e(__('Friday')); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="saturday" <?php if($workingDay->saturday): ?> checked <?php endif; ?>>
                    </td>
                    <td><?php echo e(__('Saturday')); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="sunday" <?php if($workingDay->sunday): ?> checked <?php endif; ?>>
                    </td>
                    <td><?php echo e(__('Sunday')); ?></td>
                </tr>
            </table>
        </div>
        <input type="submit" value="Save" class="btn btn-primary">
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/q5w20afri03w/public_html/hrm/resources/views/working_days/index.blade.php ENDPATH**/ ?>