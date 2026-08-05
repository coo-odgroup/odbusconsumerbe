<?php

namespace App\Console\Commands;

use App\Models\NotificationCampaignQueue;
use App\Models\NotificationCampaign;
use App\Traits\PushNotificationTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessNotificationCampaignQueue extends Command
{
    use PushNotificationTrait;

    protected $signature = 'notification:process-queue';

    protected $description = 'Process pending notification campaign queue items in batches of 200';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $queueItems = NotificationCampaignQueue::where('status', 'PENDING')
            ->where('scheduled_time', '<=', Carbon::now())
            ->orderBy('scheduled_time')
            ->limit(200)
            ->get();

        if ($queueItems->isEmpty()) {
            Log::info('Notification campaign queue: no pending items to process');
            return 0;
        }

        foreach ($queueItems as $item) {
            $campaign = $item->campaign;
            if (!$campaign) {
                $item->update([
                    'status' => 'FAILED',
                    'processed_at' => Carbon::now(),
                    'error_message' => 'Missing campaign record',
                ]);
                continue;
            }

            if (empty($item->fcm_token)) {
                $item->update([
                    'status' => 'FAILED',
                    'processed_at' => Carbon::now(),
                    'error_message' => 'Missing FCM token',
                ]);
                $campaign->increment('processed_users');
                $campaign->increment('failed_users');
                continue;
            }

            $response = $this->sendPushNotification(
                $item->fcm_token,
                $campaign->title,
                $campaign->message,
                [
                    'campaign_id' => $campaign->id,
                    'booking_id' => $item->user_id,
                    'type' => $campaign->type,
                ]
            );

            $status = $response['status'] ? 'SUCCESS' : 'FAILED';
            $errorMessage = $response['status'] ? null : ($response['message'] ?? 'Push notification failed');

            if (!$response['status'] && $this->isInvalidTokenResponse($response)) {
                $status = 'INVALID_TOKEN';
            }

            $item->update([
                'status' => $status,
                'processed_at' => Carbon::now(),
                'error_message' => $errorMessage,
            ]);

            $campaign->increment('processed_users');
            if ($status === 'SUCCESS') {
                $campaign->increment('success_users');
            } elseif ($status === 'INVALID_TOKEN') {
                $campaign->increment('failed_users');
            } else {
                $campaign->increment('failed_users');
            }
        }

        return 0;
    }

    protected function isInvalidTokenResponse(array $response)
    {
        $payload = json_encode($response['response'] ?? []);

        return (strpos($payload, 'UNREGISTERED') !== false)
            || (strpos($payload, 'INVALID_ARGUMENT') !== false)
            || (strpos($payload, 'Invalid registration token') !== false)
            || (strpos($payload, 'NOT_FOUND') !== false);
    }
}
