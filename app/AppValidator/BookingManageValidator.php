<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingManageValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'pnr' => 'required',
            'mobile' => 'required'

        ];      
      
        $bookingManageValidator = Validator::make($data, $rules);
        return $bookingManageValidator;
    }

}