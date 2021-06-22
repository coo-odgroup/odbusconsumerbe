<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\ViewSeatsRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

class ViewSeatsService
{
    protected $viewSeatsRepository;    
    public function __construct(ViewSeatsRepository $viewSeatsRepository)
    {
        $this->viewSeatsRepository = $viewSeatsRepository;
    }
    public function getAllViewSeats(Request $request)
    {
        return $this->viewSeatsRepository->getAllViewSeats($request);
    }

    public function getPriceOnSeatsSelection(Request $request)
    {
        return $this->viewSeatsRepository->getPriceOnSeatsSelection($request);
    }
    public function getBoardingDroppingPoints(Request $request)
    {
        return $this->viewSeatsRepository->getBoardingDroppingPoints($request);
    }

}