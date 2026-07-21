<?php

namespace App\Services;

use App\Models\BusContacts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Msg91Service
{
    public function sendBookingSms($mobile, $data)
    {
        $postData = array_merge([
            "flow_id" => config('msg91.templates.booking'),
            "mobiles" => "91" . $mobile,
        ], $data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.msg91.com/api/v5/flow/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public function sendWhatsappCampaign($numbers, $campaign, $variables)
    {
        $url = "https://control.msg91.com/api/v5/campaign/api/campaigns/cmo-ticket-booking-flow/run";

        $to = [];

        foreach ($numbers as $num) {
            $to[] = [
                "mobiles" => "91" . $num,
                "variables" => $variables
            ];
        }

        $postData = [
            "data" => [
                "sendTo" => [
                    [
                        "to" => $to,
                        "variables" => $variables
                    ]
                ]
            ]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response, true);
    }

    public function otpsend($numbers, $variables)
    {
        $url = "https://control.msg91.com/api/v5/campaign/api/campaigns/sign-and-login-otp/run";

        $to[] = [
            "mobiles" => "91" . $numbers,
            "variables" => $variables
        ];

        $postData = [
            "data" => [
                "sendTo" => [
                    [
                        "to" => $to,
                        "variables" => $variables
                    ]
                ]
            ]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response, true);
    }


    // Customer SMS SEND ON TICKET BOOKING
    public function customer_ticket_booking($data)
    {
        $formattedDate = Carbon::parse($data['journeydate'])->format('d-M-Y');
        $departureTime = Carbon::parse($data['departureTime'])->format('H:i');
        $passengers = $data['passengerDetails'];
        $firstPassenger = $passengers[0]['passenger_name'] ?? '';
        $count = count($passengers);

        $maleCount = collect($passengers)->where('passenger_gender', 'M')->count();
        $femaleCount = collect($passengers)->where('passenger_gender', 'F')->count();

        $parts = [];

        if ($maleCount > 0) {
            $parts[] = $maleCount . 'M';
        }

        if ($femaleCount > 0) {
            $parts[] = $femaleCount . 'F';
        }
        $totalCount = implode(',', $parts);

        $passengerText = $firstPassenger . '(' . $totalCount . ')';

        $variables = [

            "header_1" => [
                "type" => "image",
                "value" => config('msg91.template_image_url')
            ],

            "body_var_1" => ["type" => "text",  "value" => $data['name']],
            "body_var_2" => ["type" => "text", "value" => $data['pnr']],
            "body_var_3" => ["type" => "text", "value" => $data['source']],
            "body_var_4" => ["type" => "text", "value" => $data['boarding_point']],
            "body_var_5" => ["type" => "text", "value" => $data['destination']],
            "body_var_6" => ["type" => "text", "value" => $data['dropping_point']],
            "body_var_7" => ["type" => "text", "value" => $data['busname']],
            "body_var_8" => ["type" => "text", "value" => $data['busNumber']],
            "body_var_9" => ["type" => "text", "value" => $formattedDate],
            "body_var_10" => ["type" => "text", "value" => $departureTime],
            "body_var_11" => ["type" => "text", "value" => $passengerText],
            "body_var_12" => ["type" => "text", "value" => implode(',', $data['seat_no']->toArray())],
            // "body_var_13" => ["type" => "text", "value" => implode(',', $data['seat_no']->toArray())],
            "body_var_13" => ["type" => "text", "value" => $data['conductor_number']],
            "button_1" => ["type" => "text", "value" => "https://play.google.com/store/apps/details?id=com.od.odbus&pli=1"],
            "button_2" => ["type" => "text", "value" => $data['pnr']],
            // "button_2" => ["type" => "text", "value" => config('msg91.pdf_url') . $data['pnr']],
            // "button_2" => ["type" => "text", "value" => "https://www.odbus.in/pnr/" . $data['pnr']],


            "var1" => ["type" => "text", "value" => $data['name']],
            "var2" => ["type" => "text", "value" => $data['pnr']],
            "var3" => ["type" => "text", "value" => $data['source']],
            "var4" => ["type" => "text", "value" => $data['destination']],
            "var5" => ["type" => "text", "value" => $data['busname']],
            "var6" => ["type" => "text", "value" => $data['busNumber']],
            "var7" => ["type" => "text", "value" => $formattedDate],
            "var8" => ["type" => "text", "value" => $departureTime],
            "var9" => ["type" => "text", "value" => $passengerText],
            "var10" => ["type" => "text", "value" => implode(',', $data['seat_no']->toArray())],
            "var11" => ["type" => "text", "value" => $data['fare']],
            "var12" => ["type" => "text", "value" => $data['conductor_number']],

        ];

        // return $variables;

        $campaignName = config('msg91.campaigns.customer_ticket_booking');
        $url = config('msg91.campaign_base_url') . $campaignName . '/run';
        // $url = "https://control.msg91.com/api/v5/campaign/api/campaigns/customer-ticket-booking/run";
        $to = [];

        $to[] = [
            "mobiles" => "91" . $data['phone'],
            "variables" => $variables
        ];

        $postData = [
            "data" => [
                "sendTo" => [
                    [
                        "to" => $to,
                        "variables" => $variables
                    ]
                ]
            ]
        ];

        // return $postData;


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response, true);
    }

    // CMO SMS SEND ON TICKET BOOKING
    public function cmo_ticket_booking($data)
    {
        $busId = $data['busId'];

        $getNumber = BusContacts::where('bus_id', $busId)
            ->where('status', '1')
            ->where('booking_sms_send', 1)
            ->get(['phone']);

        $passengers = $data['passengerDetails'];

        $firstPassenger = $passengers[0]['passenger_name'] ?? '';

        $count = count($passengers);

        $maleCount = collect($passengers)->where('passenger_gender', 'M')->count();
        $femaleCount = collect($passengers)->where('passenger_gender', 'F')->count();

        $parts = [];

        if ($maleCount > 0) {
            $parts[] = $maleCount . 'M';
        }

        if ($femaleCount > 0) {
            $parts[] = $femaleCount . 'F';
        }
        $totalCount = implode(',', $parts);

        $passengerText = $firstPassenger . '(' . $totalCount . ')';

        $formattedDate = Carbon::parse($data['journeydate'])->format('d-M-Y');
        $departureTime = Carbon::parse($data['departureTime'])->format('H:i');

        $variables = [

            "header_1" => [
                "type" => "image",
                "value" => config('msg91.template_image_url')
            ],

            "body_var_1" => ["type" => "text", "value" => $data['pnr']],
            "body_var_2" => ["type" => "text", "value" => $data['busname']],
            "body_var_3" => ["type" => "text", "value" => $data['busNumber']],
            "body_var_4" => ["type" => "text", "value" => $formattedDate],
            "body_var_5" => ["type" => "text", "value" => $departureTime],
            "body_var_6" => ["type" => "text", "value" => $data['source']],
            "body_var_7" => ["type" => "text", "value" => $data['boarding_point']],
            "body_var_8" => ["type" => "text", "value" => $data['destination']],
            "body_var_9" => ["type" => "text", "value" => $data['dropping_point']],
            "body_var_10" => ["type" => "text", "value" => $passengerText],
            "body_var_11" => ["type" => "text", "value" => implode(',', $data['seat_no']->toArray())],
            "body_var_12" => ["type" => "text", "value" => $data['phone']],


            "var1" => ["type" => "text", "value" => $data['pnr']],
            "var2" => ["type" => "text", "value" => $data['busname']],
            "var3" => ["type" => "text", "value" => $data['busNumber']],
            "var4" => ["type" => "text", "value" => $formattedDate],
            "var5" => ["type" => "text", "value" => $departureTime],
            "var6" => ["type" => "text", "value" => $data['source']],
            "var7" => ["type" => "text", "value" => $data['destination']],
            "var8" => ["type" => "text", "value" => $passengerText],
            "var9" => ["type" => "text", "value" => implode(',', $data['seat_no']->toArray())],
            "var10" => ["type" => "text", "value" => $data['phone']],

        ];

        $to = [];

        $campaignName = config('msg91.campaigns.cmo_ticket_booking');
        $url = config('msg91.campaign_base_url') . $campaignName . '/run';

        // $url = "https://control.msg91.com/api/v5/campaign/api/campaigns/cmo-ticket-booking-flow/run";

        // foreach ($getNumber as $number) {
        //     if (!empty($number->phone)) {
        //         $to[] = [
        //             "mobiles" => "91" . trim($number->phone),
        //             "variables" => $variables
        //         ];
        //     }
        // }

        foreach ($getNumber as $record) {
            $phones = explode(',', $record->phone);
            foreach ($phones as $phone) {
                $phone = trim($phone);
                if (!empty($phone)) {
                    $to[] = [
                        "mobiles" => "91" . $phone,
                        "variables" => $variables
                    ];
                }
            }
        }

        $postData = [
            "data" => [
                "sendTo" => [
                    [
                        "to" => $to,
                        "variables" => $variables
                    ]
                ]
            ]
        ];

        // return $postData;



        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response, true);
    }


    //cancel ticket sms send to customer
    public function sendSmsTicketCancel($data)
    {
        // return $data;
        $journeydate = Carbon::parse($data['journeydate'])->format('d-M-Y');
        $variables = [

            "header_1" => [
                "type" => "image",
                "value" => config('msg91.template_image_url')
            ],

            "body_var_1" => ["type" => "text", "value" => $data['name']],
            "body_var_2" => ["type" => "text", "value" => $data['pnr']],
            "body_var_3" => ["type" => "text", "value" => $data['bus_name']],
            "body_var_4" => ["type" => "text", "value" => $data['bus_number']],
            "body_var_5" => ["type" => "text", "value" => $data['from']],
            "body_var_6" => ["type" => "text", "value" => $data['to']],
            "body_var_7" => ["type" => "text", "value" => $journeydate],
            "body_var_8" => ["type" => "text", "value" => implode(',', $data['seat_no'])],
            "body_var_9" => ["type" => "text", "value" => $data['refundAmount']],

            "button_1" => ["type" => "text", "value" => "https://play.google.com/store/apps/details?id=com.od.odbus&pli=1"],


            "var1" => ["type" => "text", "value" => $data['name']],
            "var2" => ["type" => "text", "value" => $data['pnr']],
            "var3" => ["type" => "text", "value" => $data['bus_name']],
            "var4" => ["type" => "text", "value" => $data['bus_number']],
            "var5" => ["type" => "text", "value" => $data['from']],
            "var6" => ["type" => "text", "value" => $data['to']],
            "var7" => ["type" => "text", "value" => $journeydate],
            "var8" => ["type" => "text", "value" => implode(',', $data['seat_no'])],
            "var9" => ["type" => "text", "value" => $data['refundAmount']],

        ];

        // return $variables;

        $campaignName = config('msg91.campaigns.customer_ticket_cancellation');
        $url = config('msg91.campaign_base_url') . $campaignName . '/run';
        // $url = "https://control.msg91.com/api/v5/campaign/api/campaigns/customer-ticket-cancellation-flow/run";

        $to[] = [
            "mobiles" => "91" . $data['contactNo'],
            "variables" => $variables
        ];

        $postData = [
            "data" => [
                "sendTo" => [
                    [
                        "to" => $to,
                        "variables" => $variables
                    ]
                ]
            ]
        ];


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response, true);
    }

    // CMO SMS SEND ON TICKET CANCEL
    public function cmo_ticket_cancel($data)
    {
        $busId = $data['busId'];

        $getNumber = BusContacts::where('bus_id', $busId)
            ->where('status', '1')
            ->where('booking_sms_send', 1)
            ->get(['phone']);

        $journeydate = Carbon::parse($data['journeydate'])->format('d-M-Y');
        $variables = [

            "header_1" => [
                "type" => "image",
                "value" => config('msg91.template_image_url')
            ],

            "body_var_1" => ["type" => "text", "value" => $data['pnr']],
            "body_var_2" => ["type" => "text", "value" => $data['bus_name']],
            "body_var_3" => ["type" => "text", "value" => $data['bus_number']],
            "body_var_4" => ["type" => "text", "value" => $data['from']],
            "body_var_5" => ["type" => "text", "value" => $data['to']],
            "body_var_6" => ["type" => "text", "value" => $journeydate],
            "body_var_7" => ["type" => "text", "value" => implode(',', $data['seat_no'])],


            "var1" => ["type" => "text", "value" => $data['pnr']],
            "var2" => ["type" => "text", "value" => $data['bus_name']],
            "var3" => ["type" => "text", "value" => $data['bus_number']],
            "var4" => ["type" => "text", "value" => $data['from']],
            "var5" => ["type" => "text", "value" => $data['to']],
            "var6" => ["type" => "text", "value" => $journeydate],
            "var7" => ["type" => "text", "value" => implode(',', $data['seat_no'])],

        ];

        // return $variables;

        $to = [];

        $campaignName = config('msg91.campaigns.cmo_ticket_cancellation');
        $url = config('msg91.campaign_base_url') . $campaignName . '/run';

        // $url = "https://control.msg91.com/api/v5/campaign/api/campaigns/cmo-ticket-cancellation/run";


        foreach ($getNumber as $record) {
            $phones = explode(',', $record->phone);
            foreach ($phones as $phone) {
                $phone = trim($phone);
                if (!empty($phone)) {
                    $to[] = [
                        "mobiles" => "91" . $phone,
                        "variables" => $variables
                    ];
                }
            }
        }

        $postData = [
            "data" => [
                "sendTo" => [
                    [
                        "to" => $to,
                        "variables" => $variables
                    ]
                ]
            ]
        ];


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response, true);
    }


    //Agent Booking
    public function agent_ticket_booking($data)
    {
        $formattedDate = Carbon::parse($data['journeydate'])->format('d-M-Y');
        $departureTime = Carbon::parse($data['departureTime'])->format('H:i');
        $passengers = $data['passengerDetails'];
        $firstPassenger = $passengers[0]['passenger_name'] ?? '';
        $count = count($passengers);

        $maleCount = collect($passengers)->where('passenger_gender', 'M')->count();
        $femaleCount = collect($passengers)->where('passenger_gender', 'F')->count();

        $parts = [];

        if ($maleCount > 0) {
            $parts[] = $maleCount . 'M';
        }

        if ($femaleCount > 0) {
            $parts[] = $femaleCount . 'F';
        }
        $totalCount = implode(',', $parts);

        $passengerText = $firstPassenger . '(' . $totalCount . ')';

        $variables = [

            "header_1" => [
                "type" => "image",
                "value" => config('msg91.template_image_url')
            ],

            "body_var_1" => ["type" => "text",  "value" => $data['name']],
            "body_var_2" => ["type" => "text", "value" => $data['pnr']],
            "body_var_3" => ["type" => "text", "value" => $data['source']],
            "body_var_4" => ["type" => "text", "value" => $data['boarding_point']],
            "body_var_5" => ["type" => "text", "value" => $data['destination']],
            "body_var_6" => ["type" => "text", "value" => $data['dropping_point']],
            "body_var_7" => ["type" => "text", "value" => $data['busname']],
            "body_var_8" => ["type" => "text", "value" => $data['busNumber']],
            "body_var_9" => ["type" => "text", "value" => $formattedDate],
            "body_var_10" => ["type" => "text", "value" => $departureTime],
            "body_var_11" => ["type" => "text", "value" => $passengerText],
            "body_var_12" => ["type" => "text", "value" => implode(',', $data['seat_no']->toArray())],
            "body_var_13" => ["type" => "text", "value" => $data['conductor_number']],
            "body_var_14" => ["type" => "text", "value" => $data['agent_name']],
            "body_var_15" => ["type" => "text", "value" => $data['agent_Number']],
            "button_1" => ["type" => "text", "value" => "https://play.google.com/store/apps/details?id=com.od.odbus&pli=1"],
            "button_2" => ["type" => "text", "value" => config('msg91.pdf_url') . $data['pnr']],
            // "button_2" => ["type" => "text", "value" => "https://www.odbus.in/pnr/" . $data['pnr']],


            "var1" => ["type" => "text", "value" => $data['name']],
            "var2" => ["type" => "text", "value" => $data['pnr']],
            "var3" => ["type" => "text", "value" => $data['source']],
            "var4" => ["type" => "text", "value" => $data['destination']],
            "var5" => ["type" => "text", "value" => $data['busname']],
            "var6" => ["type" => "text", "value" => $data['busNumber']],
            "var7" => ["type" => "text", "value" => $formattedDate],
            "var8" => ["type" => "text", "value" => $departureTime],
            "var9" => ["type" => "text", "value" => $passengerText],
            "var10" => ["type" => "text", "value" => implode(',', $data['seat_no']->toArray())],
            "var11" => ["type" => "text", "value" => $data['fare']],
            "var12" => ["type" => "text", "value" => $data['conductor_number']],
            "var13" => ["type" => "text", "value" => $data['agent_Number']],

        ];

        // return $variables;

        $campaignName = config('msg91.campaigns.agent_ticket_booking');
        $url = config('msg91.campaign_base_url') . $campaignName . '/run';
        // $url = "https://control.msg91.com/api/v5/campaign/api/campaigns/customer-ticket-booking/run";
        $to = [];

        $to[] = [
            "mobiles" => "91" . $data['phone'],
            "variables" => $variables
        ];

        $postData = [
            "data" => [
                "sendTo" => [
                    [
                        "to" => $to,
                        "variables" => $variables
                    ]
                ]
            ]
        ];

        // return $postData;


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response, true);
    }

    public function agent_ticket_cancel($data)
    {
        $formattedDate = Carbon::parse($data['journeydate'])->format('d-M-Y');

        $variables = [

            "header_1" => [
                "type" => "image",
                "value" => config('msg91.template_image_url')
            ],

            "body_var_1" => ["type" => "text",  "value" => $data['passenger_name']],
            "body_var_2" => ["type" => "text", "value" => $data['pnr']],
            "body_var_3" => ["type" => "text", "value" => $data['bus_name']],
            "body_var_4" => ["type" => "text", "value" => $data['bus_number']],
            "body_var_5" => ["type" => "text", "value" => $data['from']],
            "body_var_6" => ["type" => "text", "value" => $data['to']],
            "body_var_7" => ["type" => "text", "value" => $formattedDate],
            "body_var_8" => ["type" => "text", "value" => implode(',', $data['seat_no'])],
            "body_var_9" => ["type" => "text", "value" => $data['refundAmount']],
            "body_var_10" => ["type" => "text", "value" => $data['agentName']],
            "body_var_11" => ["type" => "text", "value" => $data['agentNumber']],
            "button_1" => ["type" => "text", "value" => "https://play.google.com/store/apps/details?id=com.od.odbus&pli=1"],


            "var1" => ["type" => "text", "value" => $data['passenger_name']],
            "var2" => ["type" => "text", "value" => $data['pnr']],
            "var3" => ["type" => "text", "value" => $data['bus_name']],
            "var4" => ["type" => "text", "value" => $data['bus_number']],
            "var5" => ["type" => "text", "value" => $data['from']],
            "var6" => ["type" => "text", "value" => $data['to']],
            "var7" => ["type" => "text", "value" => $formattedDate],
            "var8" => ["type" => "text", "value" => implode(',', $data['seat_no'])],
            "var9" => ["type" => "text", "value" => $data['refundAmount']],
            "var10" => ["type" => "text", "value" => $data['agentName']],
            "var11" => ["type" => "text", "value" => $data['agentNumber']],

        ];

        // return $variables;

        $campaignName = config('msg91.campaigns.agent_ticket_cancellation');
        $url = config('msg91.campaign_base_url') . $campaignName . '/run';
        // $url = "https://control.msg91.com/api/v5/campaign/api/campaigns/customer-ticket-booking/run";
        $to = [];

        $to[] = [
            "mobiles" => "91" . $data['phone'],
            "variables" => $variables
        ];

        $postData = [
            "data" => [
                "sendTo" => [
                    [
                        "to" => $to,
                        "variables" => $variables
                    ]
                ]
            ]
        ];

        // return $postData;


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response, true);
    }



    //Dolphin
    public function dolphinBookingSms($mobile, $data)
    {
        // return config('msg91.templates.Dolphin_Booking_msg');
        $postData = array_merge([
            "flow_id" => config('msg91.templates.Dolphin_Booking_msg'),
            "mobiles" => "91" . $mobile,
        ], $data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.msg91.com/api/v5/flow/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                'authkey: ' . config('msg91.MSG91_AUTH_KEY'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
}
