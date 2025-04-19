@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Leave') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 row">
            <div class="card bg-none card-box col-md-8">
                {{ Form::open(['url' => 'leave', 'method' => 'post']) }}
                @if (\Auth::user()->type != 'employee')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('employee_id', __('Employee')) }}
                                {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => __('Select Employee')]) }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('leave_type_id', __('Leave Type')) }}
                            <select name="leave_type_id" id="leave_type_id" class="form-control" style="height: 40px; font-size:12px;">
                                @foreach ($leavetypes as $leave)
                                    <option value="{{ $leave->id }}">{{ $leave->title }} (<p class="float-right pr-5">
                                            {{ $leave->days }}</p>)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {{ Form::label('leave_bases', __('Leave Basis On')) }} <br />
                        <div class="d-flex align-items-center">
                            <span class="d-flex align-items-center mx-2">
                                <input type="radio" name="leave_bases" value=single_days class="my-1 mx-2" id="single_days" checked>
                                <label for="single_days" class="my-1">Single day</label>
                            </span>

                            <span class="d-flex align-items-center mx-2">
                                <input type="radio" name="leave_bases" value=multiple_days class="my-1 mx-2" id="multiple_days">
                                <label for="multiple_days" class="my-1">Multiple Days</label>
                            </span>

                            <span class="d-flex align-items-center mx-2">
                                <input type="radio" name="leave_bases" value=hour_based class="my-1 mx-2" id="hour_based">
                                <label for="hour_based" class="my-1">Hour based</label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group single_date_div">
                            {{ Form::label('single_date', __('Date')) }}
                            {{ Form::text('single_date', null, ['class' => 'form-control datepicker']) }}
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group dates col-md-6">
                            {{ Form::label('start_date', __('Start Date')) }}
                            {{ Form::text('start_date', null, ['class' => 'form-control datepicker']) }}
                        </div>
                        <div class="form-group dates col-md-6">
                            {{ Form::label('end_date', __('End Date')) }}
                            {{ Form::text('end_date', null, ['class' => 'form-control datepicker']) }}
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group time-picker col-md-4">
                            {{ Form::label('start_time', __('Start Time')) }}
                            {{ Form::time('start_time', null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group time-picker col-md-4">
                            {{ Form::label('end_time', __('End Time')) }}
                            {{ Form::time('end_time', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('leave_reason', __('Leave Reason')) }}
                            {{ Form::textarea('leave_reason', null, ['class' => 'form-control', 'placeholder' => __('Leave Reason')]) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('remark', __('Remark')) }}
                            {{ Form::textarea('remark', null, ['class' => 'form-control', 'placeholder' => __('Leave Remark')]) }}
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" value="{{ __('Create') }}" class="btn-create badge-blue">
                        <a href="{{route('leave.index')}}" class="btn-sm btn-create bg-gray">{{ __('Cancel') }}</a>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="col-md-4 card">
                <div class="alert alert-warning">
                    Policy Description
                </div>
                <div id="policyDiv">
                    <p>You are entitled to <small id="entitlement_days" class="py-2"></small> days a year, plus additional day based on tenure.</p>
                    <span class="py-2">
                        <p>Time off is accrued at the <span id="when_entitlement_time_off_at"></span> of each month. 
                            <span id="can_take_entitlement_time_off"></span>
                            <span id="date_join"></span>
                        </p>
                    </span>
                    <p>
                        All unused allowance will carry over to the following time off year. <br>
                    </p>
                    <span>
                        <p>You must request longer periods of</p>
                        <p id="request_days" class="py-2"></p>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        let timepicker = $('.time-picker');
        let startDate = $('#start_date');
        let endDate = $('#end_date');
        timepicker.hide();
        $('.dates').hide();
        $('.single_date_div').show();
        let leaveBases = $("[name=leave_bases]");
        leaveBases.on('change', function () {
            if ($(this).val() == 'hour_based') {
                $('.dates').hide();
                $('.single_date_div').show();
                timepicker.show();
            } else {
                timepicker.hide();
            }

            if ($(this).val() == 'single_days') {
                $('.dates').hide();
                $('.single_date_div').show();
            }

            if ($(this).val() == 'multiple_days') {
                $('.dates').show();
                timepicker.hide();
                $('.single_date_div').hide();
            }            
        });

        function fetchpolicy(id) {
            $.get({
                url: "/fetch-leave-type/"+id,
                success: function (response) {
                    $("#policyDiv").show();
                    $('#entitlement_days').html(response[0].days);
                    $("#when_entitlement_time_off_at").html(response[0].when_entitlement_time_off_at);
                    if (response[0].can_take_entitlement_time_off == '1') {
                        if(response[0].borrowed_entitlement_time_off != 0){
                            $("#can_take_entitlement_time_off").html("You may borrow up to "+response[0].borrowed_entitlement_time_off+" days before they have been accrued.");
                        }
                    }

                    if (response[0].date_join == 'anniversary') {
                        $('#date_join').html('Your allowance renews on the anniversary of your employment.');
                    } else {
                        $('#date_join').html('Your allowance renews on '+ response[0].specific_date);
                    }

                    let data = '';
                    response[3].forEach(e => {
                        if(e.days != 0){
                            data += 'Booking of '+e.days+' Days or more must be requested at least '+e.requested_days.replace("+", " ")+' days in advance.<br>';
                        }
                    });
                    $("#request_days").html(data);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        let staticId = $('#leave_type_id').val();
        if (staticId) {
            fetchpolicy(staticId);
        }

        $("#policyDiv").hide();
        $('#leave_type_id').on('change', function (e) {
            let id = $(this).val();
            fetchpolicy(id);
        });
    </script>
@endsection
