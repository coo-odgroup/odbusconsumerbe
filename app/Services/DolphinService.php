<?php

namespace App\Services;

use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;


class DolphinService
{
 
  protected $soapWrapper;

  use ApiResponser;

  public function __construct(SoapWrapper $soapWrapper)
  {
    $this->soapWrapper = $soapWrapper;
    $this->option=["verifyCall" => "dK86BF3S7KJbPrdF94qzvjm8xanYN9a7egb84bp59Fw93J8FdwHM"];
    
  }


  public function GetAvailableRoutes($s,$d,$dt) 
  {

    $result=[];

    $this->soapWrapper->add('GetAvailableRoutes', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

       $option=array(
              "FromID"=> $s,
              "ToID"=>$d,
              "JourneyDate"=>$dt,
              "VerifyCall"=>$this->option['verifyCall']
            );

       $response = $this->soapWrapper->call('GetAvailableRoutes.GetAvailableRoutes', [$option]);

      if(isset($data['DocumentElement'])){
      
        $data=$data['DocumentElement']['AllRouteBusLists'];

       if($data){
        foreach($data as $v){
            
                $result[]=[
                    "id"=> $v['CM_CityID'],
                    "name"=> $v['CM_CityName'],
                    "synonym"=> '',
                    "url"=> '',
                ];
        }
       }
    }

      return $result;
  
  }

  
  public function GetSource() 
  {

    $result=[];
    
    $this->soapWrapper->add('GetSources', function ($service) {
        $service
          ->wsdl('http://apislvV2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });
  
      $response = $this->soapWrapper->call('GetSources.GetSources', [$this->option]);
       $data=$this->xmlToArray($response->GetSourcesResult->any);
      
       if(isset($data['DocumentElement'])){

         $data=$data['DocumentElement']['ITSSources'];

      

       if($data){
        foreach($data as $v){
            
                $result[]=[
                    "id"=> $v['CM_CityID'],
                    "name"=> $v['CM_CityName'],
                    "synonym"=> '',
                    "url"=> '',
                ];

                //get destination on basis of each source


                // $DestResult= $this->GetDestination($v['CM_CityID']);

                // if($DestResult){
                //   $result[]= $DestResult;
                // }
        }
       }

    }

      return $result;
  
  }

  public function GetDestination($s) 
  {

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('GetDestinationsBasedOnSource', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['SourceID']=$s;
      $option['VerifyCall']=$this->option['verifyCall'];


        $response = $this->soapWrapper->call('GetDestinationsBasedOnSource.GetDestinationsBasedOnSource', [$option]);

       $data=$this->xmlToArray($response->GetDestinationsBasedOnSourceResult->any);

      if(isset($data['DocumentElement'])){
      
        $data=$data['DocumentElement']['ITSDestinations'];

        if (count($data) == count($data, COUNT_RECURSIVE)){

          $result[]=[
            "id"=> $data['CM_CityID'],
            "name"=> $data['CM_CityName'],
            "synonym"=> '',
            "url"=> '',
        ];

        } else{

          foreach($data as $v){
            
            $result[]=[
                "id"=> $v['CM_CityID'],
                "name"=> $v['CM_CityName'],
                "synonym"=> '',
                "url"=> '',
            ];
    }

        }

      
    }

      return $result;
  
  }

  public function xmlToArray($xmlstring){
    
    $result = \explode('</xs:schema>', $xmlstring);
    $array = json_decode(json_encode((array)simplexml_load_string($result[1])),true);
  
    return $array;
  
  }

}
