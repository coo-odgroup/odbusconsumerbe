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

class ThankYouJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bookingId;
    protected $thank_you_key;

    public function __construct($bookingId, $thank_you_key)
    {
        $this->bookingId   = $bookingId;
        $this->thank_you_key = $thank_you_key;
    }

    public function handle()
    {
        $booking = getBookingData($this->bookingId);

        if (!$booking) {
            Log::error("Thank You - Booking not found", [
                'booking_id' => $this->bookingId
            ]);
            return;
        }

        if ((int) $booking->status === 2) {
            Log::info("Thank You - Booking cancelled, skipped", [
                'booking_id' => $booking->id
            ]);
            return;
        }

        $template = $this->getTemplate($this->thank_you_key);
        if (!$template) {
            Log::error("THANK YOU → Template missing", [
                'key' => $this->thank_you_key
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
            'data_payload' => json_encode([
                'booking_id' => $booking->id,
                'from_city'  => $booking->source_name,
                'to_city'    => $booking->destination_name,
            ]),
            'booking_id'   => $booking->id,
            'src'          => $booking->source_name,
            'destination'  => $booking->destination_name,
            'status'       => 'queued',
            'scheduled_at' => now(),
        ]);

        Log::info("THANK YOU → Notification queued", [
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
