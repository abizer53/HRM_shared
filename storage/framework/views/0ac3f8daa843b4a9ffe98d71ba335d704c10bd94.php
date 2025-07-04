<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Bulk Attendance')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $('#present_all').click(function (event) {
            if (this.checked) {
                $('.present').each(function () {
                    this.checked = true;
                });

                $('.present_check_in').removeClass('d-none');
                $('.present_check_in').addClass('d-block');

            } else {
                $('.present').each(function () {
                    this.checked = false;
                });
                $('.present_check_in').removeClass('d-block');
                $('.present_check_in').addClass('d-none');

            }
        });

        $('.present').click(function (event) {
            var div = $(this).parent().parent().parent().parent().find('.present_check_in');
            if (this.checked) {
                div.removeClass('d-none');
                div.addClass('d-block');

            } else {
                div.removeClass('d-block');
                div.addClass('d-none');
            }

        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <?php echo e(Form::open(array('route' => array('attendanceemployee.bulkattendance'),'method'=>'get','id'=>'bulkattendance_filter'))); ?>

                    <div class="row d-flex justify-content-end py-0">

                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="all-select-box">
                                <div class="btn-box">
                                    <?php echo e(Form::label('date',__('Date'),['class'=>'text-type'])); ?>

                                    <?php echo e(Form::text('date',isset($_GET['date'])?$_GET['date']:date('Y-m-d'),array('class'=>'month-btn form-control datepicker'))); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <div class="all-select-box">
                                <div class="btn-box">
                                    <?php echo e(Form::label('branch', __('Branch'),['class'=>'text-type'])); ?>

                                    <?php echo e(Form::select('branch', $branch,isset($_GET['branch'])?$_GET['branch']:'', array('class' => 'form-control select2','required'))); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <div class="all-select-box">
                                <div class="btn-box">
                                    <?php echo e(Form::label('department', __('Department'),['class'=>'text-type'])); ?>

                                    <?php echo e(Form::select('department', $department,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control select2','required'))); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-auto mt-auto mb-3">
                            <a href="#" class="apply-btn" onclick="document.getElementById('bulkattendance_filter').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('Apply')); ?>">
                                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                            </a>
                            <a href="<?php echo e(route('timesheet.index')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
                            </a>

                        </div>

                    </div>
                    <?php echo e(Form::close()); ?>


                    <?php echo e(Form::open(array('route'=>array('attendanceemployee.bulkattendance'),'method'=>'post'))); ?>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th width="10%"><?php echo e(__('Employee Id')); ?></th>
                                <th><?php echo e(__('Employee')); ?></th>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Department')); ?></th>
                                <th>
                                    <div class="form-group my-auto">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="present_all" id="present_all" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                            <label class="custom-control-label" for="present_all"> <?php echo e(__('Attendance')); ?></label>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $attendance=$employee->present_status($employee->id,isset($_GET['date'])?$_GET['date']:date('Y-m-d'));
                                ?>
                                <tr>
                                    <td class="Id">
                                        <input type="hidden" value="<?php echo e($employee->id); ?>" name="employee_id[]">
                                        <a href="<?php echo e(route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>" class=""><?php echo e(\Auth::user()->employeeIdFormat($employee->employee_id)); ?></a>
                                    </td>
                                    <td><?php echo e($employee->name); ?></td>
                                    <td><?php echo e(!empty($employee->branch)?$employee->branch->name:''); ?></td>
                                    <td><?php echo e(!empty($employee->department)?$employee->department->name:''); ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input present" type="checkbox" name="present-<?php echo e($employee->id); ?>" id="present<?php echo e($employee->id); ?>" <?php echo e((!empty($attendance)&&$attendance->status == 'Present') ? 'checked' : ''); ?>>
                                                        <label class="custom-control-label" for="present<?php echo e($employee->id); ?>"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 present_check_in <?php echo e(empty($attendance) ? 'd-none' : ''); ?> ">
                                                <div class="row">
                                                    <label class="col-md-2 control-label"><?php echo e(__('In')); ?></label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control timepicker" name="in-<?php echo e($employee->id); ?>" value="<?php echo e(!empty($attendance) && $attendance->clock_in!='00:00:00' ? $attendance->clock_in : \Utility::getValByName('company_start_time')); ?>">
                                                    </div>

                                                    <label for="inputValue" class="col-md-2 control-label"><?php echo e(__('Out')); ?></label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control timepicker" name="out-<?php echo e($employee->id); ?>" value="<?php echo e(!empty($attendance) &&  $attendance->clock_out !='00:00:00'? $attendance->clock_out : \Utility::getValByName('company_end_time')); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="attendance-btn text-right pt-4">
                        <input type="hidden" value="<?php echo e(isset($_GET['date'])?$_GET['date']:date('Y-m-d')); ?>" name="date">
                        <input type="hidden" value="<?php echo e(isset($_GET['branch'])?$_GET['branch']:''); ?>" name="branch">
                        <input type="hidden" value="<?php echo e(isset($_GET['department'])?$_GET['department']:''); ?>" name="department">
                        <?php echo e(Form::submit(__('Update'),array('class'=>'btn-create badge-blue'))); ?>

                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).ready(function () {
            $('.daterangepicker').daterangepicker({
                format: 'yyyy-mm-dd',
                locale: {format: 'YYYY-MM-DD'},
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splashho/public_html/hrmsys/resources/views/attendance/bulk.blade.php ENDPATH**/ ?>