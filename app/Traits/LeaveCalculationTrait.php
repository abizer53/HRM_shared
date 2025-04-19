<?php

namespace App\Traits;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use Carbon\Carbon;

trait LeaveCalculationTrait
{
    public function leaveCalculation($leave_type_id,$employee_id){

        $employee = Employee::find($employee_id);

        $leaveType = LeaveType::find($leave_type_id);

        if ($leaveType->date_join == 'specific_date') {
            $date = $leaveType->specific_date;
        } else {
            $date = $employee->company_doj;
            $diff = now()->diff($date);
            if ($diff->y >= 1) {
                if ($leaveType->valid == 'yes'){
                    $n = (int) $diff->y / 3;
                    $date = Carbon::parse($date)->addYear(($diff->y)*$n);
                } else{
                    $date = Carbon::parse($date)->addYear($diff->y);
                }
            }
        }
        $total_leaves_taken = Leave::where(["employee_id" => $employee->id, "status" => "Approve"])->where('created_at', ">", $date)->sum('total_leave_days');

        $employees_qualifies = $leaveType->employees_qualifies->where("employee_id",$employee->id)->first();
        $employees_qualifies_days = 0;
        if($employees_qualifies){
            $employees_qualifies_days =  $employees_qualifies->days;  
        }
        
        $today = new \DateTime();
        $specific_date = null;
        $company_doj = new \DateTime($employee->company_doj);
        $difference = $company_doj->diff($today);
        $tenure_in_leaves_days = 0;
    
        if ($leaveType->tenure == 'yes') {
            if ($leaveType->date_join == "specific_date") {
                $specific_date = new \DateTime($leaveType->specific_date);
                $tenure_year = $difference->y;
                if($leaveType->tenure_award == "pro-rated"){
                   $specific_date_to_doj_diff = $specific_date->diff($company_doj);
                   if ($specific_date_to_doj_diff->d > 0 || $specific_date_to_doj_diff->m > 0) {
                        $tenure_year = ($specific_date->format('y') - $company_doj->format('y')) + 1;
                   } else {
                        $tenure_year = $specific_date->format('y') - $company_doj->format('y');
                   }
                }else if($leaveType->tenure_award == "year_start" && $specific_date){
                    $difference = $specific_date->diff($today);
                    if( $difference->m > 6 ){
                        $tenure_year = $today->format('y') - $company_doj->format('y');
                    }else{
                        $tenure_year = $today->format('y') - ($company_doj->format('y') + 1);
                    }
                } else {
                    $tenure_year = $today->format('y') - $company_doj->format('y');
                }
                $tenure_in_leaves_days = $leaveType->tenure_in_leaves->where('year_service' ,'<=', $tenure_year)->sum('additional_days');
            } else{
                $tenure_in_leaves_days = $leaveType->tenure_in_leaves->where('year_service' ,'<=', $difference)->sum('additional_days');
            }
        }

        //  print_r($leaveType->employees_qualifies->toArray());
        $total_leaves = $leaveType->days  + $tenure_in_leaves_days + $employees_qualifies_days;
        $entitled_leaves = $total_leaves;

        // Accrued
        if($leaveType->entitlement_time_off){
            if ($leaveType->set_bulk_leave_amount == 'yes') {
                if (($difference->m + ($difference->y*12)) <= $leaveType->set_bulk_leave_month) {
                    $total_leaves = $difference->m + ($difference->y*12);
                } else {
                    $total_leaves = $entitled_leaves;
                }
            } else {
                $delay_month = 0;
                if ($leaveType->delay_time == 'yes') {
                    $delay_month = $difference->y < 1 ? $leaveType->delay_time_off_month : 0; 
                }
                $leave_valid_for_month = $leaveType->leave_valid ? 36 : 12;

                if($leaveType->when_entitlement_time_off == 'monthly'){
                    $accrued_leave_per_period = $total_leaves/ $leave_valid_for_month;
                    $period_diff = ($difference->y*12) + $difference->m - $delay_month;
                }else{
                    $accrued_leave_per_period = $total_leaves/$leave_valid_for_month * 3;
                    $period_diff = (($difference->y*12) + $difference->m - $delay_month) /3 ;
                }
    
                if($leaveType->when_entitlement_time_off_at == 'start'){
                    $period_diff = (int) ($period_diff + 1 < 0 ? 0 :$period_diff + 1);
                    $total_leaves = $period_diff*$accrued_leave_per_period;
                }else{
                    $period_diff = (int) ($period_diff < 0 ? 0 :$period_diff);
                    $total_leaves = ($period_diff)*$accrued_leave_per_period;
                }
            }
        }

        $total_leave_left = $total_leaves - $total_leaves_taken;
        
        return [
            "id" => $leaveType->id,
            "title" => $leaveType->title,
            "show_dashboard_balance" => $leaveType->show_dashboard_balance,
            "accrued_leaves" => $total_leaves,
            "entitled_leaves" => $entitled_leaves,
            "total_leaves_taken" => $total_leaves_taken,
            "total_leave_left" => $total_leave_left,
            "tenure_in_leaves_days" => $tenure_in_leaves_days,
            "employees_qualifies_days" => $employees_qualifies_days,
            "year" => $difference->y,
            "days" => $difference->d,
        ];
    }
}
