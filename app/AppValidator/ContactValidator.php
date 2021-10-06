<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'service' => 'required',
            'message' => 'required'
        ];      
      
        $ContactValidation = Validator::make($data, $rules);
        return $ContactValidation;
    }

}