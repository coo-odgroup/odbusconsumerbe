<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PopularService;

class PopularController extends Controller
{
    use ApiResponser;
    
    protected $popularService;
  
    public function __construct(PopularService $popularService)
    {
        $this->popularService = $popularService;       
    }
    public function getPopularRoutes(Request $request) {
        $popularRoutes = $this->popularService->getPopularRoutes($request);
        return $this->successResponse($popularRoutes,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
    public function getTopOperators(Request $request) {
        $topOperators = $this->popularService->getTopOperators($request);
        return $this->successResponse($topOperators,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
}