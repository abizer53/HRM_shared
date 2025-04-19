<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Models\AttendanceEmployee;
use App\Models\Employee;

class ReminderToEmployeesNotClocked extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:employees-not-clocked';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It send email to employees/staff that have not clocked in for the day.';

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
                            ->setBody('<h1>Reminder, You did not attend today.</h1>', 'text/html'); 
                        });
                        $this->info('Reminders sent successfully!');
                    } catch (\Throwable $th) {
                        $this->info($th->getMessage());
                    }
                }
            }
        } else {
            $this->info('All employees and staff were present today.');            
        }
    }
}