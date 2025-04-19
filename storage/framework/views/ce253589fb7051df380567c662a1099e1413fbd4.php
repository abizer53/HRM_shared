<div class="card bg-none card-box">
    <?php echo e(Form::open(['url' => 'leavetype', 'method' => 'post'])); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('title', __('Leave Type'), ['class' => 'form-control-label'])); ?>

                <?php echo e(Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Leave Type Name')])); ?>

                <?php $__errorArgs = ['title'];
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
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('days', __('Days Per Year'), ['class' => 'form-control-label'])); ?>

                <?php echo e(Form::number('days', null, ['class' => 'form-control', 'placeholder' => __('Enter Days / Year')])); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="cat">Is this leave valid for 3 years?</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mb-0" type="radio" name="leave_valid" id="inlineRadio1"
                            value="option1">
                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline ">
                        <input class="form-check-input mb-0" checked type="radio" name="leave_valid" id="inlineRadio2"
                            value="option2">
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="cat">Minimum unit of time for requesting time off.</label>
                <select class="form-control form-control-sm" name="" id="">
                    <option value="">Whole day</option>
                    <option value="">Half day</option>
                    <option value="">Any</option>
                    <option value="">2 hours</option>
                    <option value="">1 hour</option>
                    <option value="">30 minutes</option>
                    <option value="">20 minutes</option>
                    <option value="">15 minutes</option>
                    <option value="">10 minutes</option>
                    <option value="">5 minutes</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="cat">How should values be rounded?</label>
                <select class="form-control form-control-sm" name="" id="">
                    <option value="">Option1</option>
                    <option value="">Option2</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 parent">
            <div class="form-group">
                <label for="cat">When is the start date of each time off year?</label>
                <select id="date_join" class="form-control form-control-sm" name="" id="">
                    <option value="">On the anniversary of the employee's starting date</option>
                    <option value="specific_date">On a specific date</option>
                </select>
            </div>
            <div id="date_join_show" style="display: none;" class="col-md-12">
                <div class="form-group">
                    <label for="cat">Enter specific date</label>
                    <input class="form-control" type="date">
                </div>
            </div>
        </div>
        
        <div class="col-md-12 parent_delay">
            <div class="form-group">
                <label for="cat">Delay the time off start date from the employee starting date?</label>
                <select id="delay_time" class="form-control form-control-sm" name="" id="">
                    <option disabled selected value="">-- Select --</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div id="delay_time_show" style="display: none;" class="col-md-12">
                <div class="form-group">
                    <label for="cat">Select Month</label>
                    <select class="form-control form-control-sm" name="" id="">
                        <option value="">1 Month</option>
                        <option value="">2 Months</option>
                        <option value="">3 Months</option>
                        <option value="">4 Months</option>
                        <option value="">5 Months</option>
                        <option value="">6 Months</option>
                        <option value="">7 Months</option>
                        <option value="">8 Months</option>
                        <option value="">9 Months</option>
                        <option value="">10 Months</option>
                        <option value="">11 Months</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>      

    <script>
        
    $(document).ready(function(){
        // join date
        $('#date_join').on('change', function(){
            var svalue = $(this).val(); 
            if(svalue == 'specific_date'){
                $("#date_join_show").show();
                $(".parent").addClass("border bg-gray-500 rounded");
            }else{
                $(".parent").removeClass("border bg-gray-500 rounded");
                $("#date_join_show").hide();
            }
        });
        // delay tile
        $('#delay_time').on('change', function(){
            var dvalue = $(this).val(); 
            if(dvalue == 'yes'){
                $("#delay_time_show").show();
                $(".parent_delay").addClass("border bg-gray-500 rounded");
            }else{
                $(".parent_delay").removeClass("border bg-gray-500 rounded");
                $("#delay_time_show").hide();
            }
        });
    });

    </script> 

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/abizer/hrmsys/resources/views/leavetype/create.blade.php ENDPATH**/ ?>