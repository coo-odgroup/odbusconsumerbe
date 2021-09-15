<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\BookTicketService;
use App\AppValidator\BookTicketValidator;

class BookTicketController extends Controller
{

    use ApiResponser;
    /**
     * @var bookTicketService
     */
    protected $bookTicketService;
    protected $bookTicketValidator;
    /**
     * BookTicketController Constructor
     *
     * @param BookTicketService $bookTicketService
     *
     */
    public function __construct(BookTicketService $bookTicketService,BookTicketValidator $bookTicketValidator)
    {
        $this->bookTicketService = $bookTicketService;  
        $this->bookTicketValidator = $bookTicketValidator;      
    }

/**
 * @OA\Post(
 *     path="/api/BookTicket",
 *     tags={"BookTicket API"},
 *     summary="Ticket Booking with customer details",
 *     @OA\RequestBody(
 *        required = true,
 *     description="Ticket Booking with customer details",
 *        @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                property="customerInfo",
 *                type="object",
 *                @OA\Property(
 *                  property="email",
 *                  type="string",
 *                  default="abc@gmail.com",
 *                  example="abc@gmail.com"
 *                  ),
 *                @OA\Property(
 *                  property="phone",
 *                  type="number",
 *                  default=9912345678,
 *                  example=9912345678
 *                  ),
 *                @OA\Property(
 *                  property="name",
 *                  type="string",
 *                  default="Bob",
 *                  example="Bob"
 *                  )
 *                ),

 *             @OA\Property(
 *                property="bookingInfo",
 *                type="object",
 *                @OA\Property(
 *                  property="bus_id",
 *                  type="number",
 *                  default=12,
 *                  example=12
 *                  ),
 *                @OA\Property(
 *                  property="source_id",
 *                  type="number",
 *                  default=1291,
 *                  example=1291
 *                  ),
 *                @OA\Property(
 *                  property="destination_id",
 *                  type="number",
 *                  default=1294,
 *                  example=1294
 *                  ),
 *                @OA\Property(
 *                  property="journey_dt",
 *                  type="string",
 *                  default="2021-08-16",
 *                  example="2021-08-16" ,
 *                  ),
 *                @OA\Property(
 *                  property="boarding_point",
 *                  type="string",
 *                  default="Bermunda",
 *                  example="Bermunda" ,
 *                  ),
 *                @OA\Property(
 *                  property="dropping_point",
 *                  type="string",
 *                  default="bus stand",
 *                  example="bus stand" ,
 *                  ),
 *                @OA\Property(
 *                  property="boarding_time",
 *                  type="string",
 *                  default="21:00",
 *                  example="21:00" ,
 *                  ),
 *                @OA\Property(
 *                  property="dropping_time",
 *                  type="string",
 *                  default="06:30",
 *                  example="06:30" ,
 *                  ),
 *                @OA\Property(
 *                  property="origin",
 *                  type="string",
 *                  default="ODBUS",
 *                  example="ODBUS" ,
 *                  ),
 *                @OA\Property(
 *                  property="app_type",
 *                  type="string",
 *                  default="WEB",
 *                  example="WEB" ,
 *                  ),
 *                @OA\Property(
 *                  property="typ_id",
 *                  type="number",
 *                  default="1",
 *                  example="1" ,
 *                  ),
 *                @OA\Property(
 *                  property="total_fare",
 *                  type="double",
 *                  default="1000",
 *                  example="1000" ,
 *                  ),
 *                @OA\Property(
 *                  property="owner_fare",
 *                  type="double",
 *                  default="900",
 *                  example="900" ,
 *                  ),
 *                @OA\Property(
 *                  property="odbus_service_Charges",
 *                  type="double",
 *                  default="70",
 *                  example="70" ,
 *                  ),
 *                @OA\Property(
 *                  property="odbus_gst_charges",
 *                  type="number",
 *                  default="5",
 *                  example="5" ,
 *                  ),
 *                @OA\Property(
 *                  property="odbus_gst_amount",
 *                  type="double",
 *                  default="50",
 *                  example="50" ,
 *                  ),
 *                @OA\Property(
 *                  property="owner_gst_charges",
 *                  type="number",
 *                  default="5",
 *                  example="5" ,
 *                  ),
 *                @OA\Property(
 *                  property="owner_gst_amount",
 *                  type="double",
 *                  default="50",
 *                  example="50" ,
 *                  ),
 *                @OA\Property(
 *                  property="created_by",
 *                  type="string",
 *                  default="Customer",
 *                  example="Customer" ,
 *                  ),
 *                 @OA\Property(
 *                  property="bookingDetail",
 *                  type="array",
 *                  example={{
 *                    "bus_seats_id" : "31",
 *                    "passenger_name": "Bob",
 *                    "passenger_gender": "M",
 *                    "passenger_age": "22",
 *                    "created_by": "Customer"
 *                  }, {
 *                    "bus_seats_id" : "32",
 *                    "passenger_name": "Mom",
 *                    "passenger_gender": "F",
 *                    "passenger_age": "20",
 *                    "created_by": "Customer"
 *                  }},
 *                  @OA\Items(
 *                      @OA\Property(
 *                         property="bus_seats_id",
 *                         type="string",
 *                         example="ST1"
 *                      ),
 *                      @OA\Property(
 *                         property="passenger_name",
 *                         type="string",
 *                         example="Bob"
 *                      ),
 *                      @OA\Property(
 *                         property="passenger_gender",
 *                         type="string",
 *                         example="M"
 *                      ),
 *                      @OA\Property(
 *                         property="passenger_age",
 *                         type="string",
 *                         example="22"
 *                      ),
 *                      @OA\Property(
 *                         property="created_by",
 *                         type="string",
 *                         example="Customer"
 *                      ),
 *                    ),
 *                  ),
 *                ),
 *              ),
 *  ),
 *     @OA\Response(response="201", description="records added"),
 *     @OA\Response(response="404", description="not found"),
 * )
 * 
 */



    public function bookTicket(Request $request) {
         $data = $request->all();
           $bookTicketValidation = $this->bookTicketValidator->validate($data);
   
        if ($bookTicketValidation->fails()) {
        $errors = $bookTicketValidation->errors();
        return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 
          try {
           $response =  $this->bookTicketService->bookTicket($request);  
            return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }      
    } 
}
