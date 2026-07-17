<?php

namespace App\Traits;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait PushNotificationTrait
{
    protected function sendPushNotification(
        string $deviceToken,
        string $title,
        string $body,
        array $data = []
    ) {
        try {

            $credentialsPath = public_path(env('FIREBASE_CREDENTIAL'));

            if (!file_exists($credentialsPath)) {
                throw new \Exception(
                    "Firebase credential file not found: {$credentialsPath}"
                );
            }

            $credentials = new ServiceAccountCredentials(
                ['https://www.googleapis.com/auth/firebase.messaging'],
                $credentialsPath
            );

            $accessToken = $credentials->fetchAuthToken();

            if (!isset($accessToken['access_token'])) {
                throw new \Exception(
                    'Unable to generate Firebase access token.'
                );
            }

            $token = $accessToken['access_token'];

            $projectId = env('FIREBASE_PROJECT_ID', 'odbus-c581f');

            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

            $imageUrl = "https://www.odbus.in/assets/img/bus-stop.png";

            $payload = [
                'message' => [
                    'token' => $deviceToken,

                    'notification' => [
                        'title' => 'Summer Offer',
                        'body'  => 'Get ₹100 Cashback on your next booking',
                        'image' => $imageUrl
                    ],

                    'android' => [
                        'notification' => [
                            'image' => $imageUrl
                        ]
                    ],

                    'data' => [
                        'type' => 'offer',
                        'offer_id' => '123'
                    ]
                ]
            ];

            $response = Http::withToken($token)
                ->acceptJson()
                ->post($url, $payload);

            $responseBody = $response->json();

            $messageId = explode('/messages/', $responseBody['name'])[1] ?? null;

            Log::info('FCM Notification Response', [
                'device_token' => $deviceToken,
                'title' => $title,
                // 'response' => $response->json(),
                'message_id' => $messageId
            ]);

            if (!$response->successful()) {
                Log::error('FCM Notification Failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return [
                    'status' => false,
                    'message' => 'FCM notification failed.',
                    'response' => $response->json(),
                ];
            }

            return [
                'status' => true,
                'message' => 'Notification sent successfully.',
                'response' => $response->json(),
            ];
        } catch (\Throwable $e) {

            Log::error('Push Notification Exception', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
