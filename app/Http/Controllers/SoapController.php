<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use App\Soap\Request\GetConversionAmount;
use App\Soap\Response\GetConversionAmountResponse;

class SoapController
{
  /**
   * @var SoapWrapper
   */
  protected $soapWrapper;

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
  public function getCountries() 
  {
    $this->soapWrapper->add('Countries', function ($service) {
      $service
        ->wsdl('http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL')
        ->trace(true);
        /*->classmap([
          GetConversionAmount::class,
          GetConversionAmountResponse::class,
        ]);*/
    });

    // Without classmap
    $response = $this->soapWrapper->call('Countries.ListOfCountryNamesByName', [
      
        "body" => '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <ListOfCountryNamesByName xmlns="http://www.oorsprong.org/websamples.countryinfo">
    </ListOfCountryNamesByName>
  </soap12:Body>
</soap12:Envelope>'
    ]);

    var_dump($response);

    // With classmap
   /* $response = $this->soapWrapper->call('Currency.GetConversionAmount', [
      new GetConversionAmount('USD', 'EUR', '2014-06-05', '1000')
    ]);

    var_dump($response);*/
    exit;
  }
}
