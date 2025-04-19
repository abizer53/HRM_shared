<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ReminderShiftStarts::class,
        Commands\ReminderShiftStarted::class,
        Commands\ReminderToEmployeesNotClocked::class,
        Commands\ShiftLeaveReminder::class,
        Commands\CarryOverCalculation::class,
        Commands\CarryOverExpiry::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $companyStartTime = strtotime(config('company_start_time'));
        $schedule->command('reminder:shift-starts')->dailyAt(date("H:i", strtotime("-15 minutes",$companyStartTime)));
        $schedule->command('reminder:shift-started')->dailyAt(date("H:i", strtotime("+15 minutes",$companyStartTime)));
        $schedule->command('reminder:employees-not-clocked')->dailyAt('23:00');
        $schedule->command('reminder:shift-leave')->dailyAt(date("H:i", strtotime("60 minutes",strtotime($companyStartTime))));
        $schedule->command('carryover:expire')->dailyAt('00:01');
        $schedule->command('carryover:renew')->dailyAt('00:05');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}