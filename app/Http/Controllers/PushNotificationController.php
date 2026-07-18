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
        $deviceToken = 'eVW4JjXJRCaKAEOze7ckVU:APA91bG2zY79KYD_oOreyFkEDT92ebEYPgpf9SEE9U3JUaY1mwFvGSUueaNvbT58EgkeMhPuBpPFRJbxHLzpQ6J1IhbEbjZ7DD8HwO24Cb_U3lO7TwMew1U';

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
