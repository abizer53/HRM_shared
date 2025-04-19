<div class="card bg-none card-box">
    <?php echo e(Form::model($department,array('route' => array('department.update', $department->id), 'method' => 'PUT'))); ?>

    <div class="row ">
        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('branch_id',__('Branch'))); ?>

                <?php echo e(Form::select('branch_id',$branch,null,array('class'=>'form-control select2 ','placeholder'=>__('select Branch')))); ?>

            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('name',__('Name'))); ?>

                <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Department Name')))); ?>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home/splashho/public_html/hrmsys/resources/views/department/edit.blade.php ENDPATH**/ ?>