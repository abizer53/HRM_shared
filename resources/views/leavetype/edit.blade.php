@extends('layouts.admin')

@section('page-title')
    {{ __('Edit Leave Type') }}
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.css" rel="stylesheet" />
    <style>
        .main-row {
            margin-top: 20px;
        }
        
        h6 {
            color: #011c4b !important;
            font-family: 'Montserrat-SemiBold' !important;
            font-weight: 800 !important;
            font-size: 16px !important;
        }

        p {
            border-color: #a3afbb !important;
            font-size: 12px !important;
            color: #a3afbb !important;
            font-family: 'Montserrat-SemiBold' !important;
            margin-bottom: 0px !important;
        }
        p strong {
            border-color: #a3afbb !important;
            font-size: 13px !important;
            color: #000 !important;
            font-weight: 900;
            font-family: 'Montserrat-SemiBold' !important;
            margin-bottom: 0px !important;
        }

        label {
            color: #011c4b !important;
            font-family: 'Montserrat-SemiBold' !important;
            font-weight: normal !important;
            font-size: 12px !important;
        }

        legend {
            color: #011c4b !important;
            font-family: 'Montserrat-SemiBold' !important;
            font-weight: normal !important;
            font-size: 16px !important;
        }

        .form-control .form-control-sm,
        input[type='text'],input[type='email'],input[type='password'],input[type='color'],
        select {
            border-color: #a3afbb !important;
            border-radius: 10px !important;
            height: 40px !important;
            line-height: 40px !important;
            font-size: 12px !important;
            color: #a3afbb !important;
            font-family: 'Montserrat-SemiBold' !important;
            margin-bottom: 15px !important;
        }

        /* Style the form */
        #regForm {
            background-color: #ffffff;
            /* margin: 100px auto; */
            /* padding: 40px; */
            width: 100%;
            /* min-width: 300px; */
        }

        /* Style the input fields */
        input[type='text'],input[type='email'],input[type='password'],input[type='color'] {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid, select.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        /* Mark the active step: */
        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }

        .card-body {
            margin-bottom: 0 !important;
        }
        /* .invalid{
            border-color: red !important;
        } */
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-md-12" id="formTabs">
                           
                                <div class="tab">
                                    <div class="card " style="width:100%">
                                        <div class="card-header align-items-center d-flex justify-content-between"
                                            style="padding: 5px 15px;">
                                            <legend class="mb-0"> Leave defination</legend>
                                            <button class="btn rounded" type="button" data-toggle="collapse"
                                                data-target="#collapseExample1" aria-expanded="false"
                                                aria-controls="collapseExample" id="collapse1">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>

                                        <div class="card-body collapse show" id="collapseExample1">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="cat"> {{ __('Measure time off in days or hours?') }}
                                                    </label>
                                                    <select class="form-control form-control-sm" name=""
                                                        id="measure">
                                                        <option value="Days" {{ $leavetype->measure == 'Days' ? 'selected' : '' }}>Days</option>
                                                        <option value="Hours" {{ $leavetype->measure == 'Hours' ? 'selected' : '' }}>Hours</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {{ Form::label('title', __('Leave Type'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('title', $leavetype->title, ['class' => 'form-control ', 'placeholder' => __('Enter Leave Type Name')]) }}
                                                    @error('title')
                                                        <span class="invalid-name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {{ Form::label('days', __('Days/Hours Per Year'), ['class' => 'form-control-label']) }}
                                                    <input type="number" name="days" id="days" value="{{ $leavetype->days }}"  class="form-control"  placeholder="Enter Days / Year">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group mb-0">
                                                    <label for="cat">Is this leave valid for 3 years?</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="leave_valid" id="inlineRadio1" value="Yes" {{ $leavetype->leave_valid == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline ">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="leave_valid" id="inlineRadio2" value="No" {{ $leavetype->leave_valid == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           

                                        </div>
                                    </div>
                                </div>

                                <div class="tab">
                                    <div class="card mt-3" style="width: 100%;">
                                        <div class="card-header align-items-center d-flex justify-content-between"
                                            style="padding: 5px 15px;">
                                            <legend class="mb-0"> {{ __('Extra Days') }} </legend>
                                            <button class="btn rounded" type="button" data-toggle="collapse"
                                                data-target="#collapseExample2" aria-expanded="false"
                                                aria-controls="collapseExample" id="collapse2">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="card-body collapse show" id="collapseExample2">
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="employees_qualify">Do certain employees qualify for extra days? </label>
                                                    <select id="employees_qualify" class="form-control form-control-sm"
                                                        name="">
                                                        <option value="yes" {{ $leavetype->employees_qualify == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="no" {{ $leavetype->employees_qualify == 'no' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div style="display:none;" id="employees_qualify_details" class="group_wrapper">
                                                <legend class="mb-0">Extra Days asign to certain employees (days)</legend>
                                                <table id="itemTable3" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Employes</th>
                                                            <th>Days</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="field_wrapper4">
                                                        <tr class="item3">
                                                            <td>
                                                                <select class="form-control selected_employee" name="employee">
                                                                    {{ $emps = App\Models\Employee::orderBy('name')->get(); }}
                                                                    @foreach ($emps as $key => $emp)
                                                                        <option value="{{$emp->id}}">{{$emp->name}}+</option> 
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="number" value="0" class="form-control extra_day_for_employee" placeholder="Days"></td>
                                                            <td>
                                                                <a href="javascript:void(0);" class="add_button4 btn btn-sm btn-primary" title="Add field">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                 <div class="form-group">
                                                    <label for="tenure">Does time off allowance increase with
                                                        tenure?</label>
                                                    <select id="tenure" class="form-control form-control-sm">
                                                        <!-- <option value="" selected disabled>---Select---</option> -->
                                                        <option value="yes" {{ $leavetype->tenure == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="no" {{ $leavetype->tenure == 'no' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                    
                                                </div>

                                                <div style="display:none;" id="tenure_wrapper" class="group_wrapper">
                                                    <legend class="mb-0">Tenure</legend>
                                                    <table id="itemTable" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Years in service</th>
                                                                <th>Additional days</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="field_wrapper">
                                                            <tr class="item">
                                                                <td><select class="form-control tenure_years_service" name="years_service"
                                                                        id="tenure_years_service">
                                                                        @for($i = 1; $i < 40; $i++)
                                                                            <option value="{{$i}}">{{$i}} +</option>
                                                                        @endfor
                                                                    </select></td>
                                                                <td><input type="number" value="0" class="form-control tenure_additional_days" 
                                                                        placeholder="Additional days"></td>
                                                                <td><a href="javascript:void(0);"
                                                                        class="add_button btn btn-sm btn-primary"
                                                                        title="Add field"><i class="fa fa-plus"></i></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                      <div class="form-group">
                                                    <label for="tenure">Tenure award options?</label>
                                                    <select id="tenure_award" class="form-control form-control-sm"
                                                        name="tenure_award">
                                                        <option value="" disabled>---Select---</option>
                                                        <option value="pro-rated" {{ $leavetype->tenure_award == 'pro-rated' ? 'selected' : '' }}>Tenure award is pro-rated for the anniversary year</option>
                                                        <option value="year_start" {{ $leavetype->tenure_award == 'year_start' ? 'selected' : '' }}>Tenure award is given as if the anniversary occured at the start of the time off year</option>
                                                        <option value="exact_date" {{ $leavetype->tenure_award == 'exact_date' ? 'selected' : '' }}>Tenure award is given at the anniversary date</option>                                                        
                                                    </select>
                                                </div>
                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="cat"> {{ __('How should values be rounded?') }}
                                                    </label>
                                                    <select class="form-control form-control-sm" name="value_round"
                                                        id="value_round">
                                                        <option value="round_half"  {{ $leavetype->value_round == 'round_half' ? 'selected' : '' }}>Round Upto nearest half</option>
                                                        <option value="round_2_decimal" {{ $leavetype->value_round == 'round_2_decimal' ? 'selected' : '' }}>Round to 2 decimal places</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab">
                                    <div class="card mt-3" style="width: 100%;">
                                        <div class="card-header align-items-center d-flex justify-content-between"
                                            style="padding: 5px 15px;">
                                            <legend class="mb-0"> {{ __('Leave Calculation') }} </legend>
                                            <button class="btn rounded" type="button" data-toggle="collapse"
                                                data-target="#collapseExample3" aria-expanded="false"
                                                aria-controls="collapseExample" id="collapse3">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="card-body collapse show" id="collapseExample3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="cat">Minimum unit of time for requesting time
                                                        off.</label>
                                                    <select class="form-control form-control-sm" name=""
                                                        id="requesting_time">
                                                        <option value="any" {{ $leavetype->requesting_time == 'any' ? 'selected' : '' }}>Any</option>
                                                        <option value="whole_day" {{ $leavetype->requesting_time == 'whole_day' ? 'selected' : '' }}>Whole day</option>
                                                        <option value="half_days" {{ $leavetype->requesting_time == 'half_days' ? 'selected' : '' }}>Half day</option>
                                                        <option value="2_hours" {{ $leavetype->requesting_time == '2_hours' ? 'selected' : '' }}>2 hours</option>
                                                        <option value="1_hours" {{ $leavetype->requesting_time == '1_hours' ? 'selected' : '' }}>1 hour</option>
                                                        <option value="30_minutes" {{ $leavetype->requesting_time == '30_minutes' ? 'selected' : '' }}>30 minutes</option>
                                                        <option value="20_minutes" {{ $leavetype->requesting_time == '20_minutes' ? 'selected' : '' }}>20 minutes</option>
                                                        <option value="15_minutes" {{ $leavetype->requesting_time == '15_minutes' ? 'selected' : '' }}>15 minutes</option>
                                                        <option value="10_minutes" {{ $leavetype->requesting_time == '10_minutes' ? 'selected' : '' }}>10 minutes</option>
                                                        <option value="5_minutes" {{ $leavetype->requesting_time == '5_minutes' ? 'selected' : '' }}>5 minutes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 parent">
                                                <div class="form-group">
                                                    <label
                                                        for="cat">{{ __('When is the start date of each time off year?') }}</label>
                                                    <select id="date_join" class="form-control form-control-sm"
                                                        >
                                                        <option value="" selected disabled>---Select---</option>
                                                        <option value="anniversary" {{$leavetype->date_join == 'anniversary' ? 'selected' : ''}}>On the anniversary of the employee's
                                                            starting date</option>
                                                        <option value="specific_date" {{$leavetype->date_join == 'specific_date' ? 'selected' : ''}}>On a specific date</option>
                                                    </select>
                                                </div>

                                                <div id="date_join_show" style="display: none;" class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="cat">Enter specific date</label>
                                                        <input type="date" class="form-control" id="specific_date" value="{{$leavetype->date_join}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 parent_delay mb-2 mx-0 px-0">
                                                    <div class="form-group">
                                                        <label for="cat">Delay the time off start date from the
                                                            employee starting date?</label>
                                                        <select id="delay_time" class="form-control form-control-sm">
                                                            <option value="yes">Yes</option>
                                                            <option selected value="no">No</option>
                                                        </select>
                                                    </div>
                                                    <div id="delay_time_show" style="display: none;" class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cat">Select Month</label>
                                                            <select class="form-control form-control-sm" name=""
                                                                id="month_delay">
                                                                <option value="1" {{$leavetype->month_delay == '1' ? 'selected' : ''}}>1 Month</option>
                                                                <option value="2" {{$leavetype->month_delay == '2' ? 'selected' : ''}}>2 Months</option>
                                                                <option value="3" {{$leavetype->month_delay == '3' ? 'selected' : ''}}>3 Months</option>
                                                                <option value="4" {{$leavetype->month_delay == '4' ? 'selected' : ''}}>4 Months</option>
                                                                <option value="5" {{$leavetype->month_delay == '5' ? 'selected' : ''}}>5 Months</option>
                                                                <option value="6" {{$leavetype->month_delay == '6' ? 'selected' : ''}}>6 Months</option>
                                                                <option value="7" {{$leavetype->month_delay == '7' ? 'selected' : ''}}>7 Months</option>
                                                                <option value="8" {{$leavetype->month_delay == '8' ? 'selected' : ''}}>8 Months</option>
                                                                <option value="9" {{$leavetype->month_delay == '9' ? 'selected' : ''}}>9 Months</option>
                                                                <option value="10" {{$leavetype->month_delay == '10' ? 'selected' : ''}}>10 Months</option>
                                                                <option value="11" {{$leavetype->month_delay == '11' ? 'selected' : ''}}>11 Months</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="soon_employees_take_leave">How soon after joining the organization can employees take time off?</label>
                                                    <input class="form-control" id="soon_employees_take_leave" type="number" placeholder="After Days" value="{{$leavetype->soon_employees_take_leave}}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="tab">
                                    <div class="card " style="width:100%">
                                        <div class="card-header align-items-center d-flex justify-content-between"
                                            style="padding: 5px 15px;">
                                            <legend class="mb-0"> Approval</legend>
                                            <button class="btn rounded" type="button" data-toggle="collapse"
                                                data-target="#collapseExample1" aria-expanded="false"
                                                aria-controls="collapseExample" id="collapse1">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>

                                        <div class="card-body collapse show" id="collapseExample1">

                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="policy">Should requests within policy still be routed for
                                                        approval? </label>
                                                    <select id="policy" class="form-control form-control-sm"
                                                        name="policy">
                                                        <option value="yes" {{ $leavetype->policy == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="no" {{ $leavetype->policy == 'no' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="notice_when_booking">Do employees need to give a certain
                                                        amount of notice when booking time off?</label>
                                                    <select id="notice_when_booking" class="form-control form-control-sm"
                                                        name="" id="">
                                                        <option value="yes" {{$leavetype->notice_when_booking == 'yes' ? 'selected' : ''}}>Yes</option>
                                                        <option value="no" {{$leavetype->notice_when_booking == 'no' ? 'selected' : ''}}>No</option>
                                                    </select>
                                                </div>

                                                <div style="display:none;" id="notice_when_booking_details"
                                                    class="group_wrapper">
                                                    <legend class="mb-0">Days requested Notice required (days)</legend>
                                                    <table id="itemTable2" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Days Requested</th>
                                                                <th>Notice Required (Days) </th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="field_wrapper2">
                                                            <tr class="item2">
                                                                <td><select class="form-control booking_notice_requested_days" name="requested_days">
                                                                        <option value="1">1</option>
                                                                        <option value="3">3</option>
                                                                        <option value="5">5</option>
                                                                        <option value="10">10</option>
                                                                        <option value="20">20</option>
                                                                        <option value="30">30</option>
                                                                    </select></td>
                                                                <td><input type="number"class="form-control booking_notice_days"
                                                                        placeholder="Days" value="0"></td>
                                                                <td><a href="javascript:void(0);"
                                                                        class="add_button2 btn btn-sm btn-primary"
                                                                        title="Add field"><i class="fa fa-plus"></i></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="approves">Who approves time off requests? </label>
                                                    <select id="approves" class="form-control form-control-sm"
                                                        name="" id="">
                                                        <option value="admin" {{ $leavetype->approves == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="hr" {{ $leavetype->approves == 'hr' ? 'selected' : '' }}>Hr management</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="notified">Who else is notified on approval (optional)?
                                                    </label>
                                                    <select id="notified" class="form-control form-control-sm"
                                                        name="notified" >
                                                        <option value="admin" {{ $leavetype->notified == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option selected value="hr" {{ $leavetype->notified == 'hr' ? 'selected' : '' }}>Hr management</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Accural stepper --}}
                                <div class="tab">
                                    <div class="card " style="width:100%">
                                        <div class="card-header align-items-center d-flex justify-content-between"
                                            style="padding: 5px 15px;">
                                            <legend class="mb-0"> Carry over</legend>
                                            <button class="btn rounded" type="button" data-toggle="collapse"
                                                data-target="#collapseExample1" aria-expanded="false"
                                                aria-controls="collapseExample" id="collapse1">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>

                                        <div class="card-body collapse show" id="collapseExample1">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="carry">Can employees carry over unused time off to the
                                                        following year?</label>
                                                    <select id="carry" class="form-control form-control-sm">
                                                        <option value="1" {{$leavetype->carry == '1' ? 'selected' : ''}}>Yes</option>
                                                        <option selected value="0" {{$leavetype->carry == '0' ? 'selected' : ''}}>No</option>
                                                    </select>
                                                </div>
                                                <div id="carry_detail" style="display:none;">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="carry_over_expire">Does carryover expire?</label>
                                                            <select id="carry_over_expire" class="form-control form-control-sm">
                                                                <option value="yes" {{$leavetype->carry_over_expire == 'yes' ? 'selected' : ''}}>Yes</option>
                                                                <option selected value="no" {{$leavetype->carry_over_expire == 'no' ? 'selected' : ''}}>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" id="when_carry_over_expire_div">
        
                                                        <div class="form-group">
                                                            <label for="When_carry_over_expire">When does carryover expire?</label>
                                                            <select id="When_carry_over_expire" class="form-control form-control-sm"
                                                                name="">
                                                                <option value="null" disabled>---Select---</option>
                                                                <option value="1" {{$leavetype->When_carry_over_expire == '1' ? 'selected' : ''}}>1 months after the end of the time off year</option>
                                                                <option value="2" {{$leavetype->When_carry_over_expire == '2' ? 'selected' : ''}}>2 months after the end of the time off year</option>
                                                                <option value="3" {{$leavetype->When_carry_over_expire == '3' ? 'selected' : ''}}>3 months after the end of the time off year</option>
                                                                <option value="4" {{$leavetype->When_carry_over_expire == '4' ? 'selected' : ''}}>4 months after the end of the time off year</option>
                                                                <option value="5" {{$leavetype->When_carry_over_expire == '5' ? 'selected' : ''}}>5 months after the end of the time off year</option>
                                                                <option value="6" {{$leavetype->When_carry_over_expire == '6' ? 'selected' : ''}}>6 months after the end of the time off year</option>
                                                                <option value="7" {{$leavetype->When_carry_over_expire == '7' ? 'selected' : ''}}>7 months after the end of the time off year</option>
                                                                <option value="8" {{$leavetype->When_carry_over_expire == '8' ? 'selected' : ''}}>8 months after the end of the time off year</option>
                                                                <option value="9" {{$leavetype->When_carry_over_expire == '9' ? 'selected' : ''}}>9 months after the end of the time off year</option>
                                                                <option value="10" {{$leavetype->When_carry_over_expire == '10' ? 'selected' : ''}}>10 months after the end of the time off year</option>
                                                                <option value="11" {{$leavetype->When_carry_over_expire == '11' ? 'selected' : ''}}>11 months after the end of the time off year</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="carry_over">How much can be carried over?</label>
                                                            <select id="carry_over" class="form-control form-control-sm">
                                                                <option value="null" disabled>---Select---</option>
                                                                <option value="no_limit" {{$leavetype->carry_over == 'no_limit' ? 'selected' : ''}}>No limit</option>
                                                                <option value="limit" {{$leavetype->carry_over == 'limit' ? 'selected' : ''}}>Limited to a certain number of days</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group" id="carried_over_days_div">
                                                            <label for="carried_over_days">Enter number of days</label>
                                                            <input type="number" name="carried_over_days" id="carried_over_days" value="{{$leavetype->carried_over_days}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                

                                <div class="tab">
                                    <div class="card " style="width:100%">
                                        <div class="card-header align-items-center d-flex justify-content-between"
                                            style="padding: 5px 15px;">
                                            <legend class="mb-0"> Accrued</legend>
                                            <button class="btn rounded" type="button" data-toggle="collapse"
                                                data-target="#collapseExample1" aria-expanded="false"
                                                aria-controls="collapseExample" id="collapse1">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>

                                        <div class="card-body collapse show" id="collapseExample1">

                                            <div class="col-md-12">
                                                <div class="form-group mb-0">
                                                    <label for="entitlement_time_off">Is time off entitlement accrued?</label>
                                                    <select id="entitlement_time_off" class="form-control form-control-sm">
                                                        <option value="1" {{$leavetype->entitlement_time_off == "1" ? 'selected' : ''}}>Yes</option>
                                                        <option value="0" {{$leavetype->entitlement_time_off == "0" ? 'selected' : ''}}>NO </option>
                                                    </select>

                                                </div>

                                            <div class="col-md-12" id="entitlement_time_off_field" style="display: none;">
                                                <div class="form-group mb-0">
                                                    <label for="when_entitlement_time_off">When is time off entitlement accrued?</label>
                                                    <select id="when_entitlement_time_off" class="form-control form-control-sm">
                                                        <option value="null" disabled  {{$leavetype->when_entitlement_time_off == 'null' ? 'selected' : ''}}>---Select---</option>
                                                        <option value="monthly" {{$leavetype->when_entitlement_time_off == 'monthly' ? 'selected' : ''}}>Monthly</option>
                                                        <option value="quarterly" {{$leavetype->when_entitlement_time_off == 'quarterly' ? 'selected' : ''}}>Quarterly</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label>Accrued start time</label>
                                                    <select id="when_entitlement_time_off_at" class="form-control form-control-sm">
                                                        <option value="null" disabled {{$leavetype->when_entitlement_time_off_at == 'null' ? 'selected' : ''}}>---Select---</option>
                                                        <option value="start" {{$leavetype->when_entitlement_time_off_at == 'start' ? 'selected' : ''}}>Accrued at the start of the period</option>
                                                        <option value="end" {{$leavetype->when_entitlement_time_off_at == 'end' ? 'selected' : ''}}>Accrued at the end of the period</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label for="how_entitlement_time_off">How should time off be accrued?</label>
                                                    <select id="how_entitlement_time_off" class="form-control form-control-sm">
                                                        <option value="null" disabled {{$leavetype->how_entitlement_time_off == 'null' ? 'selected' : ''}}>---Select---</option>
                                                        <option value="day" {{$leavetype->how_entitlement_time_off == 'day' ? 'selected' : ''}}>Accrue time off evenly across each working day</option>
                                                        <option value="month" {{$leavetype->how_entitlement_time_off == 'month' ? 'selected' : ''}}>Accrue time off evenly across each month
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label for="can_take_entitlement_time_off">Can employees take time off before they have accrued it?</label>
                                                    <select id="can_take_entitlement_time_off" class="form-control form-control-sm"
                                                        name="" id="">
                                                        <option value="1" {{$leavetype->can_take_entitlement_time_off == "1" ? 'selected' : ''}}>yes</option>
                                                        <option value="0" {{$leavetype->can_take_entitlement_time_off == "0" ? 'selected' : ''}}>no</option>
                                                    </select>
                                                    <div class="form-group mb-0 col-md-12" id="can_take_entitlement_time_off_field" style="display: none;">
                                                        <label for="borrowed_entitlement_time_off_limit">How much can be borrowed?</label>
                                                        <select id="borrowed_entitlement_time_off_limit" class="form-control form-control-sm">
                                                            <option value="null" disabled {{$leavetype->borrowed_entitlement_time_off_limit == 'null' ? 'selected' : ''}}>---Select---</option>
                                                            <option value="1" {{$leavetype->borrowed_entitlement_time_off_limit == '1' ? 'selected' : ''}}>Limited to a certain number of days</option>
                                                            <option value="0" {{$leavetype->borrowed_entitlement_time_off_limit == '0' ? 'selected' : ''}}>No limit</option>
                                                        </select>

                                                        <div class="form-group mb-0 col-md-12" id="can_take_entitlement_time_off_field2" style="display: none;">
                                                            <label for="borrowed_entitlement_time_off">How much can be borrowed?</label>
                                                            <input type="number" name="borrowed_entitlement_time_off" id="borrowed_entitlement_time_off" placeholder="Enter No. of days" value="{{$leavetype->borrowed_entitlement_time_off ?? '0'}}">
                                                        </div>
                                                    </div>
                                                </div>

                                               

                                                <div class="form-group mb-0">
                                                    <label for="show_dashboard_balance">Choose what balances to show in the main dashboard</label>
                                                    <select id="show_dashboard_balance" class="form-control form-control-sm"
                                                        name="show_dashboard_balance">
                                                        <option value="null" disabled {{$leavetype->show_dashboard_balance == 'null' ? 'selected' : ''}}>---Select---</option>
                                                        <option value="end_off_year" {{$leavetype->show_dashboard_balance == 'end_off_year' ? 'selected' : ''}}>Show balance to end of time off year</option>
                                                        <option value="off_today" {{$leavetype->show_dashboard_balance == 'off_today' ? 'selected' : ''}}>Show balance to today (currently accrued, available)</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label for="apply_upper_limit_entitlement_time_off">Apply an upper limit on how much time off may be accrued?</label>
                                                    <select id="apply_upper_limit_entitlement_time_off" class="form-control form-control-sm"
                                                        name="apply_upper_limit_entitlement_time_off">
                                                        <option value="1" {{$leavetype->apply_upper_limit_entitlement_time_off == "1" ? 'selected' : ''}}>yes</option>
                                                        <option value="0" {{$leavetype->apply_upper_limit_entitlement_time_off == "0" ? 'selected' : ''}}>no</option>
                                                    </select>
                                                    <div class="form-group mb-0 col-md-12" id="apply_upper_limit_entitlement_time_off_field" style="display: none;"  >
                                                        <label for="borrowed_entitlement_time_off_accrual_cap">accrual cap?</label>
                                                        <input type="number" name="borrowed_entitlement_time_off_accrual_cap" id="borrowed_entitlement_time_off_accrual_cap" placeholder="Enter No. of days" value="{{$leavetype->borrowed_entitlement_time_off_accrual_cap ?? '0'}}">
                                                    </div>
                                                </div>

                                                

                                                <div class="form-group mb-0">
                                                    {{-- <label for="prevent_accrual_period">Prevent accrual for a period following the employee's hire date</label> --}}
                                                    {{-- <select id="prevent_accrual_period" class="form-control form-control-sm"
                                                        name="" id="">
                                                        <option value="null" selected disabled>---Select---</option>
                                                        <option value="1">Prevent accrual for the specified period</option>
                                                        <option value="0">Defer accrual for the specified period</option>
                                                    </select> --}}
                                                    {{-- <select class="form-control " id="prevent_month">
                                                        <option selected value="1">1 Month</option>
                                                        <option value="2">2 Month</option>
                                                        <option value="3">3 Month</option>
                                                        <option value="4">4 Month</option>
                                                        <option value="5">5 Month</option>
                                                        <option value="6">6 Month</option>
                                                        <option value="7">7 Month</option>
                                                        <option value="8">8 Month</option>
                                                        <option value="9">9 Month</option>
                                                        <option value="10">10 Month</option>
                                                        <option value="11">11 Month</option>
                                                        <option value="12">12 Month</option>
                                                    </select> --}}
                                                <div class="col-md-12" id="prevent_accrual_period_field" style="display: none;"  >

                                                <div class="form-group mb-0">
                                                    <label for="set_leave_amount_immediately">If accrual is prevented, would you like to set an amount for leave to be allowed immediately?</label>
                                                    <select id="set_leave_amount_immediately" class="form-control form-control-sm">
                                                        <!-- <option value="" selected disabled>---Select---</option> -->
                                                        <option value="1" {{$leavetype->set_leave_amount_immediately == '1' ? 'selected' : ''}}>yes</option>
                                                        <option value="0" {{$leavetype->set_leave_amount_immediately == '0' ? 'selected' : ''}}>no</option>
                                                    </select>
                                                    <div class="form-group mb-0 col-md-12" id="set_leave_amount_immediately_field" style="display: none;">
                                                        <label for="set_leave_amount_immediately_specify">please specify the amount?</label>
                                                        <input type="number" name="set_leave_amount_immediately_specify" id="set_leave_amount_immediately_specify" placeholder="Enter No. of days" value="{{$leavetype->set_leave_amount_immediately_specify ?? '0'}}">
                                                    </div>
                                                </div>

                                                
                                                
                                            </div>
                                            <div class="form-group mb-0">
                                                <label for="set_bulk_leave_amount">Would you like to add remaining bulk amount of leave to the total available at any point?</label>
                                                <select id="set_bulk_leave_amount" class="form-control form-control-sm"
                                                    name="set_bulk_leave_amount">
                                                    <option value="yes" {{$leavetype->set_bulk_leave_amount == 'yes' ? 'selected' : ''}}>yes</option>
                                                    <option selected value="no" {{$leavetype->set_bulk_leave_amount == 'no' ? 'selected' : ''}}>no</option>
                                                </select>
                                            </div>

                                            <div style="display:none;" id="set_bulk_leave_amount_wrapper" class="group_wrapper">
                                                <label>Select after how many months</label>
                                                <select class="form-control set_bulk_leave_month" name="bulk_leave_after_month"
                                                    id="bulk_leave_after_month">
                                                    <option value="1" {{$leavetype->bulk_leave_after_month == '1' ? 'selected' : ''}}>1 Month</option>
                                                    <option value="2" {{$leavetype->bulk_leave_after_month == '2' ? 'selected' : ''}}>2 Month</option>
                                                    <option value="3" {{$leavetype->bulk_leave_after_month == '3' ? 'selected' : ''}}>3 Month</option>
                                                    <option value="4" {{$leavetype->bulk_leave_after_month == '4' ? 'selected' : ''}}>4 Month</option>
                                                    <option value="5" {{$leavetype->bulk_leave_after_month == '5' ? 'selected' : ''}}>5 Month</option>
                                                    <option value="6" {{$leavetype->bulk_leave_after_month == '6' ? 'selected' : ''}}>6 Month</option>
                                                    <option value="7" {{$leavetype->bulk_leave_after_month == '7' ? 'selected' : ''}}>7 Month</option>
                                                    <option value="8" {{$leavetype->bulk_leave_after_month == '8' ? 'selected' : ''}}>8 Month</option>
                                                    <option value="9" {{$leavetype->bulk_leave_after_month == '9' ? 'selected' : ''}}>9 Month</option>
                                                    <option value="10" {{$leavetype->bulk_leave_after_month == '10' ? 'selected' : ''}}>10 Month</option>
                                                    <option value="11" {{$leavetype->bulk_leave_after_month == '11' ? 'selected' : ''}}>11 Month</option>
                                                    <option value="12" {{$leavetype->bulk_leave_after_month == '12' ? 'selected' : ''}}>12 Month</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    </div>
                                            
                                            

                                        </div>
                                    </div>
                                </div>

                                <div class="tab">
                                    <div class="card " style="width:100%">
                                        <div class="card-header align-items-center d-flex justify-content-between"
                                            style="padding: 5px 15px;">
                                            <legend class="mb-0"> Policy</legend>
                                            <button class="btn rounded" type="button" data-toggle="collapse"
                                                data-target="#collapseExample1" aria-expanded="false"
                                                aria-controls="collapseExample" id="collapse1">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>

                                        <div class="card-body collapse show" id="collapseExample1">
                                            <div class="col-md-12">
                                                  {{-- policy --}}

                                            <div class="col-md-12">
                                                <div class="form-group mb-0">
                                                    <label for="carryover">Set an optional colour for the time off policy.</label>
                                                    <input type="color" value="{{ $leavetype->color }}" name="color" id="color">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group mb-0">
                                                    <label for="policy-wording">Show the policy wording in the time off request dialog?</label>
                                                    <select id="policy_wording" class="form-control form-control-sm"
                                                        name="policy_wording">
                                                        <option value="policy-generated" selected>Show policy-generated wording</option>
                                                        <option value="specify-wording">Specify wording </option>
                                                    </select>

                                                    <textarea style="display: none; width: 100%; height:150px;" class="mt-2 form-control" name="policy-words" id="policy-word" rows="3" placeholder="Specify your word here"></textarea>
                                                </div>
                                            </div>
                                            <style>
                                                .policy-radio{
                                                    display: flex;
                                                    justify-content: space-between;
                                                    align-items: center;
                                                }
                                            </style>

                                            <div class="form-group">
                                                <label for="carry">What action should be taken if any of the
                                                    following are out of policy?</label>

                                                <div class="form-group mb-0 policy-radio">
                                                    <label for="cat">Annual allowance exceeded</label>
                                                    <div class="">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="annual_allowance_exceeded" id="annual_allowance_exceeded" value="1" {{ $leavetype->annual_allowance_exceeded == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="annual_allowance_exceeded">Send for approval</label>
                                                        </div>
                                                        <div class="form-check form-check-inline ">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="annual_allowance_exceeded" id="annual_allowance_exceeded2" value="0" {{ $leavetype->annual_allowance_exceeded == '0' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="annual_allowance_exceeded2">Reject</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 policy-radio">
                                                    <label for="cat">Requested more than accrued</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="more_than_accrued" id="more_than_accrued" value="1" {{ $leavetype->more_than_accrued == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="more_than_accrued">Send for approval</label>
                                                        </div>
                                                        <div class="form-check form-check-inline ">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="more_than_accrued" id="more_than_accrued2" value="0" {{ $leavetype->more_than_accrued == '0' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="more_than_accrued2">Reject</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="form-group mb-0 policy-radio">
                                                    <label for="cat">Insufficient notice given</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="notice_given" id="notice_given" value="1" {{ $leavetype->notice_given == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="notice_given">Send for approval</label>
                                                        </div>
                                                        <div class="form-check form-check-inline ">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="notice_given" id="notice_given2" value="0" {{ $leavetype->notice_given == '0' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="notice_given2">Reject</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0 policy-radio">
                                                    <label for="cat">Time off requested during probation period</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="probation_period" id="probation_period" value="1" {{ $leavetype->probation_period == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="probation_period">Send for approval</label>
                                                        </div>
                                                        <div class="form-check form-check-inline ">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="probation_period" id="probation_period2" value="0" {{ $leavetype->probation_period == '0' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="probation_period2">Reject</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 policy-radio">
                                                    <label for="cat">Time off booked over a blackout day</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="blackout_day" id="blackout_day" value="1" {{ $leavetype->blackout_day == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="blackout_day">Send for approval</label>
                                                        </div>
                                                        <div class="form-check form-check-inline ">
                                                            <input class="form-check-input mb-0" type="radio"
                                                                name="blackout_day" id="blackout_day2"  value="0" {{ $leavetype->blackout_day == '0' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="blackout_day2">Reject</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="overflow:auto; margin-top:10px;">
                                    <div style="float:right;">
                                        <button class="btn btn-create bg-gray" type="button" id="prevBtn"
                                            onclick="nextPrev(-1)">Previous</button>
                                        <button class="btn btn-create badge-blue" type="button" id="nextBtn"
                                            onclick="nextPrev(1)">Next</button>
                                    </div>
                                </div>

                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:20px;">
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                </div>
                        </div>
                        <div class="col-md-12" id="previewTab" style="display:none;">
                            <div class="card-header align-items-center d-flex justify-content-between"
                                style="padding: 5px 15px;">
                                <legend class="mb-0"> Preview</legend>
                                <button class="btn rounded" type="button" data-toggle="collapse"
                                    data-target="#collapseExample1" aria-expanded="false"
                                    aria-controls="collapseExample" id="collapse1">
                                    <i class="fas fa-minus"></i>
                                </button>
                                </div>
                            <p id="preview"></p>
                            <form action="{{route('leavetype.update', $leavetype->id)}}" method="post" id="regForm">
                                @method('PUT')
                                @csrf <!-- {{ csrf_field() }} -->
                                <input type="hidden" name="data" id="dataInput">
                                <div style="overflow:auto; margin-top:10px;">
                                    <div style="float:right;">
                                        <button class="btn btn-create bg-gray" type="button"
                                            onclick="backToEdit()">Edit</button>
                                        <button class="btn btn-create badge-blue" type="submit"
                                            >Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
    <script>
      $(function () {
        $(document).ready(function() {
            var x = new SlimSelect({
                select: '#multidelect'
            }); 
        });
      })

        var varEdit3 = 1;
        var var1 = 1;

       $(document).ready(function() {
            if ("{{ $leavetype->employees_qualify }}" == "yes") {

                $("#employees_qualify_details").show();
                
                var html_fields4_exit = ''
                var emp_qualifies = {!! json_encode($leavetype->employees_qualifies) !!};                    
                var emps = {!! $emps !!};

                if (emp_qualifies.length > 0) {
                    varEdit3 = 0;
                }

                emp_qualifies.forEach(function (emp, i) {
                    
                    empOptions = '';
                    varEdit3++
                    emps.forEach(emps => {
                        
                        var slected = emp.employee.id == emps.id ? 'selected' : '';
                        empOptions += `<option value="${emps.id}" ${slected}>${emps.name}</option>`;
                    });

                    addButtonRemove = i == 0 ? '<td> <a href="javascript:void(0);" class="add_button4 btn btn-sm btn-primary" title="Add field"><i class="fa fa-plus"></i></a> </td>' : '<td> <a href="javascript:void(0);" class="remove_button2 btn btn-sm btn-danger"><i class="fa fa-minus"></i></a> </td>';

                    html_fields4_exit +=   '<tr class="item3">'+
                                            '<td><select class="form-control selected_employee" name="employee" id="">'+empOptions+
                                            '</select></td>'+
                                            `<td><input type="number" value="${emp.days}"  class="form-control extra_day_for_employee" placeholder="Days"></td>`+addButtonRemove+
                                            '</tr>';
                });

                if (emp_qualifies.length > 0) {
                    $('.field_wrapper4').html(html_fields4_exit);
                }
            }

            if ("{{ $leavetype->tenure }}" == "yes") {

                $("#tenure_wrapper").show();

                var html_fields_exit = ''
                var tenures = {!! json_encode($leavetype->tenure_in_leaves) !!};                    

                if (tenures.length > 0) {
                    var1 = 0;
                }

                tenures.forEach(function (tenure, index) {
                                
                    tenuresOptions = '';
                    var1++

                    if (index == 0) {

                        var options = '';
                        for(var i = 1; i < 40; i++) {

                            var selected =  i == tenure.year_service ? 'selected' : '';
                            options += `<option value="${i}" ${selected}>${i}+</option>`;
                        }
                        
                        html_fields_exit += '<tr class="item">' +
                            '<td><select class="form-control tenure_years_service" name="years_service" id="">' +
                             options+
                            '</select></td>' +
                            `<td><input type="number"class="form-control tenure_additional_days" value="${tenure.additional_days}" placeholder="Additional days" ></td>` +
                            '<td> <a href="javascript:void(0);" class="add_button btn btn-sm btn-primary" title="Add field"><i class="fa fa-plus"></i></a> </td>' +
                                '</tr>';
                    } else {

                        var selectedFive =  5 == tenure.year_service ? 'selected' : '';
                        var selectedTen =  10 == tenure.year_service ? 'selected' : '';

                        html_fields_exit += '<tr class="item">' +
                                '<td><select class="form-control tenure_years_service" name="years_service" id="">' +
                                `<option value="5" ${selectedFive}>5+</option>` +
                                `<option value="10" ${selectedTen}>10+</option>` +
                                '</select></td>' +
                                `<td><input type="number"class="form-control tenure_additional_days" value="${tenure.additional_days}" placeholder="Additional days" ></td>` +
                                '<td> <a href="javascript:void(0);" class="remove_button btn btn-sm btn-danger"><i class="fa fa-minus"></i></a> </td>' +
                                '</tr>';
                    }
                });

                if (tenures.length > 0) {
                    $('.field_wrapper').html(html_fields_exit);
                }
            } 
        });
    </script>
    <script>
        var max_field = 3;
        var add_button = $('.add_button');
        var wrapper = $('.field_wrapper');

        var html_fields = '' +

            '<tr class="item">' +
            '<td><select class="form-control tenure_years_service" name="years_service" id="">' +
            '<option value="5">5+</option>' +
            '<option value="10">10+</option>' +
            '</select></td>' +
            '<td><input type="number"class="form-control tenure_additional_days" placeholder="Additional days" ></td>' +
            '<td> <a href="javascript:void(0);" class="remove_button btn btn-sm btn-danger"><i class="fa fa-minus"></i></a> </td>' +
            '</tr>';

        var var2 = 1;

        $(document).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            var1--;
        });
        $(document).on('click', '.add_button', function() {
            if (var1 < max_field) {
                var1++;
                $(this).closest('.field_wrapper').append(html_fields);
            }
        });

        // 2
        var add_button2 = $('.add_button2');
        var wrapper2 = $('.field_wrapper2');

        var html_fields2 = '' +

            '<tr class="item">' +
            '<td><select class="form-control booking_notice_requested_days" name="years_service" id="">' +
            '<option value="">5+</option>' +
            '<option value="">10+</option>' +
            '</select></td>' +
            '<td><input type="number"class="form-control booking_notice_days" placeholder="Days" ></td>' +
            '<td> <a href="javascript:void(0);" class="remove_button2 btn btn-sm btn-danger"><i class="fa fa-minus"></i></a> </td>' +
            '</tr>';

        var var3 = 1;
        var var4 = 1;


        $(document).on('click', '.add_button2', function() {
            if (var3 < max_field) {
                var3++;
                $(this).closest('.field_wrapper2').append(html_fields2);
            }
        });

        $(document).on('click', '.remove_button2', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            var3--;
        });

        // 3
        var add_button3 = $('.add_button3');
        var wrapper3 = $('.field_wrapper3');

        var html_fields3 = '' +

            '<tr class="item">' +
            '<td><select class="form-control" name="years_service" id="">' +
            '<option value="">5+</option>' +
            '<option value="">10+</option>' +
            '</select></td>' +
            '<td><input type="number"class="form-control" placeholder="Days" ></td>' +
            '<td> <a href="javascript:void(0);" class="remove_button3 btn btn-sm btn-danger"><i class="fa fa-minus"></i></a> </td>' +
            '</tr>';

        var var5 = 1;
        var var6 = 1;


        $(document).on('click', '.add_button3', function() {
            if (var5 < max_field) {
                var5++; 
                $(this).closest('.field_wrapper3').append(html_fields3);
            }
        });

        $(document).on('click', '.remove_button3', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            var5--;
        });

        let who_approves = '';

        if ($("#approves").val() == 'hr') {
            who_approves = 'Hr Management';
        } else {
            who_approves = 'Admin';
        }

        let can_take_entitlement_time_off_show = '';
        if ($('#can_take_entitlement_time_off').val() == '1') {
            can_take_entitlement_time_off_show = 'Yes';
        } else {
            can_take_entitlement_time_off_show = 'No';
        }
    </script>
    <script>
        $(document).ready(function() {
            // 
            $('#policy-wording').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == 'specify-wording') {
                    $("#policy-word").show();
                } else {
                    $("#policy-word").hide();
                }
            });
            // policy wording
            $('#policy-wording').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == 'specify-wording') {
                    $("#policy-word").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#policy-word").hide();
                }
            });
            // join date
            $('#date_join').on('change', function() {
                var svalue = $(this).val();
                if (svalue == 'specific_date') {
                    $("#date_join_show").show();
                    $(".parent").addClass("border bg-gray-100 rounded");
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#date_join_show").hide();
                }
            });
            // start date
            $('#date_join').on('change', function() {
                var svalue = $(this).val();
                if (svalue == 'anniversary') {
                    $("#delay_start_date").show();
                    $(".parent").addClass("border bg-gray-100 rounded");
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#delay_start_date").hide();
                }
            });
            // delay tile
            $('#delay_time').on('change', function() {
                var dvalue = $(this).val();
                if (dvalue == 'yes') {
                    $("#delay_time_show").show();
                    $(".parent_delay").addClass("border bg-gray-100 rounded");
                } else {
                    $(".parent_delay").removeClass("border bg-gray-100 rounded");
                    $("#delay_time_show").hide();
                }
            });

            // tenure
            $('#tenure').on('change', function() {
                var tenure = $(this).val();
                if (tenure == 'yes') {
                    $("#tenure_wrapper").show();
                    // $(".parent_delay").addClass("border bg-gray-100 rounded");
                } else {
                    // $(".parent_delay").removeClass("border bg-gray-100 rounded");
                    $("#tenure_wrapper").hide();
                }
            });

            $('#employees_qualify').on('change', function() {
                var tenure = $(this).val();
                if (tenure == 'yes') {
                    $("#employees_qualify_details").show();
                    // $(".parent_delay").addClass("border bg-gray-100 rounded");
                } else {
                    // $(".parent_delay").removeClass("border bg-gray-100 rounded");
                    $("#employees_qualify_details").hide();
                }
            });

            $('#entitlement_time_off').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#entitlement_time_off_field").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#entitlement_time_off_field").hide();
                }
            });
            $('#can_take_entitlement_time_off').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#can_take_entitlement_time_off_field").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#can_take_entitlement_time_off_field").hide();
                }
            });

            $('#apply_upper_limit_entitlement_time_off').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#apply_upper_limit_entitlement_time_off_field").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#apply_upper_limit_entitlement_time_off_field").hide();
                }
            });

            $('#prevent_accrual_period').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#prevent_accrual_period_field").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#prevent_accrual_period_field").hide();
                }
            });

            $('#set_leave_amount_immediately').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#set_leave_amount_immediately_field").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#set_leave_amount_immediately_field").hide();
                }
            });

            $('#set_bulk_leave_amount').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#set_bulk_leave_amount_field").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#set_bulk_leave_amount_field").hide();
                }
            });

            $('#carry').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#carry_detail").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#carry_detail").hide();
                }
            });

            $('#borrowed_entitlement_time_off_limit').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#can_take_entitlement_time_off_field2").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#can_take_entitlement_time_off_field2").hide();
                }
            });

            $('#set_bulk_leave_amount').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#set_bulk_leave_amount_wrapper").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#set_bulk_leave_amount_wrapper").hide();
                }
            });

            $('#delay_time_off').on('change', function() {
                var pvalue = $(this).val();
                if (pvalue == '1') {
                    $("#delay_time_off_field").show();
                } else {
                    // $(".parent").removeClass("border bg-gray-100 rounded");
                    $("#delay_time_off_field").hide();
                }
            });

            $("#when_carry_over_expire_div").hide();
            $("#carry_over_expire").on('change', function () {
                let carryOverExpire = $(this).val();
                if (carryOverExpire == 'yes') {
                    $("#when_carry_over_expire_div").show();
                } else {
                    $("#when_carry_over_expire_div").hide();
                }
            })

            $("#carried_over_days_div").hide();
            $("#carry_over").on('change', function () {
                if ($("#carry_over").val() == 'limit') {
                    $("#carried_over_days_div").show();
                } else {
                    $("#carried_over_days_div").hide();
                }
            });
            

        var add_button4 = $('.add_button4');
        var wrapper4 = $('.field_wrapper4');

        var emps = {!! $emps !!};

        var empOptions = '';

        emps.forEach(emp => {
            empOptions += `<option value="${emp.id}">${emp.name}</option>`;
        });

        var html_fields4 = ''+
        '<tr class="item3">'+
        '<td><select class="form-control selected_employee" name="employee" id="">'+
        empOptions+
        '</select></td>'+
        '<td><input type="number"  class="form-control extra_day_for_employee" placeholder="Days"></td>'+
        '<td> <a href="javascript:void(0);" class="remove_button2 btn btn-sm btn-danger"><i class="fa fa-minus"></i></a> </td>' +
        '</tr>';

        var var4 = 1;

        $(document).on('click', '.add_button4', function() {
            if (varEdit3 < max_field) {
                varEdit3++;
                $(this).closest('.field_wrapper4').append(html_fields4);
            }
        });

        $(document).on('click', '.remove_button4', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            varEdit3--;
        });

            // notice_when_booking
            $('#notice_when_booking').on('change', function() {
                var booking = $(this).val();
                if (booking == 'yes') {
                    $("#notice_when_booking_details").show();
                    // $(".parent_delay").addClass("border bg-gray-100 rounded");
                } else {
                    // $(".parent_delay").removeClass("border bg-gray-100 rounded");
                    $("#notice_when_booking_details").hide();
                }
            });

            // policy_wording
            $('#policy_wording').on('change', function() {
                var word = $(this).val();
                if (word == 'specify-wording') {
                    $("#policy-word").show();
                    // $(".parent_delay").addClass("border bg-gray-100 rounded");
                } else {
                    // $(".parent_delay").removeClass("border bg-gray-100 rounded");
                    $("#policy-word").hide();
                }
            });

            // toggle
            $('#collapse1').click(function() {
                $("i", this).toggleClass("fa-plus fa-minus");
            });
            $('#collapse2').click(function() {
                $("i", this).toggleClass("fa-minus fa-plus");
            });
            $('#collapse3').click(function() {
                $("i", this).toggleClass("fa-minus fa-plus");
            });
        });



        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Preview";
                // document.getElementById("nextBtn").type = "Submit";

            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            
            // Exit the function if any field in the current tab is invalid:
            var submit = false
            if(currentTab < x.length - 1 || n == -1 ){
                if (n == 1 && !validateForm()) return false;
                x[currentTab].style.display = "none";
                currentTab = currentTab + n;
            }else{
                submit = true;
            }
            // Hide the current tab:
           
            if(submit){
                getAllData()
            }else{
                // Increase or decrease the current tab by 1:
                // if you have reached the end of the form... :
           
                if (currentTab >= x.length) {
                    //...the form gets submitted:
                    document.getElementById("regForm").submit();
                    return false;
                }
                // Otherwise, display the correct tab:
                showTab(currentTab);
            }
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            y1 = x[currentTab].getElementsByTagName("select");

            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // console.log(y[i].className);
                    // and set the current valid status to false:
                        // var employees_qualify = $('#employees_qualify').value;
                        // if (employees_qualify == 'yes') {
                        //     // alert('yes', x);
                        //     valid = false;
                        // } else {
                        //     // alert('no', x);
                        //     valid = true;
                        // }
                        valid = false;
                }
                
            }

            for (i = 0; i < y1.length; i++) {
                // If a field is empty...
                if (y1[i].value == "") {
                    // add an "invalid" class to the field:
                    y1[i].className += " invalid";
                    // console.log(y[i].className);
                    // and set the current valid status to false:
                    valid = false;
                }
                
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                if(document.getElementsByClassName("step").length  != currentTab){
                    document.getElementsByClassName("step")[currentTab].className += " finish";
                }
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:

            if(x.length > n){
             x[n].className += " active";
            }
            //   tenure
            // var max_group = 5;
            // var add_group = $('.add_group');
            // var group_wrapper = $('.group_wrapper');

        }

        function getAllData(n) {
            //id
            var measure = $('#measure');
            var title = $('#title');
            var days = $('#days');
            var employees_qualify = $('#employees_qualify');
            var requesting_time = $('#requesting_time');
            var value_round = $('#value_round');
            var date_join = $('#date_join');
            var specific_date = $('#specific_date');
            var delay_time = $('#delay_time');
            var month_delay = $('#month_delay');
            var tenure = $('#tenure');
            var carry = $('#carry');
            var policy = $('#policy');
            var notice_when_booking = $('#notice_when_booking');
            var approves = $('#approves');
            var notified = $('#notified');
            var carry_over_expire = $('#carry_over_expire');
            var When_carry_over_expire = $('#When_carry_over_expire');
            var color = $('#color');
            var policy_wording = $('#policy_wording');
            var carry_over = $('#carry_over');
           
            
            var entitlement_time_off = $('#entitlement_time_off');
            var when_entitlement_time_off = $('#when_entitlement_time_off');
            var how_entitlement_time_off = $('#how_entitlement_time_off');
            var can_take_entitlement_time_off = $('#can_take_entitlement_time_off');
            var borrowed_entitlement_time_off = $('#borrowed_entitlement_time_off');
            var show_dashboard_balance = $('#show_dashboard_balance');
            var apply_upper_limit_entitlement_time_off = $('#apply_upper_limit_entitlement_time_off');
            var borrowed_entitlement_time_off = $('#borrowed_entitlement_time_off');
            var prevent_accrual_period = $('#prevent_accrual_period');
            var prevent_accrual_period_field = $('#prevent_accrual_period_field');
            var set_leave_amount_immediately = $('#set_leave_amount_immediately');
            var set_leave_amount_immediately_specify = $('#set_leave_amount_immediately_specify');
            var set_bulk_leave_amount = $('#set_bulk_leave_amount');
            var borrowed_entitlement_time_off_limit = $('#borrowed_entitlement_time_off_limit');
            var set_bulk_leave_month = $('#set_bulk_leave_month');
            var set_bulk_leave_days = $('#set_bulk_leave_days');
            var delay_time_off = $('#delay_time_off');
            var delay_time_off_month = $('#delay_time_off_month');


            //class
            var selected_employee =  document.getElementsByClassName('selected_employee');
            var extra_day_for_employee = document.getElementsByClassName('extra_day_for_employee');

            var tenure_years_service = document.getElementsByClassName('tenure_years_service');
            var tenure_additional_days = document.getElementsByClassName('tenure_additional_days');

            var booking_notice_requested_days = document.getElementsByClassName('booking_notice_requested_days');
            var booking_notice_days = document.getElementsByClassName('booking_notice_days');

            //name
            var leave_valid = $("input[name='leave_valid']:checked");
            var annual_allowance_exceeded = $('input[name="annual_allowance_exceeded"]');
            var more_than_accrued = $('input[name="more_than_accrued"]');
            var notice_given = $('input[name="notice_given"]');
            var probation_period = $('input[name="probation_period"]');
            var blackout_day = $('input[name="blackout_day"]');

            var tenure_award = $('#tenure_award');
            var soon_employees_take_leave = $('#soon_employees_take_leave');
            var bulk_leave_after_month = $("#bulk_leave_after_month");
            var when_entitlement_time_off_at = $("#when_entitlement_time_off_at");
            var borrowed_entitlement_time_off_accrual_cap = $("#borrowed_entitlement_time_off_accrual_cap");
            var carried_over_days = $("#carried_over_days");



            var empObj = [];
            var tenureObj = [];
            var NoticeBookingObj = [];


            for (let i = 0; i < selected_employee.length; i++) {
                empObj.push({
                    employee_id:selected_employee[i].value,
                    days:extra_day_for_employee[i].value,
                });
            }

            for (let i = 0; i < booking_notice_requested_days.length; i++) {
                NoticeBookingObj.push({
                    requested_days:booking_notice_requested_days[i].value,
                    days:booking_notice_days[i].value,
                });
            }

            for (let i = 0; i < tenure_years_service.length; i++) {
                tenureObj.push({
                    year_service:tenure_years_service[i].value,
                    additional_days:tenure_additional_days[i].value,
                });
            }

            var req = {

                measure : measure.val() ?? 'NA',
                title : title.val() ?? 'NA',
                days : days.val() ?? 'NA',
                employees_qualify : employees_qualify.val() ?? 'NA',
                requesting_time : requesting_time.val() ?? 'NA',
                value_round : value_round.val() ?? 'NA',
                date_join : date_join.val() ?? 'NA',
                specific_date : specific_date.val() ?? 'NA',
                delay_time : delay_time.val() ?? 'NA',
                month_delay : month_delay.val() ?? 'NA',
                tenure : tenure.val() ?? 'NA',
                carry : carry.val() ?? 'NA',
                policy : policy.val() ?? 'NA',
                notice_when_booking : notice_when_booking.val() ?? 'NA',
                approves : approves.val() ?? 'NA',
                notified : notified.val() ?? 'NA',
                carry_over_expire : carry_over_expire.val() ?? 'NA',
                When_carry_over_expire : When_carry_over_expire.val() ?? 'NA',
                color : color.val() ?? 'NA',
                policy_wording : policy_wording.val() ?? 'NA',
                annual_allowance_exceeded : annual_allowance_exceeded.val() ?? 'NA',
                more_than_accrued : more_than_accrued.val() ?? 'NA',
                notice_given : notice_given.val() ?? 'NA',
                probation_period : probation_period.val() ?? 'NA',
                blackout_day : blackout_day.val() ?? 'NA',
                entitlement_time_off : entitlement_time_off.val() ?? 'NA',
                when_entitlement_time_off : when_entitlement_time_off.val() ?? 'NA',
                how_entitlement_time_off : how_entitlement_time_off.val() ?? 'NA',
                can_take_entitlement_time_off : can_take_entitlement_time_off.val() ?? 'NA',
                borrowed_entitlement_time_off : borrowed_entitlement_time_off.val() ?? 'NA',
                show_dashboard_balance : show_dashboard_balance.val() ?? 'NA',
                apply_upper_limit_entitlement_time_off : apply_upper_limit_entitlement_time_off.val() ?? 'NA',
                borrowed_entitlement_time_off : borrowed_entitlement_time_off.val() ?? 'NA',
                prevent_accrual_period : prevent_accrual_period.val() ?? 'NA',
                prevent_accrual_period_field : prevent_accrual_period_field.val() ?? 'NA',
                set_leave_amount_immediately : set_leave_amount_immediately.val() ?? 'NA',
                set_leave_amount_immediately_specify : set_leave_amount_immediately_specify.val() ?? 'NA',
                set_bulk_leave_amount : set_bulk_leave_amount.val() ?? 'NA',
                borrowed_entitlement_time_off_limit : borrowed_entitlement_time_off_limit.val() ?? 'NA',
                set_bulk_leave_month : set_bulk_leave_month.val() ?? 'NA',
                set_bulk_leave_days : set_bulk_leave_days.val() ?? 'NA',
                leave_valid:leave_valid.val() ?? 'NA',
                delay_time_off : delay_time_off.val() ?? 'NA',
                delay_time_off_month : delay_time_off_month.val() ?? 'NA',
                empObj : empObj,
                tenureObj : tenureObj,
                NoticeBookingObj : NoticeBookingObj,
                carry_over: carry_over.val() ?? 'NA',
                tenure_award: tenure_award.val() ?? 'NA',
                soon_employees_take_leave: soon_employees_take_leave.val(),
                bulk_leave_after_month: bulk_leave_after_month.val(),
                when_entitlement_time_off_at: when_entitlement_time_off_at.val(),
                borrowed_entitlement_time_off_accrual_cap: borrowed_entitlement_time_off_accrual_cap.val(),
                carried_over_days: carried_over_days.val()
            }

            let leave_start_date = '';
            if (date_join == 'specific_date') {
                leave_start_date = $("#specific_date").val()
            } else {
                leave_start_date = "Employee Joining Anniversary";
            }

            let bulk_amount_leave = '';
            if ($('#set_bulk_leave_amount').val() == 'yes') {
                bulk_amount_leave = $('#tenure_years_service').val();
            } else {
                bulk_amount_leave = 0;
            }

            let carryValue = '';
            if ($("#carry").val() == "1") {
                carryValue = 'Yes';
            } else {
                carryValue = 'No';
            }

            // console.log(measure);
            // $('#preview').html(JSON.stringify(req));

            var htmlpreview = '<div class="row">'+
                        '<div class="col-md-12">'+

                            '<div class="row main-row">'+
                                '<div class="col-md-12">'+
                                    '<h6>'+req["title"]+'</h6>'+
                                '</div>'+
                                '<div class="col-md-6 border-right">'+
                                    '<p>Leave Entitelment :- <strong><b> '+req["days"]+' </b></strong></p>'+
                                    '<p>Leave valid for 3 years :- <strong><b> '+req["leave_valid"]+' </b></strong></p>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<p>Leave measurement unit :- <strong><b> '+req["measure"]+' </b></strong></p>'+
                                    '<p>Minimum Time Off :- <strong><b> '+req["requesting_time"]+' </b></strong></p>'+
                                '</div>'+
                            '</div>'+

                            '<div class="row main-row">'+
                                '<div class="col-md-12">'+
                                    '<h6>Leave Calculation </h6>'+
                                '</div>'+
                                '<div class="col-md-6 border-right">'+
                                    '<p>Start Date :- <strong><b>'+leave_start_date+'</b></strong></p>'+
                                    '<p>Increase in allownce with tenure :- <strong><b> '+req["tenure"]+' </b></strong></p>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<p>Employees based extra allowance :- <strong><b>'+req['employees_qualify']+'</b></strong></p>'+
                                '</div>'+
                            '</div>'+

                            '<div class="row main-row">'+
                                '<div class="col-md-12">'+
                                    '<h6>Leave  Approval </h6>'+
                                '</div>'+
                                '<div class="col-md-6 border-right">'+
                                    '<p>Should requests within policy still be routed for approval :- <strong><b>'+req["policy"]+' </b></strong></p>'+
                                    '<p>Who will approve Leave :- <strong><b> '+who_approves+' </b></strong></p>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<p>Do Employee Need give certain Notice time :- <strong><b> ' +req["notice_when_booking"]+' </b></strong></p>'+
                                    '<p>who will be notified for leave :- <strong><b> '+req["notified"]+' </b></strong></p>'+
                                '</div>'+
                            '</div>'+

                            '<div class="row main-row">'+
                                '<div class="col-md-12">'+
                                    '<h6>Leave  Accural </h6>'+
                                '</div>'+
                                '<div class="col-md-6 border-right">'+
                                    '<p>Time off entitlement accrued :- <strong><b> '+req["when_entitlement_time_off"]+' </b></strong></p>'+
                                    '<p>'+req["how_entitlement_time_off"]+'</p>'+
                                    '<p>upper limit on how much time off may be accrued :- <strong><b>'+req["borrowed_entitlement_time_off"]+' days</b></strong> </p>'+
                                '</div>'+
                                '<div class="col-md-6">'
                                    +'<p>can employees take time off before they have accrued it :- <strong><b> '+can_take_entitlement_time_off_show+' </b></strong></p>'+
                                    '<p>Borowed limit :- <strong><b> '+req["borrowed_entitlement_time_off"]+' days </b></strong></p>'+
                                    '<p>Prevent accrual for a period following the employees hire date :- <strong><b> '+bulk_amount_leave+'</b></strong></p>'+
                                '</div>'+
                            '</div>'+

                            '<div class="row main-row">'+
                                '<div class="col-md-12">'+
                                    '<h6>Leave  Approval </h6>'+
                                '</div>'+
                                '<div class="col-md-6 border-right">'+
                                    '<p>Can employees carry over unused time off :- <strong><b>  '+carryValue+' </b></strong></p>'+
                                    '<p>Carry forward :- <strong><b>'+req["carry_over"]+'</b></strong></p>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<p>Carry Forward Expire over unused time off :- <strong><b> '+req["carry_over_expire"]+' </b></strong></p>'+
                                    '<p>When dose Carry Forward Expire :- <strong><b> '+req["When_carry_over_expire"] ?? 0 +'months after the end of the time off year </b></strong></p>'+
                                '</div>'+
                            '</div>'+

                        '</div>'+
                    '</div>';

            // $('#preview').html(JSON.stringify(req));
            $('#preview').html(htmlpreview);
            $('#dataInput').val(JSON.stringify(req));

            $('#previewTab').show();
            $('#formTabs').hide();

        }

        function backToEdit() {
            $('#previewTab').hide();
            $('#formTabs').show();
        }

    </script>
@endsection
