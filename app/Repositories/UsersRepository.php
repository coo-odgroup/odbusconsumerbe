<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Repositories\ChannelRepository;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
use App\Models\Review;


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
    protected $review;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Location $location,Users $users,
    BusSeats $busSeats,Booking $booking,BookingDetail $bookingDetail, Seats $seats,BusClass $busClass
    ,BusType $busType,CustomerPayment $customerPayment,ChannelRepository $channelRepository,Review $review)
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
        $this->review = $review;

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
            return "";
            }
        elseif($existingOtp == $rcvOtp){

             $users = $this->users->where('id', $userId)->update(array(
                'is_verified' => '1',
                'token' => Str::random('10'),
                'otp' => Null
             ));
             $usersDetails = $this->users->where('id', $userId)->get();
            return $usersDetails; 
        }
        else{
            return 'Inval OTP';
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
    public function userProfile($request)
    {
        $userId = $request['userId'];
        $token = $request['token']; 
        $userDetails = $this->users->where('id', $userId)->where('token', $token)->get();
      	
        if(isset($userDetails[0])){
          return $userDetails;
        }else{
          return 'Invalid';
        }
        
    }
  
   

    public function updateProfile($request,$userId,$token){
      
       $userDetails= $this->users->where('id', $userId)->where('token', $token)->get();
      
      if(isset($userDetails[0])){
         
      
        $post = $this->users->where('id', $userId)->where('token', $token)->find($userId);

        $post->name = $request['name'];
        $post->email  = $request['email'];
        $post->pincode = $request['pincode'];
        $post->street = $request['street'];
        $post->district = $request['district'];
        $post->address = $request['address'];
      
        if($request['profile_image']!=''){
          $post->profile_image = $request['profile_image'];
        }
        
        $post->update();         

        return $post;
         
       }else{
         return 'Invalid';
       }
      
    }

    public function BookingHistory($request){

        $user= $this->userProfile($request);
      
       if($user!='Invalid'){
         
         $user = $user[0];
                   
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
                } ])->orderBy('journey_dt','desc');

        }
        
        else if($status=='Completed'){ 

            $list = Booking::where('users_id',$user->id)
            ->where('status','!=',2)
              ->where('status','!=',0)
              ->where('status','!=',4)
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
                } ])->orderBy('journey_dt','desc');

        }

        else if($status=='Upcoming'){    

            $list = Booking::where('users_id',$user->id)
             ->where('status','!=',2)
              ->where('status','!=',0)
              ->where('status','!=',4)
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
                } ])->orderBy('journey_dt','desc');

        }

      else{
            $list = Booking::where('users_id',$user->id)
             ->where('status','!=',0)
             ->where('status','!=',4)
            ->with(["bus" => function($bs){
                $bs->with('BusType.busClass');
                $bs->with('BusSitting');                
                $bs->with('busContacts');
              } ] )
            ->with(["bookingDetail" => function($b){
                    $b->with(["busSeats" => function($s){
                        $s->with("seats");
                      } ]);
                } ])->orderBy('journey_dt','desc');

        } 
      
      

        $list =  $list->paginate($paginate);
      
     

     

        if($list){
            foreach($list as $k => $l){

                $l['source']=$this->location->where('id',$l->source_id)->get();
                $l['destination']=$this->location->where('id',$l->destination_id)->get();
              
                $l['review']= false;
                $l['cancel']= false;

                if($l->status==2){
                    $l['booking_status']= "Cancelled";
                    
                }
                else if($l->status!=2 && $today > $l->journey_dt){
                  
                   $review=$this->review->where('users_id',$l->users_id)->where('pnr',$l->pnr)->get();
              
                    if(isset($review[0])){
                    }else{
                      $l['review']= true;
                    }
                  
                    $l['booking_status']= "Completed";
                }elseif($l->status!=2 && $today < $l->journey_dt){
                    $l['booking_status']= "Upcoming";
                    $l['cancel']= true;
                }elseif($l->status!=2 && $today == $l->journey_dt){
                    $l['booking_status']= "Ongoing";
                }
            }
        }

      
        $response = array(
            "count" => $list->count(), 
            "total" => $list->total(),
            "data" => $list
           ); 
          
           return $response;
         
       }else{
         return $user;
       }

    }

    public function userReviews($request){
            
        $user= $this->userProfile($request);
       
      if($user!='Invalid'){
         
         $user = $user[0];

        $userReviews = Review::where('users_id', $user->id)
                            ->with('bus', function ($q) {
                                $q->with('busGallery');
                                $q->with('booking', function ($b){
                                    $b ->where('status','!=',0);
                                });
                            })
                            ->with('users')
                            ->orderBy('id','desc')
                            ->get();
        $userReviews = collect($userReviews);
        
        
        if($userReviews){
            foreach($userReviews as $key => $value){ 
                $value->bus->booking['src_name']=Location::where('id',$value->bus->booking->source_id)->first()->name;
                $value->bus->booking['dest_name']=Location::where('id',$value->bus->booking->destination_id)->first()->name;   
            }
        }
        return $userReviews;
       }
      else{
        return $user;
      }
    }

}   
 