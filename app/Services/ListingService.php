<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\ListingRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ListingService
{
    
    protected $listingRepository;    
    public function __construct(ListingRepository $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }
    public function getAll(Request $request)
    {
        return $this->listingRepository->getAll($request);
    }

    public function getLocation(Request $request)
    {
        return $this->listingRepository->getLocation($request);
    }

    public function filter(Request $request)
    {
        return $this->listingRepository->filter($request);
    }

    public function getFilterOptions(Request $request)
    {
        return $this->listingRepository->getFilterOptions($request);
    }
    
   
}