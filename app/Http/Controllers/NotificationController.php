<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NotificationCampaign;
use App\Models\NotificationCampaignQueue;
use App\Models\Users;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/CreateNotificationCampaign",
     *     tags={"Notification Campaign"},
     *     summary="Create notification campaign and queue recipients",
     *     description="Create a notification campaign and insert queue records with scheduled timing.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="campaign_name", type="string", example="CONFIRM_BOOKING"),
     *                 @OA\Property(property="title", type="string", example="Booking Confirmed"),
     *                 @OA\Property(property="message", type="string", example="Your ticket has been confirmed. PNR: {{pnr}}"),
     *                 @OA\Property(property="image", type="string", example="https://example.com/image.png"),
     *                 @OA\Property(property="type", type="string", enum={"PROMOTIONAL","TRANSACTIONAL","REMINDER","CUSTOM"}, example="TRANSACTIONAL"),
     *                 @OA\Property(property="active_status", type="boolean", example=true),
     *                 @OA\Property(property="target_type", type="string", enum={"ALL","ACTIVE","INACTIVE","VERIFIED","CUSTOM"}, example="ALL"),
     *                 @OA\Property(property="schedule_type", type="string", enum={"IMMEDIATE","SCHEDULED","BEFORE_EVENT","AFTER_EVENT"}, example="IMMEDIATE"),
     *                 @OA\Property(property="schedule_minutes", type="integer", example=0),
     *                 @OA\Property(property="schedule_at", type="string", format="date-time", example="2026-08-03 16:00:00"),
     *                 @OA\Property(property="user_ids", type="array", @OA\Items(type="integer"))
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Campaign created and queued successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=500, description="Server error"),
     *     security={{"apiAuth": {}}}
     * )
     */
    public function createCampaign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'campaign_name' => 'required|string|max:150',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:PROMOTIONAL,TRANSACTIONAL,REMINDER,CUSTOM',
            'active_status' => 'sometimes|boolean',
            'target_type' => 'required|in:ALL,ACTIVE,INACTIVE,VERIFIED,CUSTOM',
            'schedule_type' => 'required|in:IMMEDIATE,SCHEDULED,BEFORE_EVENT,AFTER_EVENT',
            'schedule_minutes' => 'sometimes|integer|min:0',
            'schedule_at' => 'sometimes|date',
            'user_ids' => 'sometimes|array',
            'user_ids.*' => 'integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = $validator->validated();
            $campaign = NotificationCampaign::create([
                'campaign_name' => $data['campaign_name'],
                'title' => $data['title'],
                'message' => $data['message'],
                'image' => $request->input('image'),
                'type' => $data['type'],
                'active_status' => $request->input('active_status', 1),
                'target_type' => $data['target_type'],
                'schedule_type' => $data['schedule_type'],
                'schedule_minutes' => $request->input('schedule_minutes', 0),
                'schedule_at' => $request->input('schedule_at'),
                'is_completed' => 0,
                'created_by' => auth()->id() ?? null,
            ]);

            $scheduledTime = $this->resolveScheduledTime($campaign);
            $recipients = $this->resolveRecipientUsers($campaign, $data);
            $queued = $this->queueCampaignRecipients($campaign, $recipients, $scheduledTime);

            $campaign->total_users = $recipients->count();
            $campaign->save();

            return response()->json([
                'status' => true,
                'message' => 'Notification campaign created and queued successfully.',
                'campaign' => $campaign,
                'queued_count' => $queued,
            ]);
        } catch (Exception $e) {
            Log::error('CreateNotificationCampaign error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to create notification campaign.',
            ], 500);
        }
    }

    protected function resolveScheduledTime(NotificationCampaign $campaign)
    {
        if ($campaign->schedule_type === 'SCHEDULED' && $campaign->schedule_at) {
            return Carbon::parse($campaign->schedule_at);
        }

        if ($campaign->schedule_type === 'BEFORE_EVENT' || $campaign->schedule_type === 'AFTER_EVENT') {
            return $campaign->schedule_at ? Carbon::parse($campaign->schedule_at) : Carbon::now();
        }

        if ($campaign->schedule_type === 'IMMEDIATE') {
            return Carbon::now();
        }

        if ($campaign->schedule_minutes && $campaign->schedule_minutes > 0) {
            return Carbon::now()->addMinutes($campaign->schedule_minutes);
        }

        return Carbon::now();
    }

    protected function resolveRecipientUsers(NotificationCampaign $campaign, array $data)
    {
        $query = Users::query()->whereNotNull('fcm_id');

        switch ($campaign->target_type) {
            case 'VERIFIED':
                if (Schema::hasColumn('users', 'is_verified')) {
                    $query->where('is_verified', 1);
                }
                break;
            case 'ACTIVE':
                if (Schema::hasColumn('users', 'status')) {
                    $query->where('status', 1);
                }
                break;
            case 'INACTIVE':
                if (Schema::hasColumn('users', 'status')) {
                    $query->where('status', 0);
                }
                break;
            case 'CUSTOM':
                if (!empty($data['user_ids'])) {
                    $query->whereIn('id', $data['user_ids']);
                } else {
                    return collect([]);
                }
                break;
            case 'ALL':
            default:
                break;
        }

        return $query->get();
    }

    protected function queueCampaignRecipients(NotificationCampaign $campaign, $recipients, Carbon $scheduledTime)
    {
        if ($recipients->isEmpty()) {
            return 0;
        }

        $rows = [];
        foreach ($recipients as $recipient) {
            $rows[] = [
                'campaign_id' => $campaign->id,
                'user_id' => $recipient->id,
                'email' => $recipient->email,
                'mobile' => $recipient->phone,
                'fcm_token' => $recipient->fcm_id,
                'status' => 'PENDING',
                'retry_count' => 0,
                'scheduled_time' => $scheduledTime,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            NotificationCampaignQueue::insert($chunk);
        }

        return count($rows);
    }
}
