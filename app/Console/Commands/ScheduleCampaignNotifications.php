<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ScheduleCampaignNotifications extends Command
{
    protected $signature = 'notifications:schedule-campaigns';
    protected $description = 'Create notification queue entries for scheduled campaigns';
    public function handle()
    {
        $now = Carbon::now();

        Log::info('Scheduled Campaign Queue Command Started', [
            'time' => $now->toDateTimeString()
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get scheduled campaigns
        |--------------------------------------------------------------------------
        */

        $campaigns = DB::table('notification_campaigns')
            ->where('schedule_type', 'SCHEDULED')
            ->where('active_status', 1)
            ->whereNotNull('active_user_duration')
            ->get();

        if ($campaigns->isEmpty()) {

            Log::info('No scheduled campaigns found');

            return Command::SUCCESS;
        }

        foreach ($campaigns as $campaign) {

            try {

                /*
                |--------------------------------------------------------------------------
                | Get schedules belonging to this campaign
                |--------------------------------------------------------------------------
                */

                $schedules = DB::table('notification_campaign_schedule')
                    ->where('notification_campaign_id', $campaign->id)
                    ->orderBy('schedule_date')
                    ->orderBy('start_time')
                    ->get();

                if ($schedules->isEmpty()) {

                    Log::warning('No schedule found for campaign', [
                        'campaign_id' => $campaign->id
                    ]);

                    continue;
                }


                $durationMonths = (int) $campaign->active_user_duration;
                $activeSince = Carbon::now()
                    ->subMonths($durationMonths);


                $users = DB::table('users')
                    ->select([
                        'id',
                        'name',
                        'email',
                        'phone',
                        'fcm_id',
                        'updated_at'
                    ])
                    ->whereNotNull('fcm_id')
                    ->where('fcm_id', '!=', '')
                    ->where('updated_at', '>=', $activeSince)
                    ->orderBy('id')
                    ->get();

                if ($users->isEmpty()) {

                    Log::warning('No active users found', [
                        'campaign_id' => $campaign->id,
                        'active_user_duration' => $durationMonths,
                        'active_since' => $activeSince->toDateTimeString()
                    ]);

                    continue;
                }

                Log::info('Active users found', [
                    'campaign_id' => $campaign->id,
                    'users' => $users->count(),
                    'duration_months' => $durationMonths
                ]);

                /*
                |--------------------------------------------------------------------------
                | Spread users across all schedule windows
                |--------------------------------------------------------------------------
                */

                $this->createQueue(
                    $campaign,
                    $schedules,
                    $users
                );
            } catch (\Throwable $e) {

                Log::error('Campaign scheduling failed', [
                    'campaign_id' => $campaign->id,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
            }
        }

        Log::info('Scheduled Campaign Queue Command Finished');

        return Command::SUCCESS;
    }


    /**
     * Create queue records and distribute users
     */
    private function createQueue($campaign, $schedules, $users)
    {
        $totalUsers = $users->count();


        $slots = [];

        foreach ($schedules as $schedule) {

            $start = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $schedule->schedule_date . ' ' . $schedule->start_time
            );

            $end = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $schedule->schedule_date . ' ' . $schedule->end_time
            );

            $minutes = $start->diffInMinutes($end);

            if ($minutes <= 0) {

                Log::warning('Invalid schedule time', [
                    'campaign_id' => $campaign->id,
                    'schedule_id' => $schedule->id,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time
                ]);

                continue;
            }

            for ($i = 0; $i < $minutes; $i++) {
                $slots[] = $start->copy()->addMinutes($i);
            }
        }

        $totalSlots = count($slots);

        if ($totalSlots === 0) {

            Log::warning('No valid schedule slots', [
                'campaign_id' => $campaign->id
            ]);

            return;
        }


        $alreadyQueued = DB::table('notification_campaign_queue')
            ->where('campaign_id', $campaign->id)
            ->whereIn('status', [
                'PENDING',
                'PROCESSING',
                'SUCCESS'
            ])
            ->exists();

        if ($alreadyQueued) {

            Log::info('Campaign already queued. Skipping.', [
                'campaign_id' => $campaign->id
            ]);

            return;
        }


        $usersArray = $users->values()->all();

        $batchSize = 500;

        foreach (array_chunk($usersArray, $batchSize) as $batchIndex => $userBatch) {

            $queueRows = [];

            foreach ($userBatch as $batchUserIndex => $user) {

                $index = ($batchIndex * $batchSize) + $batchUserIndex;

                $slotIndex = (int) floor(
                    ($index * $totalSlots) / $totalUsers
                );

                if ($slotIndex >= $totalSlots) {
                    $slotIndex = $totalSlots - 1;
                }

                $scheduledTime = $slots[$slotIndex];

                $queueRows[] = [
                    'campaign_id'    => $campaign->id,
                    'user_id'        => $user->id,
                    'email'          => $user->email,
                    'mobile'         => $user->phone,
                    'fcm_token'      => $user->fcm_id,
                    'status'         => 'PENDING',
                    'title'          => $campaign->title,
                    'message'        => $campaign->message,
                    'image_url'      => $campaign->image,
                    'booking_status' => null,
                    'booking_id'     => null,
                    'retry_count'    => 0,
                    'scheduled_time' => $scheduledTime,
                    'processed_at'   => null,
                    'error_code'     => null,
                    'error_message'  => null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }

            if (!empty($queueRows)) {

                DB::table('notification_campaign_queue')
                    ->insert($queueRows);
            }

            unset($queueRows);



            gc_collect_cycles();
        }


        DB::table('notification_campaigns')
            ->where('id', $campaign->id)
            ->update([
                'total_users'  => $totalUsers,
                'started_at'   => null,
                'is_completed' => 0,
                'updated_at'   => now(),
            ]);

        Log::info('Campaign notification queue created', [
            'campaign_id'    => $campaign->id,
            'users'          => $totalUsers,
            'slots'          => $totalSlots,
            'first_schedule' => $slots[0]->toDateTimeString(),
            'last_schedule'  => $slots[$totalSlots - 1]->toDateTimeString(),
        ]);
    }
}
