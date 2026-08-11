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
use App\Models\NotificationCategory;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Factory;

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

    public function scheduleBookingAbandonedNotification($booking)
    {
        if (!$booking) {
            return false;
        }

        /*
     * Booking must still be abandoned.
     *
     * 0 = Not booked / abandoned
     * 1 = Successfully booked
     * 2 = Cancelled
     * 4 = Seat/payment hold
     */
        if ((int) $booking->status !== 0) {
            return false;
        }

        /*
     * Get user.
     *
     * Your booking table contains users_id.
     */
        $user = null;

        if (!empty($booking->users_id)) {
            $user = Users::find($booking->users_id);
        }

        /*
     * Fallback to relationship if available.
     */
        if (!$user && isset($booking->users)) {
            $user = $booking->users;
        }

        if (!$user) {

            Log::warning('User not found for abandoned booking', [
                'booking_id' => $booking->id,
                'users_id'   => $booking->users_id,
            ]);

            return false;
        }

        /*
     * User must have FCM token.
     */
        if (empty($user->fcm_id)) {

            Log::warning('FCM token missing for abandoned booking', [
                'booking_id' => $booking->id,
                'user_id'    => $user->id,
            ]);

            return false;
        }

        /*
     * Get active abandoned booking campaigns.
     *
     * notification_category_id = 2
     */
        $campaigns = NotificationCampaign::active()
            ->where('notification_category_id', 2)
            ->where('type', 'PROMOTIONAL')
            ->where('target_type', 'ACTIVE')
            ->where('schedule_type', 'AFTER_EVENT')
            ->where('active_status', 1)
            ->orderBy('id')
            ->get();

        if ($campaigns->isEmpty()) {

            Log::warning('No abandoned booking campaigns found', [
                'booking_id' => $booking->id,
            ]);

            return false;
        }

        $createdCount = 0;

        foreach ($campaigns as $campaign) {

            /*
         * Prevent duplicate notification queue records.
         *
         * If campaign 6 has already been prepared for this booking,
         * don't create it again when this command runs next minute.
         */
            $alreadyQueued = NotificationCampaignQueue::where(
                'campaign_id',
                $campaign->id
            )
                ->where('booking_id', $booking->id)
                ->exists();

            if ($alreadyQueued) {

                Log::info('Abandoned booking notification already queued', [
                    'booking_id'  => $booking->id,
                    'campaign_id' => $campaign->id,
                ]);

                continue;
            }

            /*
         * Replace campaign placeholders.
         */
            $title = $this->replacePlaceholders(
                $campaign->title,
                $booking
            );

            $message = $this->replacePlaceholders(
                $campaign->message,
                $booking
            );

            /*
         * Image:
         *
         * If campaign has an image use it.
         * Otherwise use ODBUS logo.
         */
            $imageUrl = !empty($campaign->image)
                ? $campaign->image
                : 'https://www.odbus.in/assets/odbus-logo.png';

            /*
         * Campaign schedule_minutes:
         *
         * Campaign 6 = 360 minutes = 6 hours
         * Campaign 7 = 720 minutes = 12 hours
         * Campaign 8 = 1440 minutes = 24 hours
         */
            $scheduledTime = Carbon::now()->addMinutes(
                (int) $campaign->schedule_minutes
            );

            /*
         * Create notification queue.
         */
            NotificationCampaignQueue::create([
                'campaign_id'    => $campaign->id,
                'user_id'        => $user->id,
                'email'          => $user->email,
                'mobile'         => $user->phone,
                'fcm_token'      => $user->fcm_id,
                'status'         => 'PENDING',
                'title'          => $title,
                'message'        => $message,
                'image_url'      => $imageUrl,
                'booking_status' => $booking->status,
                'booking_id'     => $booking->id,
                'retry_count'    => 0,
                'scheduled_time' => $scheduledTime,
                'processed_at'   => null,
                'error_code'     => null,
                'error_message'  => null,
            ]);

            $createdCount++;

            Log::info('Abandoned booking notification queued', [
                'booking_id'    => $booking->id,
                'campaign_id'   => $campaign->id,
                'user_id'       => $user->id,
                'scheduled_time' => $scheduledTime->toDateTimeString(),
            ]);
        }

        return $createdCount > 0;
    }


    public function queueBookingNotifications(int $bookingId): bool
    {
        DB::beginTransaction();

        try {

            /**
             * Fetch booking with relations
             */
            $booking = Booking::with([
                'users',
                'bookingDetail',
                'bus'
            ])->find($bookingId);

            if (!$booking) {
                DB::rollBack();
                return false;
            }

            /**
             * Fetch Notification Category
             *
             * CONFIRM_BOOKING = Successful Booking Notification
             */
            $category = NotificationCategory::where(
                'category_code',
                'CONFIRM_BOOKING'
            )
                ->where('status', 1)
                ->first();

            if (!$category) {

                Log::warning('CONFIRM_BOOKING notification category not found', [
                    'booking_id' => $bookingId
                ]);

                DB::commit();
                return true;
            }

            /**
             * Fetch all active campaigns
             * belonging to CONFIRM_BOOKING category
             */
            $campaigns = NotificationCampaign::where(
                'notification_category_id',
                $category->id
            )
                ->where('active_status', 1)
                ->orderBy('id')
                ->get();

            if ($campaigns->isEmpty()) {

                Log::info('No active CONFIRM_BOOKING campaigns found', [
                    'booking_id' => $bookingId,
                    'category_id' => $category->id
                ]);

                DB::commit();

                return true;
            }

            /**
             * Passenger Seat List
             */
            $seatNos = $booking->bookingDetail
                ->pluck('seat_no')
                ->implode(',');

            /**
             * Journey Departure Date Time
             */
            $departure = Carbon::parse(
                $booking->journey_dt . ' ' . $booking->departure_time
            );

            foreach ($campaigns as $campaign) {

                /**
                 * Replace Dynamic Variables
                 */
                $message = str_replace(
                    [
                        '{{Name}}',
                        '{{SeatsNo}}',
                        '{{BusNameNo}}',
                        '{{JourneyDate}}',
                        '{{Source}}',
                        '{{Destination}}',
                        '{{DepartureTime}}'
                    ],
                    [
                        $booking->users->name,
                        $seatNos,
                        $booking->bus->bus_name,
                        Carbon::parse($booking->journey_dt)->format('d M Y'),
                        $booking->source_name,
                        $booking->destination_name,
                        Carbon::parse($booking->departure_time)->format('h:i A')
                    ],
                    $campaign->message
                );

                /**
                 * Calculate Schedule Time
                 */
                switch ($campaign->schedule_type) {

                    case 'IMMEDIATE':

                        $scheduledTime = now();

                        break;

                    case 'BEFORE_EVENT':

                        $scheduledTime = $departure
                            ->copy()
                            ->subMinutes(
                                abs((int) $campaign->schedule_minutes)
                            );

                        break;

                    case 'AFTER_EVENT':

                        $scheduledTime = $departure
                            ->copy()
                            ->addMinutes(
                                (int) $campaign->schedule_minutes
                            );

                        break;

                    default:

                        $scheduledTime = now();

                        break;
                }

                /**
                 * Insert Notification Queue
                 */
                NotificationCampaignQueue::create([

                    'campaign_id'    => $campaign->id,
                    'user_id'        => $booking->users->id,
                    'booking_id'     => $booking->id,
                    'email'          => $booking->users->email,
                    'mobile'         => $booking->users->phone,
                    'fcm_token'      => $booking->users->fcm_id,
                    'status'         => 'PENDING',
                    'title'          => $campaign->title,
                    'message'        => $message,
                    'booking_status' => $booking->status,
                    'retry_count'    => 0,
                    'scheduled_time' => $scheduledTime,
                ]);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Failed to queue booking notifications', [
                'booking_id' => $bookingId,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);

            return false;
        }
    }



    public function processNotificationQueue()
    {
        try {

            $notifications = NotificationCampaignQueue::where('status', 'PENDING')
                ->where('scheduled_time', '<=', now())
                ->orderBy('scheduled_time')
                ->get();

            foreach ($notifications as $notification) {

                try {

                    if (empty($notification->fcm_token)) {

                        $notification->update([
                            'status' => 'FAILED',
                            'error_message' => 'FCM Token Missing',
                            'processed_at' => now()
                        ]);

                        continue;
                    }

                    $this->sendPushNotification(
                        $notification->fcm_token,
                        $notification->title,
                        $notification->message
                    );

                    $notification->update([
                        'status' => 'SENT',
                        'processed_at' => now(),
                        'retry_count' => $notification->retry_count + 1,
                        'error_message' => null,
                        'error_code' => null
                    ]);
                } catch (\Exception $e) {

                    $notification->update([
                        'status' => 'FAILED',
                        'retry_count' => $notification->retry_count + 1,
                        'processed_at' => now(),
                        'error_message' => $e->getMessage()
                    ]);

                    Log::error($e);
                }
            }
        } catch (\Exception $e) {

            Log::error($e);
        }
    }

    public function sendPushNotification($token, $title, $message)
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path('firebase.json')); // change filename if needed

        $messaging = $factory->createMessaging();

        $notification = Notification::create($title, $message);

        $cloudMessage = CloudMessage::withTarget(
            'token',
            $token
        )->withNotification($notification);

        return $messaging->send($cloudMessage);
    }
}
