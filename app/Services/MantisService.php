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
        $this->bookSeatsurl = 'https://tranapi.iamgds.com/ota/BookSeats';
        $this->searchBusurl = 'https://api.iamgds.com/ota/SearchBus';
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];
    }
    
    public function getToken(string $uri = null)
    {

        $token = '731A751C2570C5A5BA9824AF9B9BBA05|50-S|202212021127||FFFF';
                                      
        $response = Http::withHeaders([
            'Access-Token' => $token,
           // 'Content-Type' => 'application/json'
            ])->post($this->bookSeatsurl, ['HoldId' => 42758116
            ]);  
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
        $token = "731A751C2570C5A5BA9824AF9B9BBA05|50-S|202212021127||FFFF";
            
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
          $token = "731A751C2570C5A5BA9824AF9B9BBA05|50-S|202212021127||FFFF";
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
       
        $token = "731A751C2570C5A5BA9824AF9B9BBA05|50-S|202212021127||FFFF";
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
        $token = "731A751C2570C5A5BA9824AF9B9BBA05|50-S|202212021127||FFFF";
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
        $token = "731A751C2570C5A5BA9824AF9B9BBA05|50-S|202212021127||FFFF";
        $response = Http::withHeaders([
                        'Access-Token' => $token,
                    //'Content-Type' => 'application/json'
                        ])->post($this->holdSeatsurl, $bookingDet   
                                );  
        return $response->json(); 
    }
    public function BookSeats($holdId) 
    {
        $token = '3FE2CD1A4D70A0346BA6C19F3EC8DE22|50-S|202212011228||FFFF';                           
        $response = Http::withHeaders([
            'Access-Token' => $token,
           // 'Content-Type' => 'application/json'
            ])->post($this->bookSeatsurl, ['HoldId' => (int)$holdId
            ]); 
         return $response->json();
    }
    public function searchBus($s,$d,$dt,$busId) ///used to get details of a Bus
    {
       
        $token = "731A751C2570C5A5BA9824AF9B9BBA05|50-S|202212021127||FFFF";
        $response = [];
        $response = Http::withToken($token)->get($this->searchBusurl,[
                                                        "fromCityId"=> $s ,
                                                        "toCityId"=> $d,
                                                        "journeyDate" =>$dt,
                                                        "busId" =>$busId,
                                                        //'headers' => $headers,
                                                        //'verify'  => false,
                                                        ]);                                             
        return $response->json();  
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