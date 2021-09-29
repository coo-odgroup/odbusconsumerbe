<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CancelTicketValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'pnr' => 'required',
            'phone' => 'required'

        ];      
      
        $cancelTicketValidator = Validator::make($data, $rules);
        return $cancelTicketValidator;
    }

}