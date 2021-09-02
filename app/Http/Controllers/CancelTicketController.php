<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CancelTicketService;

class CancelTicketController extends Controller
{

    use ApiResponser;
    /**
     * @var cancelTicketService
     */
    protected $cancelTicketService;
    /**
     * cancelTicketController Constructor
     *
     * @param CancelTicketService $cancelTicketService
     *
     */
    public function __construct(CancelTicketService $cancelTicketService)
    {
        $this->cancelTicketService = $cancelTicketService;      
    }

/**
 * @OA\Post(
 *     path="/api/CancelTicket",
 *     tags={"CancelTicket API"},
 *     description="refund initiated for ticket cancellation",
 *     summary="refund initiated for ticket cancellation",
 *     @OA\Parameter(
 *          name="pnr",
 *          description="pnr",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="phone",
 *          description="user phone",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Response(response="201", description=" refund initiated")
 * )
 * 
 */


    public function cancelTicket(Request $request) {
         try {
          $response =  $this->cancelTicketService->cancelTicket($request);  
           return $this->successResponse($response,Config::get('constants.REFUND_INITIATED'),Response::HTTP_CREATED);
       }
       catch (Exception $e) {
           return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
         }      
   } 
}