<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\CarryOver;
use App\Models\LeaveType;

class CarryOverExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carryover:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will mark expire flag to all carry over.';

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
        $employees = Employee::all();
        $leaveTypes = LeaveType::where(['date_join' => 'specific_date', 'specific_date' => now()->subDays(1), 'carry' => 1])->get();
        foreach ($leaveTypes as $leaveType) {
            foreach ($employees as $employee) {
                $carryOver = CarryOver::where(['employee_id' => $employee->id, 'leave_type_id' => $leaveType->id])->first();
                if ($carryOver && $carryOver->expiry_date == now()) {
                    $carryOver->expire_flag = 1;
                    $carryOver->save();
                }
            }
        }
        
    }
}
