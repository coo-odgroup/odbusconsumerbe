<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\SocialMedia;
use App\Models\OdbusCharges;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use DateTime;

class CommonRepository
{
    protected $banner;
    protected $socialMedia;
    protected $odbusCharges;

    public function __construct(Banner $banner, SocialMedia $socialMedia, OdbusCharges $odbusCharges)
    {
        $this->banner = $banner;
        $this->socialMedia = $socialMedia;
        $this->odbusCharges = $odbusCharges;
    }   
    
    public function getAll($request)
    { 
        $data['banner']=$this->banner->where('bus_operator_id','=',$request['bus_operator_id'])->get();
        $data['socialMedia']=$this->socialMedia->where('bus_operator_id','=',$request['bus_operator_id'])->get();
        $data['common']=$this->odbusCharges->where('bus_operator_id','=',$request['bus_operator_id'])->get();
        return $data;
    }

   

}