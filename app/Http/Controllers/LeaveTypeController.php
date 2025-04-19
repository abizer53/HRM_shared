<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Leave Type'))
        {
            $leavetypes = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('leavetype.index', compact('leavetypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {

        if(\Auth::user()->can('Create Leave Type'))
        {
            return view('leavetype.create-leave');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Leave Type'))
        {

            // $validator = \Validator::make(
            //     $request->all(), [
            //     'title' => 'required',
            //     'days' => 'required',
            // ]
            // );

        //    return json_decode($request->data);
            $data  = json_decode($request->data);

            // if($validator->fails())
            // {
            //     $messages = $validator->getMessageBag();

            //     return redirect()->back()->with('error', $messages->first());
            // }

            $leavetype             = new LeaveType();            
            $leavetype->created_by = \Auth::user()->creatorId();
            $leavetype->measure = $data->measure;
            $leavetype->title = $data->title;
            $leavetype->days = $data->days;
            $leavetype->employees_qualify = $data->employees_qualify;
            $leavetype->requesting_time = $data->requesting_time;
            $leavetype->value_round = $data->value_round;
            $leavetype->date_join = $data->date_join;
            $leavetype->specific_date = $data->specific_date;
            $leavetype->delay_time = $data->delay_time;
            $leavetype->month_delay = $data->month_delay;
            $leavetype->tenure = $data->tenure;
            $leavetype->carry = $data->carry;
            $leavetype->policy = $data->policy;
            $leavetype->notice_when_booking = $data->notice_when_booking;
            $leavetype->approves = $data->approves;
            $leavetype->notified = $data->notified;
            $leavetype->carry_over_expire = $data->carry_over_expire;
            $leavetype->When_carry_over_expire = $data->When_carry_over_expire;
            $leavetype->color = $data->color;
            $leavetype->policy_wording = $data->policy_wording;
            $leavetype->annual_allowance_exceeded = $data->annual_allowance_exceeded;
            $leavetype->more_than_accrued = $data->more_than_accrued;
            $leavetype->notice_given = $data->notice_given;
            $leavetype->probation_period = $data->probation_period;
            $leavetype->blackout_day = $data->blackout_day;
            $leavetype->entitlement_time_off = $data->entitlement_time_off;
            $leavetype->when_entitlement_time_off = $data->when_entitlement_time_off;
            $leavetype->how_entitlement_time_off = $data->how_entitlement_time_off;
            $leavetype->can_take_entitlement_time_off = $data->can_take_entitlement_time_off;
            $leavetype->borrowed_entitlement_time_off = $data->borrowed_entitlement_time_off;
            $leavetype->show_dashboard_balance = $data->show_dashboard_balance;
            $leavetype->apply_upper_limit_entitlement_time_off = $data->apply_upper_limit_entitlement_time_off;
            $leavetype->prevent_accrual_period = $data->prevent_accrual_period;
            $leavetype->prevent_accrual_period_field  = $data->prevent_accrual_period_field; 
            $leavetype->set_leave_amount_immediately = $data->set_leave_amount_immediately;
            $leavetype->set_leave_amount_immediately_specify = $data->set_leave_amount_immediately_specify;
            $leavetype->set_bulk_leave_amount = $data->set_bulk_leave_amount;
            $leavetype->borrowed_entitlement_time_off_limit = $data->borrowed_entitlement_time_off_limit;
            $leavetype->set_bulk_leave_month = $data->set_bulk_leave_month;
            $leavetype->set_bulk_leave_days = 'NA';
            $leavetype->leave_valid = $data->leave_valid;
            $leavetype->delay_time_off = $data->delay_time_off;
            $leavetype->delay_time_off_month = $data->delay_time_off_month;
            $leavetype->carry_over = $data->carry_over;
            $leavetype->set_bulk_leave_month = $data->bulk_leave_after_month;
            $leavetype->when_entitlement_time_off_at = $data->when_entitlement_time_off_at;
            $leavetype->borrowed_entitlement_time_off_accrual_cap = $data->borrowed_entitlement_time_off_accrual_cap;
            $leavetype->carried_over_days = $data->carried_over_days;
            $leavetype->save();

            foreach ($data->empObj as $key => $emp) {
                $leavetype->employees_qualifies()->create( (array) $emp);
            }
            foreach ($data->tenureObj as $key => $tenure) {
                $leavetype->tenure_in_leaves()->create((array) $tenure);
            }
            foreach ($data->NoticeBookingObj as $key => $notice) {
                $leavetype->request_notices()->create((array) $notice);
            }

            return redirect()->route('leavetype.index')->with('success', __('LeaveType  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(LeaveType $leavetype)
    {
        return redirect()->route('leavetype.index');
    }

    public function edit(LeaveType $leavetype)
    {
        if(\Auth::user()->can('Edit Leave Type'))
        {
            if($leavetype->created_by == \Auth::user()->creatorId())
            {

                return view('leavetype.edit', compact('leavetype'));
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

    public function update(Request $request, LeaveType $leavetype)
    {
        if(\Auth::user()->can('Edit Leave Type'))
        {
            if($leavetype->created_by == \Auth::user()->creatorId())
            {
                $data  = json_decode($request->data);
                
                $leavetype->measure = $data->measure;
                $leavetype->title = $data->title;
                $leavetype->days = $data->days;
                $leavetype->employees_qualify = $data->employees_qualify;
                $leavetype->requesting_time = $data->requesting_time;
                $leavetype->value_round = $data->value_round;
                $leavetype->date_join = $data->date_join;
                $leavetype->specific_date = $data->specific_date;
                $leavetype->delay_time = $data->delay_time;
                $leavetype->month_delay = $data->month_delay;
                $leavetype->tenure = $data->tenure;
                $leavetype->carry = $data->carry;
                $leavetype->policy = $data->policy;
                $leavetype->notice_when_booking = $data->notice_when_booking;
                $leavetype->approves = $data->approves;
                $leavetype->notified = $data->notified;
                $leavetype->carry_over_expire = $data->carry_over_expire;
                $leavetype->When_carry_over_expire = $data->When_carry_over_expire;
                $leavetype->color = $data->color;
                $leavetype->policy_wording = $data->policy_wording;
                $leavetype->annual_allowance_exceeded = $data->annual_allowance_exceeded;
                $leavetype->more_than_accrued = $data->more_than_accrued;
                $leavetype->notice_given = $data->notice_given;
                $leavetype->probation_period = $data->probation_period;
                $leavetype->blackout_day = $data->blackout_day;
                $leavetype->entitlement_time_off = $data->entitlement_time_off;
                $leavetype->when_entitlement_time_off = $data->when_entitlement_time_off;
                $leavetype->how_entitlement_time_off = $data->how_entitlement_time_off;
                $leavetype->can_take_entitlement_time_off = $data->can_take_entitlement_time_off;
                $leavetype->borrowed_entitlement_time_off = $data->borrowed_entitlement_time_off;
                $leavetype->show_dashboard_balance = $data->show_dashboard_balance;
                $leavetype->apply_upper_limit_entitlement_time_off = $data->apply_upper_limit_entitlement_time_off;
                $leavetype->prevent_accrual_period = $data->prevent_accrual_period;
                $leavetype->prevent_accrual_period_field  = $data->prevent_accrual_period_field; 
                $leavetype->set_leave_amount_immediately = $data->set_leave_amount_immediately;
                $leavetype->set_leave_amount_immediately_specify = $data->set_leave_amount_immediately_specify;
                $leavetype->set_bulk_leave_amount = $data->set_bulk_leave_amount;
                $leavetype->borrowed_entitlement_time_off_limit = $data->borrowed_entitlement_time_off_limit;
                $leavetype->set_bulk_leave_month = $data->set_bulk_leave_month;
                $leavetype->set_bulk_leave_days = 'NA';
                $leavetype->leave_valid = $data->leave_valid;
                $leavetype->delay_time_off = $data->delay_time_off;
                $leavetype->delay_time_off_month = $data->delay_time_off_month;
                $leavetype->carry_over = $data->carry_over;
                $leavetype->set_bulk_leave_month = $data->bulk_leave_after_month;
                $leavetype->when_entitlement_time_off_at = $data->when_entitlement_time_off_at;
                $leavetype->borrowed_entitlement_time_off_accrual_cap = $data->borrowed_entitlement_time_off_accrual_cap;
                $leavetype->carried_over_days = $data->carried_over_days;
                $leavetype->save();
            
                if ($data->empObj) {
                    $leavetype->employees_qualifies()->delete();
                    foreach ($data->empObj as $emp) {
                        $leavetype->employees_qualifies()->create( (array) $emp);
                    }
                }
                if ($data->tenureObj) {
                    $leavetype->tenure_in_leaves()->delete();
                    foreach ($data->tenureObj as $tenure) {
                        $leavetype->tenure_in_leaves()->create((array) $tenure);
                    }
                }

                if ($data->NoticeBookingObj) {
                    $leavetype->request_notices()->delete();
                    foreach ($data->NoticeBookingObj as $notice) {
                        $leavetype->request_notices()->create((array) $notice);
                    }
                }

                return redirect()->route('leavetype.index')->with('success', __('LeaveType successfully updated.'));
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

    public function destroy(LeaveType $leavetype)
    {
        if(\Auth::user()->can('Delete Leave Type'))
        {
            if($leavetype->created_by == \Auth::user()->creatorId())
            {
                $leavetype->delete();

                return redirect()->route('leavetype.index')->with('success', __('LeaveType successfully deleted.'));
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
}
