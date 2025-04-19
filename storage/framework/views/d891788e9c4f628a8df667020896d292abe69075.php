<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'promotion','method'=>'post'))); ?>

    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('employee_id', __('Employee'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('designation_id',__('Designation'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::select('designation_id',$designations,null,array('class'=>'form-control select2'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('promotion_title',__('Promotion Title'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('promotion_title',null,array('class'=>'form-control'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('promotion_date',__('Promotion Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('promotion_date',null,array('class'=>'form-control datepicker'))); ?>

        </div>
        <div class="form-group col-lg-12">
            <?php echo e(Form::label('description',__('Description'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home/splashho/public_html/hrmsys/resources/views/promotion/create.blade.php ENDPATH**/ ?>