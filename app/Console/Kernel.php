<?php

namespace App\Console;

use App\Console\Commands\DatabaseBackup;
use App\Console\Commands\SendCustomEmail;
use App\Console\Commands\SendSMS;
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
        SendCustomEmail::class,
        DatabaseBackup::class,
        SendSMS::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('optimize:clear')->weeklyOn(1, '8:00');
        $schedule->command('customEmail:queue')->everyFiveMinutes();
        $schedule->command('sms:queue')->everyFiveMinutes();
        $schedule->command('backup:run')->daily();
        $schedule->command('payment:reminder')->weeklyOn(1, '8:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
