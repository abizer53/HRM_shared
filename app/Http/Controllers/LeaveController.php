<?php

namespace App\Http\Controllers;

use App\Exports\LeaveExport;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Mail\LeaveActionSend;
use App\Models\Utility;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\LeaveDatePickRule;
use App\Traits\LeaveCalculationTrait;
use App\Models\Holiday;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\WorkingDay;
use App\Models\User; 
use App\Models\CarryOver;

class LeaveController extends Controller
{
    use LeaveCalculationTrait;
    
    public function index()
    {

        if(\Auth::user()->can('Manage Leave'))
        {
            $leaves = Leave::where('created_by', '=', \Auth::user()->creatorId())->get();
            if(\Auth::user()->type == 'employee')
            {
                $user     = \Auth::user();
                $employee = Employee::where('user_id', '=', $user->id)->first();
                $leaves   = Leave::where('employee_id', '=', $employee->id)->get();
            }
            else
            {
                $leaves = Leave::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('leave.index', compact('leaves'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Leave'))
        {
            if(Auth::user()->type == 'employee')
            {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
            }
            else
            {
                $employees = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            }
            $leavetypes      = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get();
            $leavetypes_days = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get();

//            dd(Employee::employeeTotalLeave(1));
            return view('leave.create', compact('employees', 'leavetypes', 'leavetypes_days'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Leave'))
        {
            $rules = [
                'leave_type_id' => 'required',
                'leave_reason' => 'required',
                'leave_bases' => 'required'
            ];

            // dd($request->all());
            if ($request->leave_bases == 'single_days') {
                $rules['single_date'] = ['required', new LeaveDatePickRule($request->all())];
            } else if ($request->leave_bases == 'multiple_days') {
                $rules['start_date'] = ['required', new LeaveDatePickRule($request->all())];
                $rules['end_date'] = ['required', new LeaveDatePickRule($request->all())];
            } else if ($request->leave_bases == 'hour_based') {
                $rules['single_date'] = ['required', new LeaveDatePickRule($request->all())];
                $rules['start_time'] = ['required', new LeaveDatePickRule($request->all())];
                $rules['end_time'] = ['required', new LeaveDatePickRule($request->all())];
            }

            $validator = \Validator::make(
                $request->all(), $rules
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $leaveCheck = LeaveType::find($request->leave_type_id);
            
            $setting = Utility::settings();
            try {
                $co_start_time = new DateTime($setting['company_start_time']);
                $co_end_time = new DateTime($setting['company_end_time']);
                $difference = $co_start_time->diff($co_end_time);
                $workingHours = $difference->h + ($difference->i / 60);
            } catch (\Throwable $th) {
                $workingHours = 9;
            }

            if($request->leave_bases == 'hour_based' && 
               (strtotime($request->start_time) <= strtotime($setting['company_start_time']) || 
               strtotime($request->start_time) >= strtotime($setting['company_end_time']))) 
            {

                return redirect()->back()->with('error', __('Please enter a valid start Time.'));
            }

            $start_time = new DateTime($request->start_time);
            $end_time = new DateTime($request->end_time);
            $diff = $start_time->diff($end_time);

            if ($request->leave_bases ==  'hour_based') {
                $days = (($diff->h * 60) + $diff->i)/($workingHours * 60);

                if ($leaveCheck->measure == 'Days') {
                    if ($leaveCheck->requesting_time == 'whole_day') {
                        if ($days < 1) {
                            $days = 1;
                        }
                    } else if ($leaveCheck->requesting_time == 'half_days') {
                        if ($days < 0.5) {
                            $days = 0.5;
                        }
                    } else if ($leaveCheck->requesting_time == '2_hours') {
                        if (2 * 60 > (($diff->h * 60) + $diff->i)) {
                            $days = 2 / $workingHours;
                        }
                    } else if ($leaveCheck->requesting_time == '1_hours') {
                        if (60 > (($diff->h * 60) + $diff->i)) {
                            $days = 1 / $workingHours;
                        }
                    } else if ($leaveCheck->requesting_time == '30_minutes') {
                        if (30 > (($diff->h * 60) + $diff->i)) {
                            $days = 0.5 / $workingHours;
                        }
                    } else if ($leaveCheck->requesting_time == '15_minutes') {
                        if (15 > (($diff->h * 60) + $diff->i)) {
                            $days = 0.25 / $workingHours;
                        }
                    } else if ($leaveCheck->requesting_time == '10_minutes') {
                        if (10 > (($diff->h * 60) + $diff->i)) {
                            $days = (10 / 60) / $workingHours;
                        }
                    } else if ($leaveCheck->requesting_time == '5_minutes') {
                        if (5 > (($diff->h * 60) + $diff->i)) {
                            $days = (5 / 60) / $workingHours;
                        }
                    }
                } else {
                    if ($leaveCheck->requesting_time == 'whole_day') {
                        if ($days < 1) {
                            $days = $workingHours;
                        }
                    } else if ($leaveCheck->requesting_time == 'half_days') {
                        if ($days < 0.5) {
                            $days = 0.5 * $workingHours;
                        }
                    } else if ($leaveCheck->requesting_time == '2_hours') {
                        if (2 * 60 > (($diff->h * 60) + $diff->i)) {
                            $days = 2;
                        }
                    } else if ($leaveCheck->requesting_time == '1_hours') {
                        if (60 > (($diff->h * 60) + $diff->i)) {
                            $days = 1;
                        }
                    } else if ($leaveCheck->requesting_time == '30_minutes') {
                        if (30 > (($diff->h * 60) + $diff->i)) {
                            $days = 0.5;
                        }
                    } else if ($leaveCheck->requesting_time == '15_minutes') {
                        if (15 > (($diff->h * 60) + $diff->i)) {
                            $days = 0.25;
                        }
                    } else if ($leaveCheck->requesting_time == '10_minutes') {
                        if (10 > (($diff->h * 60) + $diff->i)) {
                            $days = (10 / 60);
                        }
                    } else if ($leaveCheck->requesting_time == '5_minutes') {
                        if (5 > (($diff->h * 60) + $diff->i)) {
                            $days = (5 / 60);
                        }
                    } else {
                        $days = $days * $workingHours;
                    }
                }
            } else {

                $workingDay = WorkingDay::first();

                $days = 0;
                for ($i=0; $i < $difference->days ; $i++) { 
                    
                    $timestamp = strtotime($request->start_time);
                    $timestamp = $timestamp + ($i*86400);
                    $day = $day = date('D', $timestamp);

                    if($workingDay[strtolower($day)] == 1){
                        $day++;
                    }

                }

                // $days = $difference->days + 1;
            }

            if ($request->has('employee_id')) {
                $employee = Employee::find($request->employee_id);
            } else {
                $employee = Employee::where('user_id', '=', auth()->user()->id)->first();
            }

            $leave    = new Leave();
            if(\Auth::user()->type == "employee")
            {
                $leave->employee_id = $employee->id;
            }
            else
            {
                $leave->employee_id = $request->employee_id;
            }
            
            $leaveData =  $this->leaveCalculation($request->leave_type_id, $leave->employee_id);

            $start_date = new DateTime($request->start_date);
            $end_date = new DateTime($request->end_date);
            $diff = $start_date->diff($end_date);

            if ($request->leave_bases == 'single_days') {
                $leave->start_date = $request->single_date;
                $leave->end_date = $request->single_date;
                $leave->start_time = null;
                $leave->end_time = null;
                $leave->total_leave_days = 1;
            } else if ($request->leave_bases == 'multiple_days') {
                $leave->start_date = $request->start_date;
                $leave->end_date = $request->end_date;
                $leave->start_time = null;
                $leave->end_time = null;
                $leave->total_leave_days = $diff->days+1;
            } else if ($request->leave_bases == 'hour_based') {
                $leave->start_date = $request->single_date;
                $leave->end_date = $request->single_date;
                $leave->start_time = $request->start_time;
                $leave->end_time = $request->end_time;
                $leave->total_leave_days = round($days, 2);
            }


            //leave eligibilty check
            $cariedOverConsiderd = 0;
            if ($leaveCheck->carry_over_expire == 'no') {
                $carryOver = CarryOver::where(['employee_id' => $leave->employee_id, 'leave_type_id' => $leaveCheck->id])->first();
                if ($carryOver) {
                    $cariedOverConsiderd = $carryOver->remaining;
                }
            }
            
            if($leaveCheck->can_take_entitlement_time_off == 1){
                if($leaveCheck->borrowed_entitlement_time_off_limit = '0'){
                    $accrued_leaves_total = $leaveCheck->entitled_leaves +  $cariedOverConsiderd;
                } else {
                    $accrued_leaves_total = $leaveData["accrued_leaves"] + $cariedOverConsiderd + $leaveCheck->borrowed_entitlement_time_off;
                }
            } else {
	            $accrued_leaves_total = $leaveData["accrued_leaves"] + $cariedOverConsiderd;
            }
            $applied_leave_total = $leaveData["total_leaves_taken"] + $days;
            $entitle_leave_total = $leaveData['entitled_leaves'] + $cariedOverConsiderd;

            //set leave status
            $leave->status = 'Pending';
            $count = 0;

            if ($leaveCheck->annual_allowance_exceeded == '0' && $leaveCheck->more_than_accrued == '0' && $leaveCheck->notice_given == '0' && $leaveCheck->probation_period == '0' && $leaveCheck->blackout_day == '0') {
                $leave->status = 'Pending';
            } else {
                if ($leaveCheck->annual_allowance_exceeded == '1') {
                    if ($applied_leave_total > $entitle_leave_total) {
                        return redirect()->back()->with('error', "You are not having sufficent leave left.");
                    }
                } else {
                    if ($applied_leave_total > $entitle_leave_total) {
                        $count = $count + 1;
                    }
                }
                
                if ($leaveCheck->more_than_accrued == '1') {
                    if ($applied_leave_total > $accrued_leaves_total){
                        return redirect()->back()->with('error', "You are not having sufficent leave left.");
                    }
                } else {
                    if ($applied_leave_total > $accrued_leaves_total){
                        $count = $count + 1;
                    }
                }

                if ($leaveCheck->notice_given == '1') {
                    if ($request->leave_bases == 'multiple_days') {
                        if (!$leaveCheck->checkLeaveEligibilty($request->start_date, $request->end_date)) {
                            return redirect()->back()->with('error', "Error: you have not given sufficient notice");
                        }
                    } else {
                        if (!$leaveCheck->checkLeaveEligibilty($request->start_date, null)) {
                            return redirect()->back()->with('error', "Error: you have not given sufficient notice");
                        }
                    }
                } else {
                    if ($request->leave_bases == 'multiple_days') {
                        if (!$leaveCheck->checkLeaveEligibilty($request->start_date, $request->end_date)) {
                            $count = $count + 1;
                        }
                    } else {
                        if (!$leaveCheck->checkLeaveEligibilty($request->start_date, null)) {
                            $count = $count + 1;
                        }
                    }
                }

                if ($leaveCheck->probation_period ==  '1') {
                    if (now()->diff($employee->company_doj) < $leaveCheck->soon_employees_take_leave) {
                        return redirect()->back()->with('error', "You are not eligible for leave.");
                    }
                } else {
                    if (now()->diff($employee->company_doj) < $leaveCheck->soon_employees_take_leave) {
                            $count = $count + 1;
                    }
                }

                if ($leaveCheck->blackout_day ==  '1') {
                    if ($request->leave_bases == 'multiple_days') {
                        $allLeaveDays = CarbonPeriod::create($request->start_date, $request->end_date);
                        foreach ($allLeaveDays as $date) {
                            if (Holiday::where('date', $date)->count() > 0) {
                                // return redirect()->back()->with('error', "Error: Only working days can be selected – Current working days are ");
                            } else {
                                $day = strtolower($date->format('l'));
                                $workingDay = WorkingDay::first()->toArray();
                                // if ($workingDay[$day] == false) {
                                //     return redirect()->back()->with('error', "Error: Only working days can be selected – Current working days are ");
                                // }
                            }
                        }
                    } else {
                        if (Holiday::where('date', $request->single_date)->count()) {
                            return redirect()->back()->with('error', "Error: Only working days can be selected – Current working days are ");
                        } else {
                            $day = strtolower(Carbon::parse($request->single_date)->format('l'));
                            $workingDay = WorkingDay::first()->toArray();
                            if ($workingDay[$day] == false) {
                                return redirect()->back()->with('error', "Error: Only working days can be selected – Current working days are ");
                            }
                        }
                    }
                } else {
                    if ($request->leave_bases == 'multiple_days') {
                        $allLeaveDays = CarbonPeriod::create($request->start_date, $request->end_date);
                        foreach ($allLeaveDays as $date) {
                            if (Holiday::where('date', $date)->count() > 0) {
                                $count = $count + 1;
                            } else {
                                $day = strtolower($date->format('l'));
                                $workingDay = WorkingDay::first()->toArray();
                                if ($workingDay[$day] == false) {
                                    $count = $count + 1;
                                }
                            }
                        }
                    }
                }

                if ($leaveCheck->policy == 'yes' OR $count !== 0) {
                    $leave->status = 'Pending';
                } else {
                    $cariedOverConsiderd = 0;
                    $carryOver = CarryOver::where(['employee_id' => $leave->employee_id, 'leave_type_id' => $leaveCheck->id])->first();
                    if ($leaveCheck->carry_over_expire == 'no' && $carryOver) {
                        $cariedOverConsiderd = $carryOver->remaining;
                    }

                    if ($cariedOverConsiderd != 0) {
                        $days = $leave->total_leave_days;
                        if ($cariedOverConsiderd > $days) {
                            $carreid_over_taken = $carryOver->taken + $days;
                            $carried_over_renmaining =  $carryOver->remaining - $days;
                        }else {
                            $carreid_over_taken = $carryOver->taken + $cariedOverConsiderd;
                            $carried_over_renmaining = 0;
                        }
                        $carryOver->taken = $carreid_over_taken;
                        $carryOver->remaining = $carried_over_renmaining;
                        $carryOver->save();
                    }
                    
                    $leave->status = 'Approved';
                }
            }

            $leave->leave_type_id    = $request->leave_type_id;
            $leave->applied_on       = date('Y-m-d');
            $leave->leave_reason     = $request->leave_reason;
            $leave->remark           = $request->remark;
            $leave->created_by       = \Auth::user()->creatorId();
            
            if ($request->has('employee_id')) {
                $loggedInUser = Employee::find($request->employee_id);
            } else {
                $loggedInUser = Employee::where('user_id', auth()->user()->id)->first();
            }
            
            $approver = $leaveCheck->approves;
            $hr = User::whereHas('employee', function ($e) use ($loggedInUser){
                $e->where(['branch_id' => $loggedInUser->branch_id, 'department_id' => $loggedInUser->department_id]);
            })->whereHas('roles', function ($r) use ($approver){
                $r->where('name', $approver);
            })->first();

            if ($hr) {
                $hr = User::whereHas('employee', function ($e) use ($loggedInUser){
                    $e->where(['branch_id' => $loggedInUser->branch_id]);
                })->whereHas('roles', function ($r) use ($approver){
                    $r->where('name', $approver);
                })->first();
            }
            $leave->approver_id = $hr->id ?? null;
            $leave->save();

            //TBD [SEND EMAIL WHEN LEAVE APPLIED]

            return redirect()->route('leave.index')->with('success', __('Leave  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function leaveTypeCalculation($leave_type_id,$employee_id){

        $employee = Employee::find($employee_id);

        $total_leaves_taken = Leave::where("employee_id",$employee->id)->sum('total_leave_days');

        $leaveType = LeaveType::find($leave_type_id);

        $employees_qualifies = $leaveType->employees_qualifies->where("employee_id",$employee->id)->first();
        $employees_qualifies_days = 0;
        if($employees_qualifies){
            $employees_qualifies_days =  $employees_qualifies->days;  
        }
        
        $today = new DateTime();
        $company_doj = new DateTime($employee->company_doj);
        $difference = $company_doj->diff($today);

        $tenure_in_leaves = $leaveType->tenure_in_leaves->where(['year_service' >= $difference->y ])->sortBy("days")->first();
        $tenure_in_leaves_days = 0;
        if($tenure_in_leaves){
            $tenure_in_leaves_days =  $tenure_in_leaves->days;  
        }
        //  print_r($leaveType->employees_qualifies->toArray());

        $total_leaves = $leaveType->days  + $tenure_in_leaves_days + $employees_qualifies_days;
        $total_leave_left = $total_leaves - $total_leaves_taken;

        
        
        return [
            "id" => $leaveType->id,
            "title" => $leaveType->title,
            "total_leaves_taken" => $total_leaves_taken,
            "total_leave_left" => $total_leave_left,
            "tenure_in_leaves_days" => $tenure_in_leaves_days,
            "employees_qualifies_days" => $employees_qualifies_days,
            "year" => $difference->y,
            "days" => $difference->d,
        ];
    }

    public function employeeLeaveTable(Employee $employee){

        $leaveTypes = LeaveType::all();

        $leaveCal = [];
        foreach ($leaveTypes as $key => $type) {
            $leaveCal[] = $this->leaveTypeCalculation($type->id,$employee->id);
        }

        return $leaveCal;

    }

    public function show(Leave $leave)
    {
        return redirect()->route('leave.index');
    }

    public function edit(Leave $leave)
    {
        if(\Auth::user()->can('Edit Leave'))
        {
            if($leave->created_by == \Auth::user()->creatorId())
            {
                $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $leavetypes = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('title', 'id');

                return view('leave.edit', compact('leave', 'employees', 'leavetypes'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $leave)
    {

        $leave = Leave::find($leave);
        if(\Auth::user()->can('Edit Leave'))
        {
            if($leave->created_by == Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'leave_type_id' => 'required',
                                       'start_date' => 'required',
                                       'end_date' => 'required',
                                       'leave_reason' => 'required',
                                    //    'remark' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $leave->employee_id      = $request->employee_id;
                $leave->leave_type_id    = $request->leave_type_id;
                $leave->start_date       = $request->start_date;
                $leave->end_date         = $request->end_date;
                $leave->total_leave_days = 0;
                $leave->leave_reason     = $request->leave_reason;
                $leave->remark           = $request->remark;

                $leave->save();

                return redirect()->route('leave.index')->with('success', __('Leave successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Leave $leave)
    {
        if(\Auth::user()->can('Delete Leave'))
        {
            if ($leave->status !== 'Approve') {
                if($leave->created_by == \Auth::user()->creatorId())
                {
                    $leave->delete();

                    return redirect()->route('leave.index')->with('success', __('Leave successfully deleted.'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Permission denied.'));
                }
            } else {
                    return redirect()->back()->with('error', __('You can not delete approved leave.'));
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function action($id)
    {
        $leave     = Leave::find($id);
        $employee  = Employee::find($leave->employee_id);
        $leavetype = LeaveType::find($leave->leave_type_id);

        return view('leave.action', compact('employee', 'leavetype', 'leave'));
    }

    public function changeaction(Request $request)
    {

        $leave = Leave::find($request->leave_id);

        $leave->status = $request->status;
        if($leave->status == 'Approval')
        {
            $leaveType = LeaveType::find($leave->leave_type_id);
            $cariedOverConsiderd = 0;
            $carryOver = CarryOver::where(['employee_id' => $leave->employee_id, 'leave_type_id' => $leaveType->id])->first();
            if ($leaveType->carry_over_expire == 'no' && $carryOver) {
                $cariedOverConsiderd = $carryOver->remaining;
            }

            if ($cariedOverConsiderd != 0) {
                $days = $leave->total_leave_days;
                if ($cariedOverConsiderd > $days) {
                    $carreid_over_taken = $carryOver->taken + $days;
                    $carried_over_renmaining =  $carryOver->remaining - $days;
                }else {
                    $carreid_over_taken = $carryOver->taken + $cariedOverConsiderd;
                    $carried_over_renmaining = 0;
                }
                $carryOver->taken = $carreid_over_taken;
                $carryOver->remaining = $carried_over_renmaining;
                $carryOver->save();
            }

            if ($leave->approver_id) {
                if (Leave::where(['approver_id' => auth()->user()->id, 'id' => $leave->id])->first()) {
                    // $startDate               = new \DateTime($leave->start_date);
                    // $endDate                 = new \DateTime($leave->end_date);
                    // $total_leave_days        = $startDate->diff($endDate)->days;
                    // $leave->total_leave_days = $total_leave_days;
                    $leave->status           = 'Approve';
                } else {
                    return redirect()->route('leave.index')->with('error', __('You can not approve leave.'));
                }
            } else {
                // $startDate               = new \DateTime($leave->start_date);
                // $endDate                 = new \DateTime($leave->end_date);
                // $total_leave_days        = $startDate->diff($endDate)->days;
                // $leave->total_leave_days = $total_leave_days;
                $leave->status           = 'Approve';
            }
        } elseif ($leave->status == 'Reject') {
            $leave->status = 'Reject';
        }

        $leave->save();

         // twilio  
         $setting = Utility::settings(\Auth::user()->creatorId());
         $emp = Employee::find($leave->employee_id);
         if (isset($setting['twilio_leave_approve_notification']) && $setting['twilio_leave_approve_notification'] == 1) {
           $msg = __("Your leave has been").' '.$leave->status.'.';
            
                    
             Utility::send_twilio_msg($emp->phone,$msg);
         }

        $setings = Utility::settings();
        if($setings['leave_status'] == 1)
        {
            $employee     = Employee::where('id', $leave->employee_id)->where('created_by', '=', \Auth::user()->creatorId())->first();
            $leave->name  = !empty($employee->name) ? $employee->name : '';
            $leave->email = !empty($employee->email) ? $employee->email : '';
            try
            {
                Mail::to($leave->email)->send(new LeaveActionSend($leave));
            }
            catch(\Exception $e)
            {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

            return redirect()->route('leave.index')->with('success', __('Leave status successfully updated.') . (isset($smtp_error) ? $smtp_error : ''));

        }

        return redirect()->route('leave.index')->with('success', __('Leave status successfully updated.'));
    }

    public function jsoncount(Request $request)
    {
//        $leave_counts = LeaveType::select(\DB::raw('COALESCE(SUM(leaves.total_leave_days),0) AS total_leave, leave_types.title, leave_types.days,leave_types.id'))->leftjoin(
//            'leaves', function ($join) use ($request){
//            $join->on('leaves.leave_type_id', '=', 'leave_types.id');
//            $join->where('leaves.employee_id', '=', $request->employee_id);
//        }
//        )->groupBy('leaves.leave_type_id')->get();

        $leave_counts = LeaveType::select(\DB::raw('COALESCE(SUM(leaves.total_leave_days),0) AS total_leave, leave_types.title, leave_types.days,leave_types.id'))
                                 ->leftjoin('leaves', function ($join) use ($request){
            $join->on('leaves.leave_type_id', '=', 'leave_types.id');
            $join->where('leaves.employee_id', '=', $request->employee_id);
        }
        )->groupBy('leaves.leave_type_id')->get();

        return $leave_counts;

    }
     public function export(Request $request)
    {
        $name = 'Leave' . date('Y-m-d i:h:s');
        $data = Excel::download(new LeaveExport(), $name . '.xlsx'); ob_end_clean();

        return $data;
    }

    public function fetchLeaveType($leaveTypeId)
    {
        $leaveType = LeaveType::find($leaveTypeId);
        $employees_qualifies = $leaveType->employees_qualifies;
        $tenure_in_leaves = $leaveType->tenure_in_leaves;
        $request_notices = $leaveType->request_notices;
        $data = collect([$leaveType, $employees_qualifies, $tenure_in_leaves, $request_notices]);
        return response()->json($data);
    }
}
