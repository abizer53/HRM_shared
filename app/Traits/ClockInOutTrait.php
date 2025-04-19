<?php

namespace App\Traits;

use App\Models\Utility;
use App\Models\IpRestrict;
use App\Models\AttendanceEmployee;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ClockInOutTrait
{
    public function attendanceSet()
    {
        $settings = Utility::settings();

        if($settings['ip_restrict'] == 'on')
        {
            $userIp = request()->ip();
            $ip     = IpRestrict::where('created_by', Auth::user()->creatorId())->whereIn('ip', [$userIp])->first();
            if(empty($ip))
            {
                return redirect()->back()->with('error', __('this ip is not allowed to clock in & clock out.'));
            }
        }

        $employeeId      = !empty(Auth::user()->employee) ? Auth::user()->employee->id : 0;
        $todayAttendance = AttendanceEmployee::where('employee_id', '=', $employeeId)->where('date', date('Y-m-d'))->first();
        if(empty($todayAttendance))
        {

            $startTime = Utility::getValByName('company_start_time');
            $endTime   = Utility::getValByName('company_end_time');

            $attendance = AttendanceEmployee::orderBy('id', 'desc')->where('employee_id', '=', $employeeId)->where('clock_out', '=', '00:00:00')->first();

            if($attendance != null)
            {
                $attendance            = AttendanceEmployee::find($attendance->id);
                $attendance->clock_out = $endTime;
                $attendance->save();
            }

            $date = date("Y-m-d");
            $time = date("H:i:s");

            //late
            $totalLateSeconds = time() - strtotime($date . $startTime);
            $hours            = floor($totalLateSeconds / 3600);
            $mins             = floor($totalLateSeconds / 60 % 60);
            $secs             = floor($totalLateSeconds % 60);
            $late             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

            $checkDb = AttendanceEmployee::where('employee_id', '=', Auth::user()->id)->get()->toArray();

            // Employee will be clock in if it joins within an hour of starting
            if (!$this->employeeIsLate()) {
                if(empty($checkDb))
                {
                    $employeeAttendance                = new AttendanceEmployee();
                    $employeeAttendance->employee_id   = $employeeId;
                    $employeeAttendance->date          = $date;
                    $employeeAttendance->status        = 'Present';
                    $employeeAttendance->clock_in      = $time;
                    $employeeAttendance->clock_out     = '00:00:00';
                    $employeeAttendance->late          = $late;
                    $employeeAttendance->early_leaving = '00:00:00';
                    $employeeAttendance->overtime      = '00:00:00';
                    $employeeAttendance->total_rest    = '00:00:00';
                    $employeeAttendance->created_by    = Auth::user()->id;

                    $employeeAttendance->save();

                    return redirect()->back()->with('success', __('Employee Successfully Clock In.'));
                }
                foreach($checkDb as $check)
                {


                    $employeeAttendance                = new AttendanceEmployee();
                    $employeeAttendance->employee_id   = $employeeId;
                    $employeeAttendance->date          = $date;
                    $employeeAttendance->status        = 'Present';
                    $employeeAttendance->clock_in      = $time;
                    $employeeAttendance->clock_out     = '00:00:00';
                    $employeeAttendance->late          = $late;
                    $employeeAttendance->early_leaving = '00:00:00';
                    $employeeAttendance->overtime      = '00:00:00';
                    $employeeAttendance->total_rest    = '00:00:00';
                    $employeeAttendance->created_by    = Auth::user()->id;

                    $employeeAttendance->save();

                    return redirect()->back()->with('success', __('Employee Successfully Clock In.'));

                }
            }
        }
    }

    public function employeeIsLate()
    {
        $date = date("Y-m-d");
        $startTime = Utility::getValByName('company_start_time');

        //late
        $totalLateSeconds = time() - strtotime($date . $startTime);
        $hours            = floor($totalLateSeconds / 3600);
        $mins             = floor($totalLateSeconds / 60 % 60);
        $secs             = floor($totalLateSeconds % 60);
        $late             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

        // Employee will be clock in if it joins within an hour of starting
        if ($hours < 1) {
            return false;
        }

        return true;
    }
}
    