<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Location;
use App\Models\NotificationCampaign;
use App\Models\NotificationCampaignQueue;
use App\Models\Users;
use App\Traits\PushNotificationTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationCampaignService
{
    use PushNotificationTrait;

    public function scheduleBookingConfirmationNotification($booking)
    {
        if (!$booking || !isset($booking->users) || !$booking->users) {
            return false;
        }

        $campaign = $this->getBookingConfirmationCampaign($booking);
        if (!$campaign) {
            Log::info('No active booking confirmation campaign found for booking', ['booking_id' => $booking->id]);
            return false;
        }

        $user = $booking->users;
        $scheduledTime = $this->resolveScheduledTime($campaign);

        $message = $this->replacePlaceholders($campaign->message, $booking);
        $title = $this->replacePlaceholders($campaign->title, $booking);

        return NotificationCampaignQueue::create([
            'campaign_id' => $campaign->id,
            'user_id' => $user->id,
            'email' => $user->email,
            'mobile' => $user->phone,
            'fcm_token' => $user->fcm_id,
            'status' => 'PENDING',
            'retry_count' => 0,
            'scheduled_time' => $scheduledTime,
            'error_code' => null,
            'error_message' => null,
        ]);
    }

    protected function getBookingConfirmationCampaign($booking)
    {
        $user = $booking->users;

        $query = NotificationCampaign::active();

        $query->where(function ($builder) use ($user) {
            $builder->where('target_type', 'ALL');

            if (isset($user->is_verified) && $user->is_verified) {
                $builder->orWhere('target_type', 'VERIFIED');
            }
        });

        return $query->where(function ($builder) {
            $builder->where('campaign_name', 'CONFIRM_BOOKING')
                ->orWhere('type', 'TRANSACTIONAL');
        })->orderBy('id', 'desc')->first();
    }

    protected function resolveScheduledTime(NotificationCampaign $campaign)
    {
        if ($campaign->schedule_type === 'SCHEDULED' && $campaign->schedule_at) {
            return $campaign->schedule_at;
        }

        if ($campaign->schedule_type === 'BEFORE_EVENT' || $campaign->schedule_type === 'AFTER_EVENT') {
            return $campaign->schedule_at ?: Carbon::now();
        }

        if ($campaign->schedule_type === 'IMMEDIATE') {
            return Carbon::now();
        }

        if ($campaign->schedule_minutes && $campaign->schedule_minutes > 0) {
            return Carbon::now()->addMinutes($campaign->schedule_minutes);
        }

        return Carbon::now();
    }

    protected function replacePlaceholders($text, $booking)
    {
        $placeholders = [
            '{{pnr}}' => $booking->pnr ?? '',
            '{{name}}' => optional($booking->users)->name ?? '',
            '{{journeydate}}' => isset($booking->journey_dt) ? date('d-m-Y', strtotime($booking->journey_dt)) : '',
            '{{source}}' => optional($booking->source)->name ?? optional($booking->source_id ? Location::find($booking->source_id) : null)->name ?? '',
            '{{destination}}' => optional($booking->destination)->name ?? optional($booking->destination_id ? Location::find($booking->destination_id) : null)->name ?? '',
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $text);
    }
}
