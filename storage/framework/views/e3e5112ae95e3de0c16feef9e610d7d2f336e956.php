<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Employee')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <?php echo e(Form::model($employee, array('route' => array('employee.update', $employee->id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data'))); ?>

            <?php echo csrf_field(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-header"><h6 class="mb-0"><?php echo e(__('Personal Detail')); ?></h6></div>
                <div class="card-body employee-detail-edit-body">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <?php echo Form::label('name', __('Name'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                            <?php echo Form::text('name', null, ['class' => 'form-control','required' => 'required']); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('phone', __('Phone'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                            <?php echo Form::number('phone',null, ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo Form::label('dob', __('Date of Birth'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                                <?php echo Form::text('dob', null, ['class' => 'form-control datepicker']); ?>

                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-group ">
                                <?php echo Form::label('gender', __('Gender'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                                <div class="d-flex radio-check">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_male" value="Male" name="gender" class="custom-control-input" <?php echo e(($employee->gender == 'Male')?'checked':''); ?>>
                                        <label class="custom-control-label" for="g_male"><?php echo e(__('Male')); ?></label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_female" value="Female" name="gender" class="custom-control-input" <?php echo e(($employee->gender == 'Female')?'checked':''); ?>>
                                        <label class="custom-control-label" for="g_female"><?php echo e(__('Female')); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('address', __('Address'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                        <?php echo Form::textarea('address',null, ['class' => 'form-control','rows'=>2]); ?>

                    </div>
                    <?php if(\Auth::user()->type=='employee'): ?>
                        <?php echo Form::submit('Update', ['class' => 'btn-create btn-xs badge-blue radius-10px float-right']); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if(\Auth::user()->type!='employee'): ?>
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-header"><h6 class="mb-0"><?php echo e(__('Company Detail')); ?></h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            <?php echo csrf_field(); ?>
                            <div class="form-group col-md-12">
                                <?php echo Form::label('employee_id', __('Employee ID'),['class'=>'form-control-label']); ?>

                                <?php echo Form::text('employee_id',$employeesId, ['class' => 'form-control','disabled'=>'disabled']); ?>

                            </div>
                            <div class="form-group col-md-6">
                                <?php echo e(Form::label('branch_id', __('Branch'),['class'=>'form-control-label'])); ?>

                                <?php echo e(Form::select('branch_id', $branches,null, array('class' => 'form-control select2','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-6">
                                <?php echo e(Form::label('department_id', __('Department'),['class'=>'form-control-label'])); ?>

                                <?php echo e(Form::select('department_id', $departments,null, array('class' => 'form-control select2','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-6">
                                <?php echo e(Form::label('designation_id', __('Designation'),['class'=>'form-control-label'])); ?>

                                <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id" data-toggle="select2" data-placeholder="<?php echo e(__('Select Designation ...')); ?>">
                                    <option value=""><?php echo e(__('Select any Designation')); ?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <?php echo Form::label('company_doj', 'Company Date Of Joining',['class'=>'form-control-label']); ?>

                                <?php echo Form::text('company_doj', null, ['class' => 'form-control datepicker','required' => 'required']); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-6 ">
                <div class="employee-detail-wrap ">
                    <div class="card">
                        <div class="card-header"><h6 class="mb-0"><?php echo e(__('Company Detail')); ?></h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong><?php echo e(__('Branch')); ?></strong>
                                        <span><?php echo e(!empty($employee->branch)?$employee->branch->name:''); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong><?php echo e(__('Department')); ?></strong>
                                        <span><?php echo e(!empty($employee->department)?$employee->department->name:''); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong><?php echo e(__('Designation')); ?></strong>
                                        <span><?php echo e(!empty($employee->designation)?$employee->designation->name:''); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong><?php echo e(__('Date Of Joining')); ?></strong>
                                        <span><?php echo e(\Auth::user()->dateFormat($employee->company_doj)); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if(\Auth::user()->type!='employee'): ?>
        <div class="row">
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-header"><h6 class="mb-0"><?php echo e(__('Document')); ?></h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <?php
                            $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                        ?>

                        <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="float-left col-4">
                                        <label for="document" class="float-left pt-1 form-control-label"><?php echo e($document->name); ?> <?php if($document->is_required == 1): ?> <span class="text-danger">*</span> <?php endif; ?></label>
                                    </div>
                                    <div class="float-right col-8">
                                        <input type="hidden" name="emp_doc_id[<?php echo e($document->id); ?>]" id="" value="<?php echo e($document->id); ?>">
                                        <div class="choose-file form-group">
                                            <label for="document[<?php echo e($document->id); ?>]">
                                                <div><?php echo e(__('Choose File')); ?></div>
                                                <input class="form-control <?php if(!empty($employeedoc[$document->id])): ?> float-left <?php endif; ?> <?php $__errorArgs = ['document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> border-0" <?php if($document->is_required == 1 && empty($employeedoc[$document->id]) ): ?> required <?php endif; ?> name="document[<?php echo e($document->id); ?>]" type="file" id="document[<?php echo e($document->id); ?>]" data-filename="<?php echo e($document->id.'_filename'); ?>">
                                            </label>
                                            <p class="<?php echo e($document->id.'_filename'); ?>"></p>
                                        </div>

                                        <?php if(!empty($employeedoc[$document->id])): ?>
                                            <br> <span class="text-xs"><a href="<?php echo e((!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'')); ?>" target="_blank"><?php echo e((!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'')); ?></a>
                                                    </span>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h6 class="mb-0"><?php echo e(__('Bank Account Detail')); ?></h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                        <div class="form-group col-md-6">
                            <?php echo Form::label('account_holder_name', __('Account Holder Name'),['class'=>'form-control-label']); ?>

                            <?php echo Form::text('account_holder_name', null, ['class' => 'form-control']); ?>


                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('account_number', __('Account Number'),['class'=>'form-control-label']); ?>

                            <?php echo Form::number('account_number', null, ['class' => 'form-control']); ?>


                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('bank_name', __('Bank Name'),['class'=>'form-control-label']); ?>

                            <?php echo Form::text('bank_name', null, ['class' => 'form-control']); ?>


                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('bank_identifier_code', __('Bank Identifier Code'),['class'=>'form-control-label']); ?>

                            <?php echo Form::text('bank_identifier_code',null, ['class' => 'form-control']); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('branch_location', __('Branch Location'),['class'=>'form-control-label']); ?>

                            <?php echo Form::text('branch_location',null, ['class' => 'form-control']); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('tax_payer_id', __('Tax Payer Id'),['class'=>'form-control-label']); ?>

                            <?php echo Form::text('tax_payer_id',null, ['class' => 'form-control']); ?>

                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header"><h6 class="mb-0"><?php echo e(__('Document Detail')); ?></h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                <?php
                                    $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                                ?>
                                <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-12">
                                        <div class="info">
                                            <strong><?php echo e($document->name); ?></strong>
                                            <span><a href="<?php echo e((!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'')); ?>" target="_blank"><?php echo e((!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'')); ?></a></span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header"><h6 class="mb-0"><?php echo e(__('Bank Account Detail')); ?></h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong><?php echo e(__('Account Holder Name')); ?></strong>
                                        <span><?php echo e($employee->account_holder_name); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong><?php echo e(__('Account Number')); ?></strong>
                                        <span><?php echo e($employee->account_number); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong><?php echo e(__('Bank Name')); ?></strong>
                                        <span><?php echo e($employee->bank_name); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong><?php echo e(__('Bank Identifier Code')); ?></strong>
                                        <span><?php echo e($employee->bank_identifier_code); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong><?php echo e(__('Branch Location')); ?></strong>
                                        <span><?php echo e($employee->branch_location); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong><?php echo e(__('Tax Payer Id')); ?></strong>
                                        <span><?php echo e($employee->tax_payer_id); ?></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(\Auth::user()->type != 'employee'): ?>
        <div class="row">
            <div class="col-12">
                <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create btn-xs badge-blue radius-10px float-right">
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12">
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript">

        function getDesignation(did) {
            $.ajax({
                url: '<?php echo e(route('employee.json')); ?>',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">Select any Designation</option>');
                    $.each(data, function (key, value) {
                        var select = '';
                        if (key == '<?php echo e($employee->designation_id); ?>') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
                    });
                }
            });
        }

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            var designation_id = '<?php echo e($employee->designation_id); ?>';
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/q5w20afri03w/public_html/hrm/resources/views/employee/edit.blade.php ENDPATH**/ ?>