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
use App\Models\IncomingApiCompany;
use App\Models\Bus;
use App\Models\Location;
use App\Models\Users;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Jobs\SendEmailTicketJob;

use DateTime;


class DolphinTransformer
{

    protected $listingRepository; 
    protected $DolphinService;
    protected $booking;

   
    public function __construct(ListingRepository $listingRepository,DolphinService $DolphinService,Booking $booking)
    {

        $this->listingRepository = $listingRepository;
        $this->DolphinService = $DolphinService;
        $this->booking = $booking;

        
    }
    
    public function BusList($request){
         $srcResult= $this->listingRepository->getLocationID($request['source']);
        $destResult= $this->listingRepository->getLocationID($request['destination']);

        $dolphinresult=[];

        if($srcResult[0]->is_dolphin==1 && $destResult[0]->is_dolphin==1){

            $dolphin_source=$srcResult[0]->dolphin_id;
            $dolphin_dest=$destResult[0]->dolphin_id;

            $data= $this->DolphinService->GetAvailableRoutes($dolphin_source,$dolphin_dest,$request['entry_date']);

            $dolphinresult= $this->BusListProcess($data,$srcResult[0]->id,$destResult[0]->id);

        }

        return $dolphinresult;


    }

    public function Filter($request){

        $sourceID = $request['sourceID'];      
        $destinationID = $request['destinationID'];
        $entry_date = $request['entry_date'];

        $srcResult= $this->listingRepository->getLocationResult($sourceID);
        $destResult= $this->listingRepository->getLocationResult($destinationID);

        $dolphinresult=[];

        if($srcResult[0]->is_dolphin==1 && $destResult[0]->is_dolphin==1){

            $dolphin_source=$srcResult[0]->dolphin_id;
            $dolphin_dest=$destResult[0]->dolphin_id;
            $data= $this->DolphinService->GetAvailableRoutes($dolphin_source,$dolphin_dest,$entry_date);

            $dolphinresult= $this->BusListProcess($data,$sourceID,$destinationID);

        } 

        return $dolphinresult;

    }

    public function BusListProcess($data,$src_id,$dest_id){

        
        $policy= $this->GetCancellationPolicy();

        $cancellationDuration=[];
        $cancellationDuduction=[];

        if($policy){
         foreach($policy as $p){

             $cancellationDuration[]=$p->duration;
             $cancellationDuduction[]=$p->deduction;

         }         
        }


        $dolphinresult['regular'] = [];
        $dolphinresult['soldout'] = [];

        if (!empty($data)){

           if (count($data) == count($data, COUNT_RECURSIVE)){
            
            if(strpos('AM',$data['ArrivalTime']) == 0 && strpos('PM',$data['RouteTime']) ==0){
              $booking_date= date('Y-m-d',strtotime($data['BookingDate']));        
              $arrival_date= date('Y-m-d',strtotime($data['BookingDate']. ' +1 day'));         
     
            }else{
     
               $arrival_date=$booking_date= date('Y-m-d',strtotime($data['BookingDate']));  
     
             }
     
             $booking_date_time= $booking_date.' '.$data['RouteTime'];
             $arrival_date_time= $arrival_date.' '.$data['ArrivalTime'];
     
             
     
             $d1 = new DateTime($booking_date_time);
             $d2 = new DateTime($arrival_date_time);
             $interval = $d2->diff($d1);
     
             $duration= $interval->format('%hh %im');
     
     
     
             // $duration=  $arrival_date_time - $booking_date_time;

             $seatsList=$this->seatLayout($data['ReferenceNumber']);

             $seat_price=0;

             $seat_price = ($data['BusType'] == 0) ? $data['AcSeatRate'] : $data['NonAcSeatRate'];

            //  $dolphin_gstdata= IncomingApiCompany::where("name","DOLPHIN")->first();

            //  if($dolphin_gstdata){

            //     $seat_price += round(($seat_price * $dolphin_gstdata->gst)/100);

            // }

            
             $arr=[
                 "origin"=> "DOLPHIN",
                 "srcId"=> $src_id,//$data['FromCityId'],
                 "destId"=> $dest_id, //$data['ToCityId'],
                 "display"=> "show",
                 "CompanyID"=> (int)$data['CompanyID'],
                 "ReferenceNumber"=>$data['ReferenceNumber'],
                 "BoardingPoints"=>$data['BoardingPoints'],
                 "DroppingPoints"=>$data['DroppingPoints'],
                 "busId"=> (int) $data['RouteID'],
                 "RouteTimeID"=> (int)$data['RouteTimeID'],
                 "busName"=> $data['CompanyName'],
                 "via"=> "",
                 "popularity"=> null,
                 "busNumber"=> "",
                 "maxSeatBook"=> 6,
                 "conductor_number"=> "",
                 "couponCode"=> [],
                 "couponDetails"=> [],
                 "operatorId"=> '',
                 "operatorUrl"=> "",
                 "operatorName"=> $data['CompanyName'],
                 "sittingType"=>  $data['ArrangementName'],
                 "bus_description"=>($data['BusType'] == 0) ? 'AC' : 'NON AC',
                 "busType"=> ($data['BusType'] == 0) ? 'AC' : 'NON AC', //1 - non ac
                 "busTypeName"=> $data['ArrangementName'],
                 "totalSeats"=>$seatsList['emptySeat'],
                 "seaters"=> '',
                 "sleepers"=> '',
                 "startingFromPrice"=> $seat_price ,  // NonAcSeatRate,NonAcSleeperRate,AcSeatRate,AcSleeperRate
                 "departureTime"=> date("H:i",strtotime($data['CityTime'])),
                 "arrivalTime"=> date("H:i",strtotime($data['ArrivalTime'])),
                 "totalJourneyTime"=> $duration, 
                 "amenity"=> [],
                 "safety"=> [],
                 "busPhotos"=> [],
                 "cancellationDuration"=>  $cancellationDuration,
                 "cancellationDuduction"=> $cancellationDuduction,
                 "cancellationPolicyContent"=> null,
                 "TravelPolicyContent"=> null,
                 "Totalrating"=> 0,
                 "Totalrating_5star"=> 0,
                 "Totalrating_4star"=> 0,
                 "Totalrating_3star"=> 0,
                 "Totalrating_2star"=> 0,
                 "Totalrating_1star"=> 0,
                 "reviews"=> []
                ];  
                
                
                if($seatsList['emptySeat']>0){
                    $dolphinresult['regular'][] = $arr;
                }else{
                    $dolphinresult['soldout'][] = $arr;
                }
         

           }           
           else{
     
             foreach($data as $v){
     
               if(strpos('AM',$v['ArrivalTime']) == 0 && strpos('PM',$v['RouteTime']) ==0){
                 $booking_date= date('Y-m-d',strtotime($v['BookingDate']));        
                 $arrival_date= date('Y-m-d',strtotime($v['BookingDate']. ' +1 day'));         
        
                }else{
        
                  $arrival_date=$booking_date= date('Y-m-d',strtotime($v['BookingDate']));  
        
                }
        
                $booking_date_time= $booking_date.' '.$v['RouteTime'];
                $arrival_date_time= $arrival_date.' '.$v['ArrivalTime'];
        
                
        
                $d1 = new DateTime($booking_date_time);
                $d2 = new DateTime($arrival_date_time);
                $interval = $d2->diff($d1);
        
                $duration= $interval->format('%hh %im');

                $seatsList=$this->seatLayout($v['ReferenceNumber']);


                $seat_price=0;

                $seat_price = ($v['BusType'] == 0) ? $v['AcSeatRate'] : $v['NonAcSeatRate'];

                // $dolphin_gstdata= IncomingApiCompany::where("name","DOLPHIN")->first();

                // if($dolphin_gstdata){

                //     $seat_price += round(($seat_price * $dolphin_gstdata->gst)/100);

                // }

               $arr=[
                 "origin"=> "DOLPHIN",
                 "srcId"=> $src_id,//$v['FromCityId'],
                 "destId"=> $dest_id,//$v['ToCityId'],
                 "display"=> "show",
                 "CompanyID"=>(int) $v['CompanyID'],
                 "ReferenceNumber"=>$v['ReferenceNumber'],
                 "BoardingPoints"=>$v['BoardingPoints'],
                 "DroppingPoints"=>$v['DroppingPoints'],
                 "busId"=> (int) $v['RouteID'],
                 "RouteTimeID"=>(int) $v['RouteTimeID'],
                 "busName"=> $v['CompanyName'],
                 "via"=> "",
                 "popularity"=> null,
                 "busNumber"=> "",
                 "maxSeatBook"=> 6,
                 "conductor_number"=> "",
                 "couponCode"=> [],
                 "couponDetails"=> [],
                 "operatorId"=> 0,
                 "operatorUrl"=> "",
                 "operatorName"=> $v['CompanyName'],
                 "sittingType"=>  $v['ArrangementName'],
                 "bus_description"=>($v['BusType'] == 0) ? 'AC' : 'NON AC',
                 "busType"=> ($v['BusType'] == 0) ? 'AC' : 'NON AC', //1 - non ac
                 "busTypeName"=> $v['ArrangementName'],
                 "totalSeats"=> $seatsList['emptySeat'],
                 "seaters"=> '',
                 "sleepers"=> '',
                 "startingFromPrice"=> $seat_price ,  // NonAcSeatRate,NonAcSleeperRate,AcSeatRate,AcSleeperRate
                 "departureTime"=> date("H:i",strtotime($v['CityTime'])),
                 "arrivalTime"=> date("H:i",strtotime($v['ArrivalTime'])),
                 "totalJourneyTime"=> $duration, 
                 "amenity"=> [],
                 "safety"=> [],
                 "busPhotos"=> [],
                 "cancellationDuration"=>  $cancellationDuration,
                 "cancellationDuduction"=> $cancellationDuduction,
                 "cancellationPolicyContent"=> null,
                 "TravelPolicyContent"=> null,
                 "Totalrating"=> 0,
                 "Totalrating_5star"=> 0,
                 "Totalrating_4star"=> 0,
                 "Totalrating_3star"=> 0,
                 "Totalrating_2star"=> 0,
                 "Totalrating_1star"=> 0,
                 "reviews"=> []
                 
             ]; 
             
             
             if($seatsList['emptySeat']>0){
                $dolphinresult['regular'][] = $arr;
            }else{
                $dolphinresult['soldout'][] = $arr;
            }
     
             }
           }
        }

           return $dolphinresult;

    }

    public function seatLayout($ReferenceNumber)
    {

      $dolphinSeatresult= $this->DolphinService->GetSeatArrangementDetails($ReferenceNumber);

      $dolphin_gstdata= IncomingApiCompany::where("name","DOLPHIN")->first();


              $Rows= max(array_column($dolphinSeatresult, 'Column'));
              $Cols= max(array_column($dolphinSeatresult, 'Row'));

              $sleeper=[];
              $seater=[];
              $seater_blank=[];
              $sleeper_blank=[];
              $emptySeat=0;

               // for($i=1;$i<=$Rows;$i++){
                    for($i=$Rows;$i>=1;$i--){
                    for($j=1;$j<=$Cols;$j++){
                        foreach($dolphinSeatresult as $d){

                            if($d['Column']== $i && $d['Row']== $j){
                                if($d['UpLowBerth']=='UB'){
                                    if($d['BlockType']==3){
                                        //$sleeper_blank[$d['Column']]=$d;
                                    }else{
                                        $sleeper[$d['Column']][]=$d;
                                    }
                                    
                                }else{

                                    if($d['BlockType']==3){
                                        //$seater_blank[$d['Column']]=$d;
                                    }else{
                                        $seater[$d['Column']][]=$d;
                                    }
                                }
                               
                            }
                            
                        }
                    }
                }

                $sleeper=array_values($sleeper);
                $seater=array_values($seater);
               
                $viewSeat['upperBerth_totalRows']= $row1=($sleeper) ? count($sleeper) : 0;       
                $viewSeat['upperBerth_totalColumns']= ($sleeper) ? count($sleeper[0]) : 0;
                $viewSeat['lowerBerth_totalRows']= count($seater);
                $viewSeat['lowerBerth_totalColumns']= count($seater[0]);

                $UpperberthArr=[];
                $LowerberthArr=[];

               
                     $blank_row_flag=false;
                     $blankcount=0;

                    if($sleeper){   
                      foreach($sleeper as $i => $dd){ 
                            foreach($dd as $k => $d){
                                $seat_class_id ='';

                                if($d['RowSpan']==2 && $d['ColumnSpan']==0){
                                    $seat_class_id = 2;
                                }

                                else if($d['RowSpan']==0 && $d['ColumnSpan']==2){
                                    $seat_class_id = 3;  
                                }
                                
                                if($d['BlockType'] ==3){
                                    $seat_class_id = 4;
                                }

                                if($i==2 && count($dd) > 2){

                                    $blank_row_flag=true;

                                    $viewSeat['upperBerth_totalRows']=$row1+1;

                                   // for($j=0;$j<count($sleeper[0])-1;$j++){

                                if($blankcount<=4){
                                    for($j=0;$j<5;$j++){

                                        $blank=[
                                            "id"=> '',
                                            "bus_seat_layout_id"=> '',
                                            "seat_class_id"=> 4,
                                            "berthType"=> "1",
                                            "seatText"=> '',
                                            "rowNumber"=> $i,
                                            "colNumber"=> $j                           
                                        ]; 

                                        $blankcount++;
            
                                       array_push($UpperberthArr,$blank); 
                                    } 
                                }


                                    $ar=[
                                        "id"=> $d['SeatNo'],
                                        "bus_seat_layout_id"=> '',
                                        "seat_class_id"=> $seat_class_id,
                                        "berthType"=> "2",
                                        "seatText"=> $d['SeatNo'],
                                        "rowNumber"=> $i+1,
                                        "colNumber"=> $k                           
                                    ];
                                }


                                else if(count($dd)==2){

                                    if($blankcount<=4){  

                                    //for($j=0;$j<count($sleeper[0])-1;$j++){
                                    for($j=0;$j<5;$j++){

                                        $blank=[
                                            "id"=> '',
                                            "bus_seat_layout_id"=> '',
                                            "seat_class_id"=> 4,
                                            "berthType"=> "1",
                                            "seatText"=> '',
                                            "rowNumber"=> $i,
                                            "colNumber"=> $j                           
                                        ]; 

                                        $blankcount++;
            
                                    array_push($UpperberthArr,$blank); 
                                    }
                                }


                                    $ar=[
                                        "id"=> $d['SeatNo'],
                                        "bus_seat_layout_id"=> '',
                                        "seat_class_id"=> $seat_class_id,
                                        "berthType"=> "2",
                                        "seatText"=> ($seat_class_id==4) ? '' : $d['SeatNo'],
                                        "rowNumber"=> $i,
                                        "colNumber"=> count($sleeper[0])-1                           
                                    ];                                 
        
                                }else{

                                    if($blank_row_flag){
                                        $i= $i+1;
                                        $blank_row_flag=false;
                                    }


                                    $ar=[
                                        "id"=> $d['SeatNo'],
                                        "bus_seat_layout_id"=> '',
                                        "seat_class_id"=> $seat_class_id,
                                        "berthType"=> "2", //Upper Berth
                                        "seatText"=> ($seat_class_id==4) ? '' : $d['SeatNo'],
                                        "rowNumber"=>  ($seat_class_id==3) ? 2 : $i,
                                        "colNumber"=> ($seat_class_id==3) ? 4 : $k,                             
                                    ];
                                    
                                }

                                if($d['IsLadiesSeat']=='N' && $d['Available'] =='N'){

                                    $ar["Gender"]= "M";
                                
                                } 

                                if($d['IsLadiesSeat']=='Y' && $d['Available'] =='N'){

                                    $ar["Gender"]= "F";
                                
                                } 

                                if($d['Available'] =='Y'){

                                    $emptySeat++;

                                    $seat_price= $d['SeatRate'];

                                    // if($dolphin_gstdata){

                                    //     $seat_price += round(($d['SeatRate'] * $dolphin_gstdata->gst)/100);
                                     
                                    //  }

                                    $ar["bus_seats"]= [
                                            "ticket_price_id"=> 0,
                                            "seats_id"=> $d['SeatNo'],
                                            "new_fare"=> $seat_price
                                    ];
                                }

                                array_push($UpperberthArr,$ar);
                            }
                      
                        }
                    }


               ////////// lower berth 

                if($seater){
                    foreach($seater as $i => $dd){  

                        foreach($dd as $k => $d){

                            $seat_class_id ='';

                            if($d['RowSpan']==0 && $d['ColumnSpan']==0){
                                $seat_class_id = 1;
                            }
                            if($d['RowSpan']==2 && $d['ColumnSpan']==0){
                                $seat_class_id = 2;
                            }
    
                            else if($d['RowSpan']==0 && $d['ColumnSpan']==2){
                                $seat_class_id = 1; // for seater there is no seat class id 3 (Vertical Sleeper)
                            }
    
                            if($d['BlockType'] ==3){
                                $seat_class_id = 4;
                            }


                            if(count($dd)==1){

                                for($j=0;$j<count($seater[0])-1;$j++){

                                    $blank=[
                                        "id"=> '',
                                        "bus_seat_layout_id"=> '',
                                        "seat_class_id"=> 4,
                                        "berthType"=> "1",
                                        "seatText"=> '',
                                        "rowNumber"=> $i,
                                        "colNumber"=> $j                           
                                    ]; 
        
                                   array_push($LowerberthArr,$blank); 
                                }

                                $ar=[
                                    "id"=> $d['SeatNo'],
                                    "bus_seat_layout_id"=> '',
                                    "seat_class_id"=> $seat_class_id,
                                    "berthType"=> "1",
                                    "seatText"=> ($seat_class_id==4) ? '' : $d['SeatNo'],
                                    "rowNumber"=> $i,
                                    "colNumber"=> count($seater[0])-1                           
                                ]; 


                                
    
                            }else{

                                $ar=[
                                    "id"=> $d['SeatNo'],
                                    "bus_seat_layout_id"=> '',
                                    "seat_class_id"=> $seat_class_id,
                                    "berthType"=> "1",
                                    "seatText"=> ($seat_class_id==4) ? '' : $d['SeatNo'],
                                    "rowNumber"=> $i,
                                    "colNumber"=> $k                           
                                ]; 

                            }
    
                           
    
                            if($d['IsLadiesSeat']=='N' && $d['Available'] =='N'){
    
                                $ar["Gender"]= "M";
                               
                            } 
    
                            if($d['IsLadiesSeat']=='Y' && $d['Available'] =='N'){
    
                                $ar["Gender"]= "F";
                               
                            } 
    
                            if($d['Available'] =='Y'){

                                $emptySeat++;

                                $seat_price= $d['SeatRate'];

                                    // if($dolphin_gstdata){

                                    //     $seat_price += round(($d['SeatRate'] * $dolphin_gstdata->gst)/100);
                                     
                                    //  }
    
                                $ar["bus_seats"]=[
                                        "ticket_price_id"=> 0,
                                        "seats_id"=> $d['SeatNo'],
                                        "new_fare"=>  $seat_price
                                ];
    
                            }

                            array_push($LowerberthArr,$ar);
                        }

                        

                            
                    }
                }

                $viewSeat['lower_berth']=$LowerberthArr;
                $viewSeat['upper_berth']=$UpperberthArr;
                $viewSeat['emptySeat']=$emptySeat;
                return $viewSeat;
               
    }  
    
    public function BlockSeat($records){

        $nm_ar=[];
        $TotalPassengers=0;

        $amount = $records[0]->owner_fare; 

        // if($records[0]->payable_amount == 0.00){
        //     $amount = $records[0]->total_fare;
        //     }else{
        //         $amount = $records[0]->payable_amount;
        //     }

        if(!empty($records[0]->bookingDetail)){
            foreach($records[0]->bookingDetail as $bdt){
                $st_nm= $bdt->seat_name.','.$bdt->passenger_gender;
                $nm_ar[]=$st_nm;
                $TotalPassengers++;
            }

        }

        $arr['ReferenceNumber']= $records[0]->ReferenceNumber;
        $arr['PassengerName']=$records[0]->users->name;
        $arr['SeatNames']=implode('|',$nm_ar);
        $arr['Email']=$records[0]->users->email;
        $arr['Phone']=$records[0]->users->phone;
        $arr['PickupID']=$records[0]->PickupID;
        $arr['PayableAmount']=$amount;
        $arr['TotalPassengers']=$TotalPassengers;               

       return $res= $this->DolphinService->BlockSeat($arr);

       

    }


    public function BookSeat($records){

        $nm_ar=[];
        $TotalPassengers=0;

        // if($records[0]->payable_amount == 0.00){
        //     $amount = $records[0]->total_fare;
        //     }else{
        //         $amount = $records[0]->payable_amount;
        //     }

        $amount = $records[0]->owner_fare; 

        if(!empty($records[0]->bookingDetail)){
            foreach($records[0]->bookingDetail as $bdt){
                $st_nm= $bdt->seat_name.','.$bdt->passenger_gender;
                $nm_ar[]=$st_nm;
                $TotalPassengers++;
            }

        }

        $arr['ReferenceNumber']= $records[0]->ReferenceNumber;
        $arr['PassengerName']=$records[0]->users->name;
        $arr['SeatNames']=implode('|',$nm_ar);
        $arr['Email']=$records[0]->users->email;
        $arr['Phone']=$records[0]->users->phone;
        $arr['PickupID']=$records[0]->PickupID;
        $arr['PayableAmount']=$amount;
        $arr['TotalPassengers']=$TotalPassengers; 
       
        $res= $this->DolphinService->BookSeat($arr);

        Log::info($res);

       return $res;
       

    }

    public function FetchTicketPrintData($pnr){

        if($pnr!=''){
            $list=$this->booking->where('pnr',$pnr)->first();


            if(!empty($list)){
                if($list->api_pnr!=null){


                    $res= $this->DolphinService->FetchTicketPrintData($list->api_pnr);
                    if($res){


                        $ar['DOLPHIN_PNRNO']=$res['PNRNO'];
                        $ar['CoachNo']=$res['CoachNo'];
                        $ar['PickUpName']=$res['PickUpName'];
                        $ar['MainTime']=$res['MainTime'];
                        $ar['ReportingTime']=$res['ReportingTime'];
                       return $ar;                    
                    }

                }
               
            }            

        }else{

            $list=$this->booking->where('origin','DOLPHIN')->where('api_pnr','!=',null)->orderBy('id','DESC')->get();

            if($list){
                $main=[];
                foreach($list as $l){
                    $res= $this->DolphinService->FetchTicketPrintData($l->api_pnr);    
                    if($res){
                        $ar['DOLPHIN_PNRNO']=$res['PNRNO'];
                        $ar['CoachNo']=$res['CoachNo'];
                        $ar['PickUpName']=$res['PickUpName'];
                        $ar['MainTime']=$res['MainTime'];
                        $ar['ReportingTime']=$res['ReportingTime'];
                        $main[]=$ar; 
                    }
                }

                return $main;
            }

        }

       

    }

    public function GetBusNo($arr,$pnr){

        $option['PNRNo']=$pnr;
        $option['CompanyID']=$arr[0]->CompanyID;
        $option['RouteID']=$arr[0]->bus_id;
        $option['RouteTimeID']=$arr[0]->RouteTimeID;
        $srcResult= $this->listingRepository->getLocationResult($arr[0]->source_id);
        $option['FromID']=$srcResult[0]->dolphin_id;
        $option['JourneyDate']=date('d-m-Y',strtotime($arr[0]->journey_dt));

       // Log::info($option);
     
        $res= $this->DolphinService->GetBusNo($option);

        //Log::info($res);

       return $res;
      

    }

    public function GetCancellationPolicy(){

        $arr=[];
        $res= $this->DolphinService->GetCancellationPolicy();
        if($res){
            foreach($res->Policy->PolicyDetails as $p){

                $ar['duration']=($p->FromMinutes/60)."-".($p->ToMinutes/60);
                $ar['deduction']=$p->DeductPercent;

                $arr[]=(object)$ar;

            }
        }
        return $arr;

    }


    public function cancelTicketInfo($pnr){
        return $this->DolphinService->CancelDetails($pnr);
    }

    public function ConfirmCancellation($pnr){
        return $this->DolphinService->ConfirmCancellation($pnr);
    }
   
}