<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\FcmNotification;

class ReminderBeforeOneHourJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bookingId;
    protected $pre_departure_reminder_1h;

    public function __construct($bookingId, $pre_departure_reminder_1h)
    {
        $this->bookingId = $bookingId;
        $this->pre_departure_reminder_1h = $pre_departure_reminder_1h;
    }

    public function handle()
    {
        $booking = getBookingData($this->bookingId);

        
        if (!$booking) {
            Log::error("1-HOUR REMINDER → Booking not found", [
                'booking_id' => $this->bookingId
            ]);
            return;
        }

       
        if ((int) $booking->status === 2) {
            Log::info("1-HOUR REMINDER → Booking cancelled, skipped", [
                'booking_id' => $booking->id
            ]);
            return;
        }

        $template = $this->getTemplate($this->pre_departure_reminder_1h);
        if (!$template) {
            Log::error("1-HOUR REMINDER → Template missing", [
                'key' => $this->pre_departure_reminder_1h
            ]);
            return;
        }

       
        $data = [
            'ROUTENAME'     => $booking->source_name . ' to ' . $booking->destination_name,
            'BUSNAME'       => $booking->bus_name ?? '',
            'NUMBER'        => $booking->bus_number ?? '',
            'TIME'          => $booking->boarding_time ?? '',
            'BOARDINGPOINT' => $booking->boarding_point ?? '',
            'DATE'          => $booking->journey_dt ?? '',
            'PNR'           => $booking->pnr ?? '',
        ];

        $message = $this->bindMessage($template->message, $data);

        
        FcmNotification::create([
            'customer_id'  => $booking->user_id,
            'template_id'  => $template->id,
            'title'        => $template->title,
            'message'      => $message,
            'data_payload' => json_encode(['booking_id' => $booking->id]),
            'booking_id'   => $booking->id,
            'src'          => $booking->source_name,
            'destination'  => $booking->destination_name,
            'status'       => 'queued',
            'scheduled_at' => now(),
        ]);

        Log::info("1-HOUR REMINDER → Notification queued", [
            'booking_id' => $booking->id
        ]);
    }

    private function getTemplate($key)
    {
        return DB::table('scheduler.push_notification_template as push')
            ->join('scheduler.ms_template_key as key', 'key.id', '=', 'push.template_key_id')
            ->whereRaw('TRIM(key.template_key) = ?', [trim($key)])
            ->where('push.status', 1)
            ->select('push.id', 'push.title', 'push.message')
            ->first();
    }

    private function bindMessage($template, $data)
    {
        foreach ($data as $k => $v) {
            $template = str_replace('{{' . $k . '}}', $v, $template);
        }
        return $template;
    }
}
