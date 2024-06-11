<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('bulletin:check')->daily();
        $schedule->command('generate:report')->cron('0 0 '. env('APP_REPORT_DAYS') .' * *');
        $schedule->command('backup:clean --disable-notifications')->daily()->at('02:00');
        $schedule->command('backup:run --disable-notifications')->daily()->at('02:30');
        $schedule->command('refill:limits')->daily();
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
