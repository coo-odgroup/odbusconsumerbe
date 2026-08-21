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
        Commands\DeleteOldNotificationCampaignQueue::class, // Delets the 3 month old notifiocation from notification_campaign_queue table
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notification:prepare-abandoned')->everyMinute();
        $schedule->command('notification:process-queue')->everyMinute();
        $schedule->command('notifications:schedule-campaigns')->dailyAt('00:00');
        $schedule->command('notifications:delete-old-queue')->dailyAt('00:00');  // Delets the 3 month old notifiocation from notification_campaign_queue table
        
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
