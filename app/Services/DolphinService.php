<?php

namespace App\Services;

use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DateTime;


class DolphinService
{
 
  protected $soapWrapper;

  use ApiResponser;

  public function __construct(SoapWrapper $soapWrapper)
  {
    $this->soapWrapper = $soapWrapper;
    $this->option=["verifyCall" => "dK86BF3S7KJbPrdF94qzvjm8xanYN9a7egb84bp59Fw93J8FdwHM"];
    
  }

  

  public function GetCityPair() 
  {

    $result=[];

    $this->soapWrapper->add('GetCityPair', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

       $response = $this->soapWrapper->call('GetCityPair.GetCityPair', [$this->option]);
            
       $data=$this->xmlToArray($response->GetCityPairResult->any);

      if(isset($data['DocumentElement'])){
      
        $data=$data['DocumentElement']['ITSCityPair'];

       if($data){
        foreach($data as $v){            
                $result[]=$v;
        }
       }
    }

      return $result;
  
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

         $data=$this->xmlToArray($response->GetAvailableRoutesResult->any);

      if(isset($data['DocumentElement'])){
      
        return $data['DocumentElement']['AllRouteBusLists'];
          
      }

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


  public function GetCancellationPolicy() 
  {

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('GetCancellationPolicy', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['CompanyID']='251';
      $option['VerifyCall']=$this->option['verifyCall'];


       $response = $this->soapWrapper->call('GetCancellationPolicy.GetCancellationPolicy', [$option]);

       return  $response->GetCancellationPolicyResult->CancellationPolicy;
  
  }

  public function BlockSeatV2(){

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('BlockSeatV2', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['ReferenceNumber']='251#1669#1645#22991#59534#3189#05072022#4:00 PM#10:00 PM';
      $option['PassengerName']='Lima Mohanty';
      $option['SeatNames']='22,M'; // 15,F|16,M  (This should be the format )
      $option['Email']='banashri.seofied@gmail.com';
      $option['Phone']='8763447921';
      $option['PickupID']='25802';
      $option['PayableAmount']='896';
      $option['TotalPassengers']=1;
      $option['VerifyCall']=$this->option['verifyCall'];

       $response = $this->soapWrapper->call('BlockSeatV2.BlockSeatV2', [$option]);

       $data=$this->xmlToArray($response->BlockSeatV2Result->any);

        // 0 then Failed 
        // 1 then Success 
        // 2 then Already Booked 
        // 3 then Already On Hold by Other 
        // 4 then Route/Time Is Inactive 
        // 5 then Arrangement Changed 
        // 6 then Route Time Changed 
        // 7 then Out Of Maximum Advanced Booking Date 
        // 8 then Fare Variations, Insufficient Balance 
        // 9 then Stop booking is active in this route 
        // 10 then Verify call is unauthorized – contact ITS – info@itspl.ne
       

       if(isset($data['DocumentElement'])){
      
        return $data=$data['DocumentElement']['ITSBlockSeatV2'];
       }

       

  }

  
  

  public function GetBoardingDropLocationsByCity(){

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('GetBoardingDropLocationsByCity', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['CompanyID']='251';
      $option['CityID']='1689';
      $option['VerifyCall']=$this->option['verifyCall'];

      $response = $this->soapWrapper->call('GetBoardingDropLocationsByCity.GetBoardingDropLocationsByCity', [$option]);


      $data=$this->xmlToArray($response->GetBoardingDropLocationsByCityResult->any);     

     if(isset($data['DocumentElement'])){
    
      return $data=$data['DocumentElement']['GetBoardingDropLocationsByCity'];
     }



  }

  public function FetchTicketPrintData(){

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('FetchTicketPrintData', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['PNRNo']='';
      $option['VerifyCall']=$this->option['verifyCall'];

     return $response = $this->soapWrapper->call('FetchTicketPrintData.FetchTicketPrintData', [$option]);


  }

  

  public function GetAmenities(){

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('GetAmenities', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['CompanyID']='251';
      $option['VerifyCall']=$this->option['verifyCall'];


        $response = $this->soapWrapper->call('GetAmenities.GetAmenities', [$option]);
     

     $data=$this->xmlToArray($response->GetAmenitiesResult->any);

     if(isset($data['DocumentElement'])){
     
       return $data=$data['DocumentElement']['GetAmenities'];


     
   }


  }

  public function GetBusNo(){

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('GetBusNo', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['PNRNo']='';
      $option['CompanyID']='';
      $option['RouteID']='';
      $option['RouteTimeID']='';
      $option['FromID']='';
      $option['JourneyDate']=''; //dd-mm-yyyy
      
      $option['VerifyCall']=$this->option['verifyCall'];


        $response = $this->soapWrapper->call('GetBusNo.GetBusNo', [$option]);


  }

  public function TicketStatus(){

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('TicketStatus', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['PNRNo']='';
      $option['VerifyCall']=$this->option['verifyCall'];


        $response = $this->soapWrapper->call('TicketStatus.TicketStatus', [$option]);


  }

  public function GetSeatArrangementDetails($ref) 
  {

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('GetSeatArrangementDetails', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['ReferenceNumber']=$ref;
      $option['VerifyCall']=$this->option['verifyCall'];


        $response = $this->soapWrapper->call('GetSeatArrangementDetails.GetSeatArrangementDetails', [$option]);

        $data=$this->xmlToArray($response->GetSeatArrangementDetailsResult->any);

      if(isset($data['DocumentElement'])){
      
        return $data=$data['DocumentElement']['ITSSeatDetails'];


      
    }

  
  }

  public function GetBoardingPointDetails() 
  {

    $this->soapWrapper= new SoapWrapper();

    $result=[];

    $this->soapWrapper->add('GetBoardingPointDetails', function ($service) {
        $service
          ->wsdl('http://apislvv2.itspl.net/ITSGateway.asmx?wsdl')
          ->trace(true);
      });

      $option['ReferenceNumber']='251#1669#1604#15885#43072#3190#05072022#7:00 PM#11:25 PM';
      $option['VerifyCall']=$this->option['verifyCall'];


        $response = $this->soapWrapper->call('GetBoardingPointDetails.GetBoardingPointDetails', [$option]);

         $data=$this->xmlToArray($response->GetBoardingPointDetailsResult->any);

      if(isset($data['DocumentElement'])){
      
        return $data=$data['DocumentElement']['ITSBoardingPoint'];

    }

      return $result;
  
  }


  public function xmlToArray($xmlstring){
    
    $result = \explode('</xs:schema>', $xmlstring);
    $array = json_decode(json_encode((array)simplexml_load_string($result[1])),true);
  
    return $array;
  
  }

}
