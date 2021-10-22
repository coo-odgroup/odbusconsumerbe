<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use DateTime;

class CommonRepository
{
    protected $banner;

    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }   
    
    public function getAll($request)
    { 
        $data=$this->banner->where('bus_operator_id','=',$request['bus_operator_id'])->get();
        return $data;
    }

   

}