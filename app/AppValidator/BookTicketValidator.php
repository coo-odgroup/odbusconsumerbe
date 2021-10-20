<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookTicketValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'customerInfo.phone' => 'required'
        ];      
      
        $bookTicketValidation = Validator::make($data, $rules);
        return $bookTicketValidation;
    }

}