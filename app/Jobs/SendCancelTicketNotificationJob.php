<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\FcmNotification;

class SendCancelTicketNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $ticket_cancelled;
    public function __construct($data, $ticket_cancelled)
    {
        $this->data = $data;
        $this->ticket_cancelled = $ticket_cancelled;
    }
    public function handle()
    {
        return $this->processCancellation($this->data, $this->ticket_cancelled);
    }
    private function processCancellation($data, $ticket_cancelled)
{
    Log::info('CancelTicketJob → Started', [
        'payload' => $data,
        'template_key' => $ticket_cancelled
    ]);

    if (empty($data['pnr'])) {
        Log::error('CancelTicketJob → PNR missing in payload', [
            'payload' => $data
        ]);
        return;
    }

    Log::info('CancelTicketJob → Fetching booking by PNR', [
        'pnr' => $data['pnr']
    ]);

    $bookingData = getBookingData(null, $data['pnr']);

    if (!$bookingData) {
        Log::error('CancelTicketJob → Booking not found', [
            'pnr' => $data['pnr']
        ]);
        return;
    }

    Log::info('CancelTicketJob → Booking found', [
        'booking_id' => $bookingData->id,
        'user_id'    => $bookingData->user_id
    ]);

    $templateData = [
        'ROUTENAME' => $bookingData->source_name . ' to ' . $bookingData->destination_name,
        'BUSNAME'   => $bookingData->bus_name,
        'NUMBER'    => $bookingData->bus_number,
        'DATE'      => $bookingData->journey_dt,
        'PNR'       => $bookingData->pnr,
    ];

    Log::info('CancelTicketJob → Resolving template', [
        'template_key' => $ticket_cancelled
    ]);

    $template = $this->getTemplate($templateData, $ticket_cancelled);

    if (!$template) {
        Log::error('CancelTicketJob → Template missing', [
            'template_key' => $ticket_cancelled
        ]);
        return;
    }

    Log::info('CancelTicketJob → Template resolved', [
        'template_id' => $template['id'],
        'title'       => $template['title']
    ]);

    FcmNotification::create([
        'customer_id'       => $bookingData->user_id,
        'template_id'       => $template['id'],
        'title'             => $template['title'],
        'message'           => $template['message'],
        'data_payload'      => json_encode([
            'booking_id' => $bookingData->id,
            'pnr'        => $bookingData->pnr
        ]),
        'booking_id'        => $bookingData->id,
        'src'               => $bookingData->source_name,
        'destination'       => $bookingData->destination_name,
        'notification_type' => 'ticket_cancelled',
        'status'            => 'queued',
        'scheduled_at'      => now(),
    ]);

    Log::info('CancelTicketJob → Notification queued successfully', [
        'pnr'        => $bookingData->pnr,
        'booking_id'=> $bookingData->id
    ]);
}


    private function getTemplate(array $data, string $templateKey)
    {
        $msTemplateKey = DB::table('scheduler.ms_template_key')
            ->where('template_key', $templateKey)
            ->first();

        if (!$msTemplateKey) {
            Log::error('CancelTicketJob → Template key not found', [
                'key' => $templateKey
            ]);
            return null;
        }

        $templateData = DB::table('scheduler.push_notification_template')
            ->where('template_key_id', $msTemplateKey->id)
            ->first();

        if (!$templateData) {
            Log::error('CancelTicketJob → Template row not found', [
                'key' => $templateKey
            ]);
            return null;
        }

        return [
            'id'      => $templateData->id,
            'title'   => $templateData->title,
            'message' => $this->bindMessage($templateData->message, $data),
        ];
        //return $templateData;
    }

    private function bindMessage(string $template, array $data)
    {
        foreach ($data as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }
        return $template;
    }
}
