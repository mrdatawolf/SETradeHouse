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
        $schedule->command('gather:nebulon')->everyFifteenMinutes();
        $schedule->command('align:trends', ['--transactionTypeId' => 1, '--goodTypeId' => 1])->cron('3 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 1, '--goodTypeId' => 2])->cron('6 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 1, '--goodTypeId' => 3])->cron('9 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 1, '--goodTypeId' => 4])->cron('12 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 2, '--goodTypeId' => 1])->cron('18 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 2, '--goodTypeId' => 2])->cron('21 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 2, '--goodTypeId' => 3])->cron('24 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 2, '--goodTypeId' => 4])->cron('27 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 1, '--goodTypeId' => 1])->cron('33 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 1, '--goodTypeId' => 2])->cron('36 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 1, '--goodTypeId' => 3])->cron('39 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 1, '--goodTypeId' => 4])->cron('42 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 2, '--goodTypeId' => 1])->cron('48 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 2, '--goodTypeId' => 2])->cron('51 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 2, '--goodTypeId' => 3])->cron('54 * * * *');
        $schedule->command('align:trends', ['--transactionTypeId' => 2, '--goodTypeId' => 4])->cron('57 * * * *');
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
