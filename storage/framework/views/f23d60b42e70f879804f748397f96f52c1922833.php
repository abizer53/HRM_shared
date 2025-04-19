<div class="card bg-none card-box">
<?php echo e(Form::open(array('route' => array('test.send.mail')))); ?>

<div class="row">
    <div class="form-group col-md-12">
        <?php echo e(Form::label('email', __('Email'),['class'=>'form-control-label'])); ?>

        <?php echo e(Form::text('email', '', array('class' => 'form-control','required'=>'required'))); ?>

        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-email" role="alert">
            <strong class="text-danger"><?php echo e($message); ?></strong>
        </span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>
<div class="modal-footer">
    <input type="submit" value="<?php echo e(__('Send')); ?>" class="btn-create badge-blue">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
</div>
<?php echo e(Form::close()); ?>

</div>

<?php /**PATH /home/q5w20afri03w/public_html/hrm/resources/views/setting/test_mail.blade.php ENDPATH**/ ?>