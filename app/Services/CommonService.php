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
    public function __construct(CommonRepository $commonRepository)
    {
        $this->commonRepository = $commonRepository;
    }
    public function getAll($request)
    {
        try {
            $data['banner']=$this->commonRepository->getOperatorBanner($request['bus_operator_id']);
            $data['socialMedia']=$this->commonRepository->getOperatorSocialMedia($request['bus_operator_id']);
            $data['common']=$this->commonRepository->getCommonSettings($request['bus_operator_id']);
       
            return $data;

        } catch (Exception $e) {
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
    }
}