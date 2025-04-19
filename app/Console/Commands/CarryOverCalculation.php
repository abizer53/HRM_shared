<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Console\Command;
use App\Traits\LeaveCalculationTrait;
use App\Models\CarryOver;
use Carbon\Carbon;

class CarryOverCalculation extends Command
{
    use LeaveCalculationTrait;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carryover:renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It renew all carry over of employees.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $leaveTypes = LeaveType::where(['date_join' => 'specific_date', 'carry' => 1])->get();
        $employees = Employee::all();
        foreach ($leaveTypes as $leaveType) {
            foreach ($employees as $employee) {
                $data = $this->leaveCalculation($leaveType->id, $employee->id);
                $total_leaves_taken = $data['total_leaves_taken'];
                $entitled_leaves = $data['entitled_leaves'];
                $carryOverTaken = 0;
                $carryOver = CarryOver::where(['employee_id' => $employee->id, 'leave_type_id' => $leaveType->id])->first();
                if ($carryOver) {
                    $carryOverTaken = $carryOver->taken;
                }

                $remainingCarryOver = 0;
                if ($carryOver && $carryOver->expire_flag) {
                    $remainingCarryOver = $carryOver->remaining;
                }
                $carriedOver = $entitled_leaves - $total_leaves_taken + $carryOverTaken + $remainingCarryOver;
                
                $carryOverLimit = 0;
            
                if ($leaveType->carry_over == 'no_limit') {
                    $carryOverLimit = $carriedOver;
                } else if ($leaveType->carry_over == 'limit') {
                    if ($leaveType->carried_over_days < $carriedOver) {
                        $carryOverLimit = $leaveType->carried_over_days;
                    } else {
                        $carryOverLimit = $carriedOver;
                    }
                }

                if ($leaveType->carry_over_expire == 'yes') {
                    $expiryDate = now()->subDays(1)->addMonth($leaveType->When_carry_over_expire);
                } else {
                    $expiryDate = null;
                }

                if (!$carryOver) {
                    $carryOver = CarryOver::create([
                        'employee_id' => $employee->id,
                        'leave_type_id' => $leaveType->id,
                        'expiry_date' => $expiryDate,
                        'total' => $carriedOver,
                        'grant_limit' => $carryOverLimit,
                        'taken' => 0,
                        'remaining' => $carryOverLimit,
                        'expire_flag' => 0
                    ]);
                } else {
                    $carryOver->expiry_date = $expiryDate;
                    $carryOver->total = $carriedOver;
                    $carryOver->grant_limit = $carryOverLimit;
                    $carryOver->taken = 0;
                    $carryOver->remaining = $carryOverLimit;
                    $carryOver->expire_flag = 0;
                    $carryOver->save();
                }
            }

            if ($leaveType->valid == 'yes') {
                $leaveType->specific_date = Carbon::parse($leaveType->specific_date)->addYears(3);
            } else{
                $leaveType->specific_date = Carbon::parse($leaveType->specific_date)->addYears(1);
            }
            $leaveType->save();
        }
    }
}
