<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\ProcessNotificationCampaignQueue::class,
        Commands\PrepareAbandonedBookingNotifications::class,
        Commands\ScheduleCampaignNotifications::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notification:prepare-abandoned')
            ->everyMinute();

        $schedule->command('notification:process-queue')
            ->everyMinute();

        $schedule->command('notifications:schedule-campaigns')
            ->dailyAt('00:00');
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
