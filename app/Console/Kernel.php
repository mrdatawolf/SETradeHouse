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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('gather:nebulon')->everyThirtyMinutes();
        $schedule->command('gather:trends', ['good_type_id' => 1])->cron('5 * * * *');
        $schedule->command('gather:trends', ['good_type_id' => 2])->cron('10 * * * *');
        $schedule->command('gather:trends', ['good_type_id' => 3])->cron('15 * * * *');
        $schedule->command('gather:trends', ['good_type_id' => 4])->cron('20 * * * *');
        $schedule->command('gather:trends', ['good_type_id' => 1])->cron('35 * * * *');
        $schedule->command('gather:trends', ['good_type_id' => 2])->cron('40 * * * *');
        $schedule->command('gather:trends', ['good_type_id' => 3])->cron('45 * * * *');
        $schedule->command('gather:trends', ['good_type_id' => 4])->cron('50 * * * *');
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
