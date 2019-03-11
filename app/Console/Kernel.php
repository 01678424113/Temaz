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
        'App\Console\Commands\AutoUpdateData',
        'App\Console\Commands\AutoSmsCronjob',
        'App\Console\Commands\ScanPhone',
        'App\Console\Commands\ScanTaxCode',
        'App\Console\Commands\ScanWithKey',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sms:cronjob 1')->cron('* * * * *');;
        $schedule->command('sms:cronjob 5')->cron('*/5 * * * *');;
        $schedule->command('sms:cronjob 10')->cron('*/10 * * * *');;
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
