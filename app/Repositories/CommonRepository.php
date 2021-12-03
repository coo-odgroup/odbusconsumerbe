<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\SocialMedia;
use App\Models\OdbusCharges;
use App\Models\Pathurls;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use DateTime;

class CommonRepository
{
    protected $banner;
    protected $socialMedia;
    protected $odbusCharges;

    public function __construct(Banner $banner, SocialMedia $socialMedia,
     OdbusCharges $odbusCharges,Pathurls $pathurls)
    {
        $this->banner = $banner;
        $this->socialMedia = $socialMedia;
        $this->odbusCharges = $odbusCharges;
        $this->pathurls = $pathurls;
    }
    
    public function getPathurls(){
        return $this->pathurls->get();
    }
    
    public function getOperatorBanner($bus_operator_id,$today)
    { 
        return $this->banner->where('bus_operator_id','=',$bus_operator_id)
                            ->where("status",1)
                            ->where("start_date","<=",$today)
                            ->where("end_date",">=",$today)
                            ->select('id','bus_operator_id','heading','occassion','category','url',
                             'banner_img','banner_image','alt_tag')
                            ->get();
        
    }

    public function getOperatorSocialMedia($bus_operator_id)
    { 
        return $this->socialMedia->where('bus_operator_id','=',$bus_operator_id)->get();
        
    }

    public function getCommonSettings($bus_operator_id)
    { 
        return $this->odbusCharges->where('bus_operator_id','=',$bus_operator_id)->get();
        
    }

   

}