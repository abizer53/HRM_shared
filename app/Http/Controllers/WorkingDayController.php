<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkingDay;

class WorkingDayController extends Controller
{
    public function index()
    {
        $workingDay = WorkingDay::first();
        return view('working_days.index')->with(compact('workingDay'));
    }

    public function update(Request $request)
    {
        $workingDay = WorkingDay::first();
        if (!$workingDay) {
            $workingDay = WorkingDay::create();
        }

        info($workingDay->monday);
        $workingDay->monday = $request->monday ? true : false;
        $workingDay->tuesday = $request->tuesday ? true : false;
        $workingDay->wednesday = $request->wednesday ? true : false;
        $workingDay->thursday = $request->thursday ? true : false;
        $workingDay->friday = $request->friday ? true : false;
        $workingDay->saturday = $request->saturday ? true : false;
        $workingDay->sunday = $request->sunday ? true : false;
        $workingDay->save();
        return redirect()->back()->with('success', __('Working days updated successfully.'));
    }
}
