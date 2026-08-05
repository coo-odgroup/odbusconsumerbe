<?php

namespace App\Http\Controllers;

use App\Traits\PushNotificationTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class PushNotificationController extends Controller
{
    use PushNotificationTrait;

    public function confirmBooking()
    {
        // $deviceToken = 'c1DbUg_nSyK-gx2RqK9FS2:APA91bHJm8L0NnWsx7bN-TIW8Ij5LRyi2VHfweMSwnhJAA3e6_AVW8i0_fag-xiR2RztPzhgeBt68N5sNGU5vR1mO7GHLwpwzV36rHZoeAXCMz8_5RyKFIg';
        $deviceToken = 'cpXXIOAlRFGlDjRdOTQfel:APA91bFOWimXT1MkpT3b315ApE-ds3rADzJxVIjAnbY9hT4YELbpmYfP5bKdMf6dt4c8n0ICvCA4z4gktY4cJ8phk97G_cNZkr5KnwxtdmbXOCkSa2__5MA';

        // return env('FIREBASE_CREDENTIAL');

        return $this->sendPushNotification(
            $deviceToken,
            'Booking Confirmed',
            'Your ticket has been booked successfully.',
            [
                'booking_id' => '123',
                'type' => 'booking'
            ]
        );
    }
}
