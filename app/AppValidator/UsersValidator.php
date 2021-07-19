<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersValidator 
{   

    public function validate($data) { 
        
        $rules = [
             'name' => 'required|max:50',
            'email' => 'required_without:phone',
            'phone' => 'required_without:email',
            'created_by' => 'required',
        ];      
      
        $UsersValidation = Validator::make($data, $rules);
        return $UsersValidation;
    }

}