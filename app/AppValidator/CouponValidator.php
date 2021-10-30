<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponValidator 
{   
    public function validate($data) { 
        
        $rules = [
            'bus_id' => 'required',
            'source_id' => 'required',
            'destination_id' => 'required',
            'journey_date' => 'required',
            'bus_operator_id' => 'required',
            'total_fare' => 'required',
            'transaction_id' => 'required',
        ];      
      
        $couponValidator = Validator::make($data, $rules);
        return $couponValidator;
    }

}