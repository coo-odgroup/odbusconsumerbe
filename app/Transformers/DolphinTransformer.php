<?php

namespace App\Transformers;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use App\Services\DolphinService;
use App\Repositories\ListingRepository;


class DolphinTransformers
{

    protected $listingRepository; 
    protected $DolphinService;
   
    public function __construct(ListingRepository $listingRepository,DolphinService $DolphinService)
    {

        $this->listingRepository = $listingRepository;
        $this->DolphinService = $DolphinService;
        
    }
    
    public function BusList($request){

        $srcResult= $this->listingRepository->getLocationID($request['source']);
        $destResult= $this->listingRepository->getLocationID($request['destination']);

        $dolphinresult=[];

        if($srcResult[0]->is_dolphin==1 && $destResult[0]->is_dolphin==1){

            $dolphin_source=$srcResult[0]->dolphin_id;
            $dolphin_dest=$destResult[0]->dolphin_id;

            $dolphinresult= $this->DolphinService->GetAvailableRoutes($dolphin_source,$dolphin_dest,$entry_date);

        }

        return $dolphinresult;


    }
   
}