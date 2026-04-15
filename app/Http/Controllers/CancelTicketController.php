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
use App\AppValidator\CancelTicketValidator;
use App\Models\CustomerPaymentLog;
use App\Repositories\ChannelRepository;


class CancelTicketController extends Controller
{

  use ApiResponser;
  /**
   * @var cancelTicketService
   */
  protected $cancelTicketService;
  protected $cancelTicketValidator;
  protected $channelRepository;

  /**
   * cancelTicketController Constructor
   *
   * @param CancelTicketService $cancelTicketService
   *
   */
  public function __construct(CancelTicketService $cancelTicketService, ChannelRepository $channelRepository, CancelTicketValidator $cancelTicketValidator)
  {
    $this->cancelTicketService = $cancelTicketService;
    $this->cancelTicketValidator = $cancelTicketValidator;
    $this->channelRepository = $channelRepository;
  }

  public function CancelDolphinSeat(Request $request)
  {

    $data = $request->all();
    try {
      $response =  $this->cancelTicketService->CancelDolphinSeat($request);
      return $this->successResponse($response, Config::get('constants.REFUND_INITIATED'), Response::HTTP_CREATED);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
    }
  }

  public function cancelTicket(Request $request)
  {
    $data = $request->all();
    $cancelTicketValidator = $this->cancelTicketValidator->validate($data);

    if ($cancelTicketValidator->fails()) {
      $errors = $cancelTicketValidator->errors();
      return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      // Return Remove this line later
      return $response =  $this->cancelTicketService->cancelTicket($request);
      if ($response == 'refunded') {
        return $this->successResponse($response, Config::get('constants.REFUNDED_COMPLETED'));
      } elseif ($response == 'PNR_NOT_MATCH') {
        return $this->errorResponse(Config::get('constants.PNR_NOT_MATCH'), Response::HTTP_PARTIAL_CONTENT);
      } elseif ($response == 'MOBILE_NOT_MATCH') {
        return $this->errorResponse(Config::get('constants.MOBILE_NOT_MATCH'), Response::HTTP_PARTIAL_CONTENT);
      } elseif ($response == 'Ticket_already_cancelled') {
        return $this->errorResponse("Ticket Already cancelled. Please contact Odbus Support Team", Response::HTTP_PARTIAL_CONTENT);
      } else {
        return $this->successResponse($response, Config::get('constants.REFUND_INITIATED'), Response::HTTP_CREATED);
      }
      // elseif($response == 'noPayment'){
      //   return $this->successResponse($response,Config::get('constants.NO_PAYMENT'));
      // }

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
    }
  }


  public function fetchRefundStatus(Request $request)
  {
    try {
      $bookingId = $request->booking_id;
      $response = CustomerPaymentLog::where('booking_id', $bookingId)->get(['refund_status','created_at']);
      return $this->successResponse($response, Response::HTTP_OK);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
    }
  }
}
