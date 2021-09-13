<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'pnr' => 'required',
            'bus_id' => 'required',
            'customer_id' => 'required',
            'reference_key' => 'required',
            'rating_overall' => 'required',
            'rating_comfort' => 'required',
            'rating_clean' => 'required',
            'rating_behavior' => 'required',
            'rating_timing' => 'required',
            'comments' => 'required',
            'created_by'=> 'required'
        ];      
      
        $reviewValidator = Validator::make($data, $rules);
        return $reviewValidator;
    }

}