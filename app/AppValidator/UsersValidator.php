<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'name' => 'required|max:50',
            //'email' => 'unique:users,NULL',
            'phone' => 'required_without:email|nullable|sometimes|unique:users',
            
            //'email' => 'exists:email,NULL',
            'email' => 'required_without:phone|nullable|sometimes|unique:users',
            'created_by' => 'required',
        ];      
      
        $UsersValidation = Validator::make($data, $rules);
        return $UsersValidation;
    }

}