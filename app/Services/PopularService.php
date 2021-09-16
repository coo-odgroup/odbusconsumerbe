<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Repositories\PopularRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

class PopularService
{
    protected $popularRepository;    
    public function __construct(PopularRepository $popularRepository)
    {
        $this->popularRepository = $popularRepository;
    }
    public function getPopularRoutes(Request $request)
    {
        return $this->popularRepository->getPopularRoutes($request);
    }
    public function getTopOperators(Request $request)
    {
        return $this->popularRepository->getTopOperators($request);
    }
    public function allRoutes(Request $request)
    {
        return $this->popularRepository->allRoutes($request);
    }
    public function allOperators(Request $request)
    {
        return $this->popularRepository->allOperators($request);
    }
    public function operatorDetails(Request $request)
    {
        return $this->popularRepository->operatorDetails($request);
    }
}