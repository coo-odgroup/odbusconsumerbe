<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Repositories\OfferRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class OfferService
{
    
    protected $offerRepository;    
    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }
    public function offers($request)
    {
        try {
            $offer = $this->offerRepository->offers($request);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $offer;
    }   
   
}