<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;

class DolphinService
{
 
  protected $soapWrapper;

  use ApiResponser;

  public function __construct(SoapWrapper $soapWrapper)
  {
    $this->soapWrapper = $soapWrapper;
    $this->verifyCall=["verifyCall" => "dK86BF3S7KJbPrdF94qzvjm8xanYN9a7egb84bp59Fw93J8FdwHM"];
  }

  public function GetCityPair() 
  {
    $this->soapWrapper->add('GetCityPair', function ($service) {
        $service
          ->wsdl('http://apislvV2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });
  
      $response = $this->soapWrapper->call('GetCityPair.GetCityPair', [$this->verifyCall]);
      $data=$this->xmlToArray($response->GetCityPairResult->any);
      $data=$data['DocumentElement']['ITSCityPair'];  
      return $this->successResponse($data,Config::get('constants.RECORD_FETCHED'), Response::HTTP_ACCEPTED);
  
  
  }

  public function xmlToArray($xmlstring){
    
    $result = \explode('</xs:schema>', $xmlstring);
    $array = json_decode(json_encode((array)simplexml_load_string($result[1])),true);
  
    return $array;
  
  }

}
