<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeoValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'bus_operator_id' => 'required',
        ];      
      
        $seoValidator = Validator::make($data, $rules);
        return $seoValidator;
    }

}