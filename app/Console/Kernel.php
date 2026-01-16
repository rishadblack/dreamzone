<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function scheduleTimezone()
    {
        return 'Europe/London';
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('fund:attachment')->hourly();
        $schedule->command('member:statement')->daily();
        $schedule->command('return:statement')->daily();
        $schedule->command('backup:run --only-db --only-to-disk=google')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
