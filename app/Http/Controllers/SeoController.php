<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\AppValidator\SeoValidator;
use App\Services\SeoService;


class SeoController extends Controller
{
    use ApiResponser;
    protected $seoValidator;
    protected $seoService;

    public function __construct(SeoValidator $seoValidator, SeoService $seoService)
    {
        $this->seoValidator = $seoValidator;
        $this->seoService = $seoService;
    }

    public function seolist(Request $request){

        $data = $request->all();
        $seoValidation = $this->seoValidator->validate($data);

        if($seoValidation->fails()){
            $error = $seoValidation->errors();
            return $this->errorResponse($error->toJson(),Response::HTTP_PARTIAL_CONTENT);
        }else{
            try {
                $response = $this->seoService->getAll($request); 
                 return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
            }
            catch (Exception $e) {
                return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
            }
        }
    }
}
