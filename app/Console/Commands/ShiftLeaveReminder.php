<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Models\AttendanceEmployee;
use App\Models\Employee;

class ShiftLeaveReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:shift-leave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If employee not logged in after 1 hour of shift start time, then send reminder.';

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
        $this->info('Fetching employees...');
        
        $date = date("Y-m-d");
        $employeeAttendances = AttendanceEmployee::orderBy('id', 'desc')->where('date', '=', $date)->get()->pluck('employee_id');
        $employeeNotPresent = Employee::whereNotIn('id', $employeeAttendances)->get();

        if ($employeeNotPresent) {
            foreach ($employeeNotPresent as $key => $employee) {
                if ($employee->is_active) {
                    try {
                        Mail::send([], [], function ($message) use($employee) {
                          $message->to($employee->email)
                            ->subject('Reminder')
                            ->setBody('<h1>Reminder, Your shift is started 1 hour ago, now you can not clock in.</h1>', 'text/html'); 
                        });
                        $this->info('Reminders sent successfully!');
                    } catch (\Throwable $th) {
                        $this->info($th->getMessage());
                    }
                }
            }
        }
    }
}
