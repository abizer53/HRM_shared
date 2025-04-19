<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Models\Employee;

class ReminderShiftStarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:shift-starts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It send email to employees/staff 15 minutes before the work shift starts';

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
        $this->info('Sending reminders...');
        
        $employees = Employee::where('is_active', 1)->get();

        foreach ($employees as $key => $employee) {
            try {
                Mail::send([], [], function ($message) use($employee) {
                  $message->to($employee->email)
                    ->subject('Reminder')
                    ->setBody('<h1>shift starts in 15 minutes.</h1>', 'text/html'); 
                });
                $this->info('Reminders sent successfully!');
            } catch (\Throwable $th) {
                $this->info($th->getMessage());
            }
        }
    }
}