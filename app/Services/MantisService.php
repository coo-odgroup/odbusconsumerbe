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
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];
    }
    
    public function getToken(string $uri = null)
    {

        $token = "8B70D3AF9EB103CD987C16F358AAFF93|50-S|202211081034||FFFF";
        $result=[];
        $response = Http::withToken($token)->get($this->charturl,[
                                                        "fromCityId"=> 4292 ,
                                                        "toCityId"=> 4562,
                                                        "journeyDate" => "2022-11-30",
                                                        "busId" => 1,
                                                        //'headers' => $headers,
                                                        //'verify'  => false,
                                                        ]);                                             
          
        
        return (object) json_decode($response);
        //return Http::dd()->get('http://example.com');
        // return Http::post('https://api.iamgds.com/ota/Auth', [
        //     'ClientId' => 50,
        //     'ClientSecret'=> 'd66de12fa3473a93415b02494253f088',
        // ]);

        //return $response;

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
          $token = "D4FF124914D8B8798D2A423D2AB251A1|50-S|202211181346||FFFF";
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
       
        $token = "6D2F6545458E43A0B36709417CD7C33E|50-S|202211181022||FFFF";
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
        $token = "D4E1CA6B1B18EEF37227C0A66534214A|50-S|202211171720||FFFF";
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