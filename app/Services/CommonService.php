<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class CommonService
{
    
    protected $commonRepository;    
    protected $pathurls;    
    public function __construct(CommonRepository $commonRepository)
    {
        $this->commonRepository = $commonRepository;
       
    }
    public function getAll($request)
    {
        $path= $this->commonRepository->getPathurls();
        $path= $path[0];
        try {
            $today=date("Y-m-d");
            $banner=$this->commonRepository->getOperatorBanner($request['bus_operator_id'],$today);
            $socialMedia=$this->commonRepository->getOperatorSocialMedia($request['bus_operator_id']);
            $common=$this->commonRepository->getCommonSettings($request['bus_operator_id']);

            $banner_image='';
            $common_data=[];

            if($banner && $banner[0] && $banner[0]->banner_image){

                $banner= $banner[0];
                 $banner_image =  $path->banner_url.$banner->banner_image;
            }

            if($common && $common[0]){

                $common_data= $common[0];
                
                 if($common_data->logo_image){
                    $common_data->logo_image = $path->logo_url.$common_data->logo_image;
                 }

                 if($common_data->favicon_image){
                    $common_data->favicon_image = $path->favicon_url.$common_data->favicon_image;
                  }

                  if($common_data->footer_logo){
                    $common_data->footer_logo = $path->logo_url.$common_data->footer_logo;
                  }
            }

            $data['banner_image']=$banner_image;
            $data['common']=$common_data;
            $data['socialMedia']=$socialMedia[0];
                   
            return $data;

        } catch (Exception $e) {
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
    }
}