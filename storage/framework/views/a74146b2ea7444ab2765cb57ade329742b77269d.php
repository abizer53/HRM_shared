<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'resignation','method'=>'post', 'enctype' => 'multipart/form-data'))); ?>

    <div class="row">
        <?php if(\Auth::user()->type!='employee'): ?>
            <div class="form-group col-lg-12">
                <?php echo e(Form::label('employee_id', __('Employee'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required'))); ?>

            </div>
        <?php endif; ?>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('notice_date',__('Notice Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('notice_date',null,array('class'=>'form-control datepicker'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('resignation_date',__('Resignation Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('resignation_date',null,array('class'=>'form-control datepicker'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('description',__('Description'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('file',__('Upload File'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::file('file',null,array('class'=>'form-control'))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home/q5w20afri03w/public_html/hrm/resources/views/resignation/create.blade.php ENDPATH**/ ?>