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
        $deviceToken = 'ey9CCjMBTm6eO4G_7640Im:APA91bG4JHbkVvHKrqsrU-yXRn7u1UUWR7QANKlSqD9nb8bQC1fI0t3ryI5UkYRScwofUqgf-QYkUr-K4RzRslamgy-5QbYdOpkwXpUQAIlFpIIXzhiAgMY';

        $this->sendPushNotification(
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
