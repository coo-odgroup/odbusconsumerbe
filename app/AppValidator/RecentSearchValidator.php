<?php
namespace App\AppValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecentSearchValidator 
{   

    public function validate($data) { 
        
        $rules = [
            'users_id' => 'required',
            'source' => 'required',
            'destination' => 'required',
            'journey_date' => 'required',
        ];      
      
        $searchValidator = Validator::make($data, $rules);
        return $searchValidator;
    }

}