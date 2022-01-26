<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
<meta charset="utf-8" />
<title>BUS TICKET</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
<style type="text/css">
   .container {
       max-width:1320px !important;
       margin:0 auto ;
   }

   .od-body{
       border:3px solid #323232;
       padding: 25px;
       margin-top: 20px;
   }

   .row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
  }

  .od-logo{
      height: 80px;
  }

  .odtext24 h3{
      font-size:20px;
      text-align: left;
      line-height:26px;
      font-weight:600;
      color: #323232;
  }

  .odtext32{
      font-size:28px;
      text-align: center;
      line-height:34px;
      font-weight:600;
      padding-top: 8px;
      color: #043c5d;
  }

  .odtext32 span{
      font-weight: 800;
  }

  .od-bktext{
      font-size:18px;
      text-align: center;
      line-height: 22px;
      color: #000000;
      border:1px solid #c4c4c4 ;
      padding:8px ;
      font-weight: 600;
  }
  .od-banner{
      width: 100%;
  }
  .od-qrcode{
      background:#c4c4c4;
      padding: 15px;
      width: 100%;
      margin-top: 34px;
  }
  .mt30{
    margin-top: 35px;
  }
  .mb25{
      
      margin-bottom: 35px;
  }

  .mb40{
      margin-bottom: 40px;
  }

  .odbox1{
    border: 1px solid #c4c4c4;
    padding:25px 15px;
  }

  .odbox1 ol{
    margin-left: -20px;
  }

  .odbox2{
    border: 1px solid #000000;
    padding:25px 15px;
  }

  .odbox2 p{
    font-size:18px;
    color: #000000;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .odbox3 p{
    font-size:18px;
    color: #000000;
    font-weight: 600;
    margin-bottom: 8px;
    text-align: right;
  }

</style>

</head>
<!-- /Head -->

<body>
    <div class="container">
        <div class="od-body mb25">
           <div class="row mb40">
               <div class="col-md-3"><img src="{{url('template/logo.png')}}" class="od-logo"/></div>
               <div class="col-md-6 odtext32"><span>ODBUS</span> e-Ticketing Service<br/> Electronic Reservation Slip</div>
               <div class="col-md-3">
                   <div class="od-bktext">Booking Date</div>
                   <div class="od-bktext">{{$bookingdate}}</div>
               </div>
           </div>
           <div class="row  mt30 mb25">
            <div class="col-md-9 odtext24">
                <h3>JOURNEY DETAILS:</h3>
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">PNR No:  {{$pnr}}</th>
                        <th scope="col">Bus Name/Number: {{$busname}}-{{$busNumber}}</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Journey Date: {{$journeydate}}</td>
                        <td>Bus Route: {{$source}}-{{$destination}}</td>
                      </tr>
                      <tr>
                        <td>Diparature Timing:  {{$departureTime}} </td>
                        <td>Arrival Timing: {{$arrivalTime}}</td>
                      </tr>
                      <tr>
                        <td>From: {{$source}}</td>
                        <td>To: {{$destination}}</td>
                      </tr>
                      <tr>
                        <td>Boarding At :{{$source}} ({{$boarding_point}})</td>
                        <td>Droping At: {{$destination}} ({{$dropping_point}})</td>
                      </tr>
                      <tr>
                        <td>Passenger Mobile No: {{customer_number}}</td>
                        <td>Conductor Mobile No: {{$conductor_number}}</td>
                      </tr>
                      <tr>
                        <td>Total Fare: Rs.{{$payable_amount + $customer_comission }}/-</td>
                        <td>Seat({{$total_seats}})- {{$seat_names}}</td>
                      </tr>
                      
                    </tbody>
                  </table>
                
            </div>
            <div class="col-md-3"><img src="{{url('template/qr-code.png')}}" class="od-qrcode"/></div>
        </div>

        <div class="row mt30 mb25">
            <div class="col-md-12 odtext24">
                <h3>PASSENGER DETAILS:</h3>
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Sl No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Sex</th>
                        <th scope="col">Booking Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($passengerDetails as $passenger) 

                      <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$passenger['passenger_name']}} </td>
                        <td>{{$passenger['passenger_age']}}</td>
                        <td>{{$passenger['passenger_gender']}}</td>
                        <td>{{$seat_no[$loop->index]}}</td>
                      </tr>

                      @endforeach                    
                    </tbody>
                  </table>
            </div>
            
        </div>

        <div class="row mt30 mb25">
            <div class="col-md-12"><img src="{{url('template/banner-01.png')}}" class="od-banner"/></div>
        </div>

        <div class="row mt30">
            <div class="col-md-12 odtext24"><h3>TERMS & CONDITIONS</h3></div>
            <div class="col-md-12 ">
              <div class="odbox1">
              <div class="row ">
                <div class="col-md-6">
                  <ol>

                  <li>ODBUS is an Online Platform which provides online bus ticket booking services and does not operate bus services.</li>

                  <li>Arrival and departure times written on the ticket approximate time, to reach on the boarding points before 15 min.</li>
                  
                  <li>Passengers are required to take a copy of the ticket and an Identity proof  during their travel</li>
                  
                  <li>We are at ODBUS advice to all customers is to choose bus operators they are aware of and whose service they are comfortable with.</li>
                  
                  <li>In case the bus operator changes the type of bus due to some reason, ODBUS will refund the equest by the customers in 24 hours of the journey.</li>
                  
                  <li>The tickets booked through ODBUS Can be cancelled and note that Cancel Can be possible before 12 hours For More Details Please refer Cancelation Policy.</li>
                  
                  <li>If a booking confirmation e-mail and SMS get delayed or fails because of technical reasons www.odbus.in</li>
                  
                  <li>During booking, If an amount deducted and ticket not shown or SMS not delivered Please call to 9583918888.</li>
                  <li>The tickets booked through ODBUS Can be cancelled and note that Cancel Can be possible before 12 hours For More Details Please refer Cancelation Policy.</li>
                 </ol>
                </div>
                <div class="col-md-6 odtext24">

                  <ol>

                    
                    <li>We are at ODBUS advice to all customers is to choose bus  they are comfortable with.</li>
                    
                    <li>In case the bus operator changes the typ reason, ODBUS will refund in 24 hours of the journey.</li>
                    
                    <li>The tickets booked through ODBUS be possible before 12 hours.</li>
                    
                    
                   </ol>

                   <h3>CANCELATION POLICY</h3>
                   <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Cancellation Cut Off Time</th>
                        <th scope="col">Cancellation Return Amount</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>4 Hours To 8 Hours</td>
                        <td>25%</td>
                      </tr>
                      <tr>
                        <td>8 Hours To 24 Hours</td>
                        <td>35%</td>
                      </tr>
                      <tr>
                        <td>24 Hours To 72 Hours</td>
                        <td>80%</td>
                      </tr>
                      <tr>
                        <td>More than 72 Hours</td>
                        <td>90%</td>
                      </tr>
                      
                      <tr>
                        <td colspan="2">
                          <ol>
                            <li>All customers is to choose bus they are comfortable.</li>
                            
                            <li>Bus operator changes ODBUS wilustomers in 24 hours of the journey.</li>
                            
                            <li>The tickets booked through ODBUS  before 12 hours.</li>
                            
                           </ol>
                        </td>
                         
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            </div>

            <div class="col-md-12 mt30">
              <div class="odbox2">
                <div class="row ">
                  <div class="col-md-12">
                    <p>Contact Information</p>
                    <p>ODBUS Helpline (07:00 AM To 11:00 PM):9583-918-888 (For Online Booking issue or Online Cancellation issue.) </p>
                    <p>ODBUS Customer Support Email (Response time 3 working days): support@odbus.in</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12 mt30">
              <div class="odbox3">
                <div class="row ">
                  <div class="col-md-12">
                    <p>Thankyou</p>
                    <p>Team ODBUS</p>
                  </div>
                </div>
              </div>
            </div>
            
        </div>
        </div>
    </div>
</body>
</html>