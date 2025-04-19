<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeaveType extends Model
{
    protected $fillable = [
        'title',
        'days',
        'created_by',
        'measure'
    ];

    public function employees_qualifies()
    {
        return $this->hasMany('App\Models\employeesQualify', 'leave_type_id', 'id');
    }

    public function tenure_in_leaves()
    {
        return $this->hasMany('App\Models\TenureInLeave', 'leave_type_id', 'id');
    }

    public function request_notices()
    {
        return $this->hasMany('App\Models\RequestNotice', 'leave_type_id', 'id');
    }

    public function checkLeaveEligibilty($startDate, $endDate = null)
    {
        $startDate = Carbon::parse($startDate);
        if ($endDate) {
            $endDate = Carbon::parse($endDate);
        }
        $today = today();
        if ($endDate) {
            $totalLeaveDays = $startDate->diffInDays($endDate)+1;
        } else {
            $totalLeaveDays = 1;
        }
        $tenureInLeaves = RequestNotice::where('leave_type_id', $this->id)->where('requested_days', '<', $totalLeaveDays)->orderByDesc('requested_days')->first();
        if ($tenureInLeaves) {
            if ($today->diffInDays($startDate) >= $tenureInLeaves->days) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
}
