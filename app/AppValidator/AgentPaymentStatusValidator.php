<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgentPaymentStatusValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'transaction_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'routedetails' => 'required',    
            'bookingdate' => 'required',    
            'journeydate' => 'required',    
            'boarding_point' => 'required',    
            'departureTime' => 'required', 
            'dropping_point' => 'required',
            'arrivalTime' => 'required',
            'seat_id' => 'required',
            'seat_no' => 'required',
            'bus_id' => 'required',    
            'source' => 'required',    
            'destination' => 'required',    
            'busname' => 'required',    
            'busNumber' => 'required',
            'bustype' => 'required',    
            'busTypeName' => 'required',    
            'sittingType' => 'required',    
            'conductor_number' => 'required',    
            'passengerDetails' => 'required'
        ];      
      
        $agentPayemntStatusValidator = Validator::make($data, $rules);
        return $agentPayemntStatusValidator;
    }

}