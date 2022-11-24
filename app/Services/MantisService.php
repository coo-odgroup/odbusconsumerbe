<?php

namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


use GuzzleHttp\Client;

class MantisService
{
    protected $url;
    protected $http;
    protected $headers;

    public function __construct(Client $client)
    {
        $this->url = 'https://api.iamgds.com/ota/Auth';
        $this->cityurl = 'https://api.iamgds.com/ota/CityList';
        $this->searchurl = 'https://api.iamgds.com/ota/Search';
        $this->charturl = 'https://api.iamgds.com/ota/Chart';
        $this->holdSeatsurl = 'https://tranapi.iamgds.com/ota/HoldSeats';
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];
    }
    
    public function getToken(string $uri = null)
    {

        $token = '0B82B58A7B049961F3FE72104ADAEA95|50-S|202211281017||FFFF';
                                      
        $response = Http::withHeaders([
            'Access-Token' => $token,
           // 'Content-Type' => 'application/json'
            ])->post($this->holdSeatsurl,
        [
            "FromCityId"=> 4292,
            "ToCityId"=> 4562,
            "JourneyDate"=> "2022-11-28",
            "BusId" => 1,
            "PickUpID"=> "39436",  //>>>
            "DropOffID"=> "750", // >>
            "ContactInfo"=> [
                "CustomerName"=> "swagatika",
                "Email"=> "testbooking@travelyaari.com",
                "Phone"=> "9916457575",
                "Mobile"=> "9916457574"
            ],
            "Passengers"=> [
                [
                    "Name"=> "sonyyyyy",
                    "Age"=> 23,       // >>>
                    "Gender"=> "F",
                    "SeatNo"=> "4",
                    "Fare"=> 12,
                    "SeatTypeId"=> 1, // >>>>
                    //"IsAcSeat"=> true
                ],
                [
                    "Name"=> "samoooo",
                    "Age"=> 23,
                    "Gender"=> "M",
                    "SeatNo"=> "5",
                    "Fare"=> 12,
                    "SeatTypeId"=> 1,
                    //"IsAcSeat"=> true
                ]
            ]
            ]
        
    );  
         return $response->json();
               
          //return $response->throw()->json();
        return  $response->getStatusCode();                                          
          
        return (object) json_decode($response);

        ///////////
        // $full_path = $this->url;
        // $request = Http::post($full_path, [
        //     'ClientId' => 50,
        //     'ClientSecret'=> 'd66de12fa3473a93415b02494253f088',
        //     'timeout'         => 30,
        //     'connect_timeout' => true,
        //     'http_errors'     => true,
        //     //'verify' => false
        // ]);
        // $recvToken = $request ? $request->getBody()->getContents() : null;
        // $status = $request ? $request->getStatusCode() : 500;
        // if ($recvToken && $status === 200 && $recvToken !== 'null') {
        //     Cache::add('token', $recvToken , $seconds = 86400);
        //     //return (object) json_decode($response);
        // }
        // //return null;
    ///////////////
    //    //$token = Cache::get('token');
    //$token = 'AAA01A77AEC67B2642AF5D7643022ABB|50-S|202210271443||FFFF';
    //     $response = $this->http->request('GET', $this->cityurl, [
    //     'headers' => [
    //         'Authorization' => 'Bearer ' . $token,
    //     ]
    //     ]);
    //     return json_decode((string) $response->getBody(), true);
      //////////////////////

      $res = [];
      try{
        $token = "79FC687F06C0493F65D579A22A3CE6E6|50-S|202211041512||FFFF";
            
        //$token = Cache::get('token');
        $response = Http::withToken($token)->get($this->cityurl);
        
        $cityLists[] = response()->json(json_decode($response)->data);
        if($cityLists){
            foreach(($cityLists)[0]->original as $city){
                
                    [   
                        "id"=> $city->CityId,
                        "name"=> $city->City,
                        "synonym"=> '',
                        //"synonym"=> Str::substr($city->City,0,3),
                        "url"=> '',
                    ];
            }
        }
        return $res;   
    }
    catch (Exception $e){
        return $e;
    }
        $response = $request ? $request->getBody()->getContents() : null;
        $status = $request ? $request->getStatusCode() : 500;
        
        if ($response && $status === 200 && $response !== 'null') {
            //return $response;
            
            return (object) json_decode($response);
        }
        return $response;
        return null;
    }

    public function getCityList()
    {
        $res = [];
        try{
          $token = "A4879D4C82744A4C56EB66736E16013C|50-S|202211281435||FFFF";
          $response = Http::withToken($token)->get($this->cityurl);
          //return $response;
          $cityLists[] = response()->json(json_decode($response)->data);
          if($cityLists){
              foreach(($cityLists)[0]->original as $city){
                    $res[] = $city;
              }
          }
          return $res;   
        }
        catch (Exception $e){
            return $e;
        }


        /////////////////////////////////////////////////////////
        $full_path = $this->cityurl;
        $value = $this->getToken()->Cache::get('token');
        $request = $this->http->get($full_path, [
            'headers'         => $value,
            'timeout'         => 30,
            'connect_timeout' => true,
            'http_errors'     => true,
        ]);

        $response = $request ? $request->getBody()->getContents() : null;
        $status = $request ? $request->getStatusCode() : 500;

        if ($response && $status === 200 && $response !== 'null') {
            return $response;
            return (object) json_decode($response);
        }
        return null;

    }
    private function getResponse(string $uri = null)
    {
        $full_path = $this->url;
        $full_path .= $uri;
        $request = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => true,
            'http_errors'     => true,
        ]);

        $response = $request ? $request->getBody()->getContents() : null;
        $status = $request ? $request->getStatusCode() : 500;

        if ($response && $status === 200 && $response !== 'null') {

            //return (object) json_decode($response);
        }

        return null;
    }
    public function search($s,$d,$dt) ////used for listing API
    {
       
        $token = "A4879D4C82744A4C56EB66736E16013C|50-S|202211281435||FFFF";
        $result=[];
        $response = Http::withToken($token)->get($this->searchurl,[
                                                        "fromCityId"=> $s ,
                                                        "toCityId"=> $d,
                                                        "journeyDate" =>$dt,
                                                        //'headers' => $headers,
                                                        //'verify'  => false,
                                                        ]);                                             
          
        //return response()->json(json_decode($response)->data);
        return (object) json_decode($response);   
    }
    public function chart($s,$d,$dt,$busId) 
    {
        $token = "A4879D4C82744A4C56EB66736E16013C|50-S|202211281435||FFFF";
        $result=[];
        $response = Http::withToken($token)->get($this->charturl,[
                                                        "fromCityId"=> $s ,
                                                        "toCityId"=> $d,
                                                        "journeyDate" => $dt,
                                                        "busId" => $busId,
                                                        //'headers' => $headers,
                                                        //'verify'  => false,
                                                        ]);                                             
        return (object) json_decode($response);
    }

    public function HoldSeats($bookingDet) 
    {
        $token = "A4879D4C82744A4C56EB66736E16013C|50-S|202211281435||FFFF";
        $response = Http::withHeaders([
                        'Access-Token' => $token,
                    //'Content-Type' => 'application/json'
                        ])->post($this->holdSeatsurl, $bookingDet   
                                );  
        return $response->json(); 
           
        //return $response->body();                                        
        //return (object) json_decode($response);
    }

    private function postResponse(string $uri = null, array $post_params = [])
    {
        $full_path = $this->url;
        $full_path .= $uri;

        $request = $this->http->post($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => true,
            'http_errors'     => true,
            'form_params'     => $post_params,
        ]);

        $response = $request ? $request->getBody()->getContents() : null;
        $status = $request ? $request->getStatusCode() : 500;

        if ($response && $status === 200 && $response !== 'null') {
            return (object) json_decode($response);
        }

        return null;
    }
}