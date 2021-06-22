<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users',
            'password' => 'required|alpha_num|min:5',
            'created_by' => 'required',
        ];      
      
        $UsersValidation = Validator::make($data, $rules);
        return $UsersValidation;
    }

}