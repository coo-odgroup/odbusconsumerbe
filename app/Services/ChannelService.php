<?php

namespace App\Services;
use App\Models\CustomerNotification;
use App\Repositories\ChannelRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ChannelService
{
    protected $channelRepository;    
    public function __construct(ChannelRepository $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }
    public function sendSms($data)
    {
        try {
            $sendSms = $this->channelRepository->sendSms($data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $sendSms;
    }   

    public function sendEmail($data)
    {
        try {
            $sendEmail = $this->channelRepository->sendEmail($data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $sendEmail;
    }   

    public function makePayment($data)
    {
        try {
            $payment = $this->channelRepository->makePayment($data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $sendEmail;
    }   
   
}