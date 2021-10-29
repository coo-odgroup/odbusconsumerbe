<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;

class SoapController
{
  /**
   * @var SoapWrapper
   */
  protected $soapWrapper;

  use ApiResponser;

  /**
   * SoapController constructor.
   *
   * @param SoapWrapper $soapWrapper
   */
  public function __construct(SoapWrapper $soapWrapper)
  {
    $this->soapWrapper = $soapWrapper;
  }

  /**
   * Use the SoapWrapper
   */
  public function getCountries(Request $request) 
  {
    $this->soapWrapper->add('Countries', function ($service) {
      $service
        ->wsdl('http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL')
        ->trace(true);
    });

    $response = $this->soapWrapper->call('Countries.ListOfCountryNamesByName', [$request]);

    return $this->successResponse($response->ListOfCountryNamesByNameResult->tCountryCodeAndName,Config::get('constants.RECORD_FETCHED'), Response::HTTP_ACCEPTED);
  
  }
}
