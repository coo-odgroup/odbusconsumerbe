<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookTicketValidator 
{   

    public function validate($data) { 
        
        $rules = [
          
            'transaction_id' => 'required',
            'pnr' => 'required',
            'booking_customer_id' => 'required',
            'bus_operator_id' => 'required',
            'bus_id' => 'required',
            'source_id' => 'required',
            'destination_id' => 'required',
            'j_day' => 'required',
            'journey_dt' => 'required',
            'boarding_droping_id' => 'required',
            'boarding_time' => 'required',
            'dropping_time' => 'required',
            'total_fare' => 'required',
            'ownr_fare' => 'required',
            'bookingDetail' => 'required',
            

        ];      
      
        $busTicketValidation = Validator::make($data, $rules);
        return $busTicketValidation;
    }

}