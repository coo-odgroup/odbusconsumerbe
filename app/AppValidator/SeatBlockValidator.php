<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeatBlockValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'busId' => 'required|numeric',
            'sourceId' => 'required|numeric',
            'destinationId' => 'required|numeric',
            'transaction_id' => 'required|numeric',
            'seatIds' => 'required|array|min:1',
            'entry_date' => 'required|date_format:d-m-Y',
        ];      
      
        $seatBlockValidation = Validator::make($data, $rules);
        return $seatBlockValidation;
    }

}