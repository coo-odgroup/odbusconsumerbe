<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\DB;
use App\Models\FcmNotification;

class TicketConfirmationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bookingId;
    protected $ticket_confirmed;

    public function __construct($bookingId, $ticket_confirmed)
    {
        $this->bookingId = $bookingId;
        $this->ticket_confirmed = $ticket_confirmed;
    }


    public function handle()
    {
        return $this->processBooking($this->bookingId, $this->ticket_confirmed);
    }

    private function processBooking($bookingId, $ticket_confirmed)
    {
        $bookingData = getBookingData($bookingId);

        if (!$bookingData) {
            Log::error('TicketConfirmationJob → Booking data not found', [
                'booking_id' => $bookingId
            ]);
            return;
        }


        $fcmPayload = [];

        $data = [
            'ROUTENAME'     => $bookingData->source_name . ' to ' . $bookingData->destination_name,
            'BUSNAME'       => $bookingData->bus_name,
            'NUMBER'        => $bookingData->bus_number,
            'TIME'          => $bookingData->boarding_time,
            'BOARDINGPOINT' => $bookingData->boarding_point,
            'DATE'          => $bookingData->journey_dt,
            'PNR'           => $bookingData->pnr,
        ];


        $template = $this->getTemplate($data, $ticket_confirmed);

        if (!$template || !isset($template['id'])) {
            Log::error('TicketConfirmationJob → Template invalid', [
                'template_key' => $ticket_confirmed,
                'booking_id'   => $bookingId
            ]);
            return;
        }



        // return $template;

        $temp_id = $template['id'];
        $title   = $template['title'];
        $body    = $template['message'];

        // return $title;
        //Log::info($body);
        //Log::info('Body: ' . json_encode($body));


        $fcmPayload[] = [
            "message" => [
                "token" => '',

                "notification" => [
                    "title" => $title,
                    "body"  => $body
                ],

                "data" => [
                    "deeplink"        => "",
                    "notification_id" => '',
                    "booking_id"      => $bookingData->id ?? '',
                    "from_city"       => $bookingData->source_name ?? '',
                    "to_city"         => $bookingData->destination_name ?? '',
                ],

                "android" => [
                    "priority" => "HIGH",
                    "notification" => [
                        "channel_id"   => "default",
                        "click_action" => "FLUTTER_NOTIFICATION_CLICK"
                    ]
                ],

                "apns" => [
                    "payload" => [
                        "aps" => [
                            "category" => "NEW_MESSAGE",
                            "sound"    => "default"
                        ]
                    ]
                ]
            ]
        ];


        FcmNotification::create([
            'customer_id'        => $bookingData->user_id,
            'template_id'        => $temp_id,
            'title'              => $title,
            'message'            => $body,
            'link'               => '',
            'data_payload'       => json_encode($fcmPayload),
            'booking_id'         => $bookingData->id ?? null,
            'src'                => $bookingData->source_name ?? null,
            'destination'        => $bookingData->destination_name ?? null,
            'notification_type'  => '',
            'status'             => 'queued',
            'scheduled_at'       => now(),
        ]);


        // Log::info($fcmPayload);
        // return $fcmPayload;
    }

   private function getTemplate($data, $ticket_confirmed)
{
    $ms_template_key = DB::table('scheduler.ms_template_key')
        ->where('template_key', $ticket_confirmed)
        ->first();

    if (!$ms_template_key) {
        Log::error('Template key missing', ['key' => $ticket_confirmed]);
        return null;
    }

    $templateData = DB::table('scheduler.push_notification_template')
        ->where('template_key_id', $ms_template_key->id)
        ->where('status', 1)
        ->first();

    if (!$templateData || empty($templateData->message)) {
        Log::error('Template data invalid', [
            'template_key' => $ticket_confirmed
        ]);
        return null;
    }

    return [
        'id'      => $templateData->id,
        'title'   => $templateData->title ?? '',
        'message' => $this->bindMessage($templateData->message, $data)
    ];
}


    private function bindMessage($template, $data)
{
    if (empty($template) || !is_array($data)) {
        return $template;
    }

    foreach ($data as $key => $value) {
        $template = str_replace('{{' . $key . '}}', (string) $value, $template);
    }

    return $template;
}

}
