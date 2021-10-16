<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookTicketValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'customerInfo.phone' => 'required',
            'journey_dt' => 'required|date_format:"Y-m-d"'
        ];      
      
        $bookTicketValidation = Validator::make($data, $rules);
        return $bookTicketValidation;
    }

}