<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CommonService;

class CommonController extends Controller
{
    use ApiResponser;
    /**
     * @var cancelTicketService
     */
    protected $commonService;
    /**
     * cancelTicketController Constructor
     *
     * @param commonService $commonService
     *
     */
    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;      
    }
    public function getAll(Request $request) {
        
         try {
          $response =  $this->commonService->getAll($request);
           return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_PARTIAL_CONTENT);
       }
       catch (Exception $e) {
           return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
         }      
   } 
}