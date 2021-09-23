<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Repositories\ChannelRepository;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Bus;
use App\Models\Location;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\CustomerPayment;
use App\Models\BusType;
use App\Models\BusClass;
use App\Models\BusSeats;
use App\Models\BusContacts;
use App\Models\Seats;
use App\Models\TicketPrice;


class UsersRepository
{
    /**
     * @var Users
     */
    protected $channelRepository;
    protected $bus;
    protected $ticketPrice;
    protected $location;
    protected $users;
    protected $booking;
    protected $busSeats;
    protected $seats;
    protected $bookingDetail;
    protected $busType;
    protected $busClass;
    protected $customerPayment;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Location $location,Users $users,
    BusSeats $busSeats,Booking $booking,BookingDetail $bookingDetail, Seats $seats,BusClass $busClass
    ,BusType $busType,CustomerPayment $customerPayment,ChannelRepository $channelRepository)
    {
        $this->users = $users;
        $this->channelRepository = $channelRepository;   

        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->location = $location;
        $this->busSeats = $busSeats;
        $this->seats = $seats;
        $this->booking = $booking;
        $this->bookingDetail = $bookingDetail;
        $this->busType = $busType;
        $this->busClass = $busClass;
        $this->customerPayment = $customerPayment;

    }
  
    public function Register($request)
    {  
        $query =$this->users->where([
                ['phone', $request['phone']],
                ['phone', '<>', null]
                ])
                ->orWhere([
                ['email', $request['email']],
                ['email', '<>', null]
                ]);
 
        $guestUser = $query->latest()->exists();
        
        if(!$guestUser){
            $user = new $this->users;
            $user->name= $request['name'];
            $user->password= bcrypt('odbus123');
            $user->created_by= $request['created_by'];
            $otp = $this->sendOtp($request);
            $user->phone = $request['phone'];
            $user->email = $request['email'];
            $user->otp = $otp;
            $user->save();
            return  $user;
        }else{
            $verifiedUser = $query->latest()->first()->is_verified;
            if($verifiedUser==0){
                $otp = $this->sendOtp($request);
                $user = $query
                    ->update([
                    'name' => $request['name'],
                    'otp' => $otp,
                    'password' => bcrypt('odbus123')
                   ]);
                   return $query->latest()->first();
            }
            else{
                    return "Existing User";
            }
        }
    }
    public function sendOtp($request){
        $otp = rand(10000, 99999);
        if($request['phone']){
            $this->users->phone = $request['phone'];
            $sendsms = $this->channelRepository->sendSms($request,$otp);  
        } 
        elseif($request['email']){
            $this->users->email = $request['email']; 
            $sendEmail = $this->channelRepository->sendEmail($request,$otp);
        }
        return  $otp;
    }
    public function verifyOtp($request){
        $rcvOtp = trim($request['otp']);
        $userId = $request['userId'];
        $existingOtp = $this->users->where('id', $userId)->get('otp');
        $existingOtp = $existingOtp[0]['otp'];
        $user = $this->users->where('id', $userId)->first()->only('name','email');
        if(($rcvOtp=="")){
            return "Null";
            }
        elseif($existingOtp == $rcvOtp){
            $this->users->where('id', $userId)->update(array('is_verified' => '1'));
            $this->users->where('id', $userId)->update(array('otp' => Null));
            return "success"; 
        }
        else{
            return 'Invalid OTP';
        }
    }

    public function login($request){
            $query =$this->users->where([
                ['phone', $request['phone']],
                ['phone', '<>', null]
                ])
                ->orWhere([
                ['email', $request['email']],
                ['email', '<>', null]
                ]);
        $verifiedStatus = $query->latest()->first()->is_verified;    
        if($verifiedStatus == 1){
            $name = $query->latest()->first()->name;        
            $request->request->add(['name' => $name]);
            $otp = $this->sendOtp($request);
            $user = $query->update(array('otp' => $otp));
            $user = $query->update(array('password' => bcrypt('odbus123')));
            return  $query->latest()->first(); 
        } else{
            return "un_registered";
        }      
    }

    public function BookingHistory($request){

         $user = auth()->user();

        $status = $request['status'];
        $paginate = $request['paginate'];
        $filter = $request['filter'];  

        $today=date("Y-m-d");

        if($status=='Cancelled'){   
            
            $list = Booking::where('users_id',$user->id)
            ->where('status','=',2)
            ->with(["bus" => function($bs){
                $bs->with('BusType.busClass');
                $bs->with('BusSitting');                
                $bs->with('busContacts');
              } ] )
            ->with(["bookingDetail" => function($b){
                    $b->with(["busSeats" => function($s){
                        $s->with("seats");
                      } ]);
                } ]);

        }
        
        else if($status=='Completed'){ 

            $list = Booking::where('users_id',$user->id)
            ->where('status','!=',2)
            ->where('journey_dt','<',$today)
            ->with(["bus" => function($bs){
                $bs->with('BusType.busClass');
                $bs->with('BusSitting');                
                $bs->with('busContacts');
              } ] )
            ->with(["bookingDetail" => function($b){
                    $b->with(["busSeats" => function($s){
                        $s->with("seats");
                      } ]);
                } ]);

        }

        else if($status=='Upcoming'){    

            $list = Booking::where('users_id',$user->id)
            ->where('status','!=',2)
            ->where('journey_dt','>',$today)
            ->with(["bus" => function($bs){
                $bs->with('BusType.busClass');
                $bs->with('BusSitting');                
                $bs->with('busContacts');
              } ] )
            ->with(["bookingDetail" => function($b){
                    $b->with(["busSeats" => function($s){
                        $s->with("seats");
                      } ]);
                } ]);

        }

      else{
            $list = Booking::where('users_id',$user->id)
            ->with(["bus" => function($bs){
                $bs->with('BusType.busClass');
                $bs->with('BusSitting');                
                $bs->with('busContacts');
              } ] )
            ->with(["bookingDetail" => function($b){
                    $b->with(["busSeats" => function($s){
                        $s->with("seats");
                      } ]);
                } ]);

        }        

        $list =  $list->paginate($paginate);

       // $list= (array) $list;

        if($list){
            foreach($list as $k => $l){

                $l['source']=$this->location->where('id',$l->source_id)->get();
                $l['destination']=$this->location->where('id',$l->destination_id)->get();

                if($l->status==2){
                    $l['booking_status']= "Cancelled";
                }
                else if($l->status!=2 && $today > $l->journey_dt){
                    $l['booking_status']= "Completed";
                }elseif($l->status!=2 && $today < $l->journey_dt){
                    $l['booking_status']= "Upcoming";
                }
            }
        }

      
        $response = array(
            "count" => $list->count(), 
            "total" => $list->total(),
            "data" => $list
           );   
           return $response;


    }
}   
 