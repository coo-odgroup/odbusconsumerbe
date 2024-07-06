<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwtAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DTController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ViewSeatsController;
use App\Http\Controllers\BookTicketController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PopularController;
use App\Http\Controllers\CancelTicketController;
use App\Http\Controllers\BookingManageController;
use App\Http\Middleware\LogRoute;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PageContentController;
use App\Http\Controllers\SoapController;
use App\Http\Controllers\AgentBookingController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\FilePathUrlsController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\RecentSearchController;
use App\Http\Controllers\AuthClientsController;
use App\Http\Controllers\ClientBookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\MantisController;
use App\Http\Controllers\ApiReferenceController;

//Route::group(['middleware' => ['checkIp']], function() {

Route::group(['middleware' => ['jwt.verify']], function() {
   
Route::get('/getLocation', [ListingController::class, 'getLocation']);
Route::post('/FilterOptions', [ListingController::class, 'getFilterOptions']);
Route::get('/Listing', [ListingController::class, 'getAllListing']);
Route::post('/Filter', [ListingController::class, 'filter']);    
Route::post('/BusDetails', [ListingController::class, 'busDetails']);
Route::post('/viewSeats', [ViewSeatsController::class, 'getAllViewSeats']);
Route::post('/BoardingDroppingPoints', [ViewSeatsController::class, 'getBoardingDroppingPoints']);
Route::post('/PriceOnSeatsSelection', [ViewSeatsController::class, 'getPriceOnSeatsSelection']);
Route::post('/BookTicket', [BookTicketController::class, 'bookTicket']);
Route::post('/SendSms', [ChannelController::class, 'sendSms']);   
Route::post('/smsDeliveryStatus', [ChannelController::class, 'smsDeliveryStatus']);
Route::post('/MakePayment', [ChannelController::class, 'makePayment']);
Route::post('/CheckSeatStatus', [ChannelController::class, 'checkSeatStatus']);
Route::post('/PaymentStatus', [ChannelController::class, 'pay']);
Route::post('/UpdateAdjustStatus', [ChannelController::class, 'UpdateAdjustStatus']);
Route::post('/BlockDolphinSeat', [ChannelController::class, 'BlockDolphinSeat']);
Route::post('/CancelDolphinSeat', [CancelTicketController::class, 'CancelDolphinSeat']);
  
//Route::post('/storeGWInfo', [ChannelController::class, 'storeGWInfo']);
Route::get('/PopularRoutes', [PopularController::class, 'getPopularRoutes']);
Route::get('/TopOperators', [PopularController::class, 'getTopOperators']);
Route::get('/AllRoutes', [PopularController::class, 'allRoutes']);
Route::post('/AllOperators', [PopularController::class, 'allOperators']);
Route::get('/OperatorDetails', [PopularController::class, 'operatorDetails']);
Route::post('/saveContacts', [ContactController::class, 'save']);
Route::post('/CancelTicket', [CancelTicketController::class, 'cancelTicket']);
Route::post('/Offers', [OfferController::class, 'offers']);
Route::post('/Coupons', [OfferController::class, 'coupons']);
Route::post('/JourneyDetails', [BookingManageController::class, 'getJourneyDetails']);
Route::post('/PassengerDetails', [BookingManageController::class, 'getPassengerDetails']);
Route::post('/BookingDetails', [BookingManageController::class, 'getBookingDetails']);
Route::post('/EmailSms', [BookingManageController::class, 'emailSms']);
Route::post('/cancelTicketInfo', [BookingManageController::class, 'cancelTicketInfo']);
Route::post('/AgentcancelTicketOTP', [BookingManageController::class, 'agentcancelTicketOTP']);
Route::post('/AgentcancelTicket', [BookingManageController::class, 'agentcancelTicket']);

Route::get('/allReviews', [ReviewController::class, 'getAllReview']);
//Route::get('/SingleBusReviewList/{bid}', [ReviewController::class, 'getReviewByBid']);
Route::post('/AddReview', [ReviewController::class, 'createReview']);
Route::put('/UpdateReview/{id}', [ReviewController::class, 'updateReview']);
Route::delete('/DeleteReview/{id}/{userId}', [ReviewController::class, 'deleteReview']);
//Route::get('/ReviewDetail/{id}', [ReviewController::class, 'getReview']);
Route::post('/Register', [UsersController::class, 'Register']);
Route::post('/VerifyOtp', [UsersController::class, 'verifyOtp']);
Route::post('/Login', [UsersController::class, 'login']); 
Route::get('/UserProfile', [UsersController::class, 'userProfile']);
//Route::put('/updateProfile/{userId}/{token}', [UsersController::class, 'updateProfile']);
Route::post('/updateProfile', [UsersController::class, 'updateProfile']);
Route::post('/updateProfileImage', [UsersController::class, 'updateProfileImage']);
Route::post('/BookingHistory', [UsersController::class, 'BookingHistory']);
Route::post('/AppBookingHistory', [UsersController::class, 'AppBookingHistory']);
Route::get('/UserReviews', [UsersController::class, 'userReviews']);
Route::post('/CommonService', [CommonController::class, 'getAll']);
Route::post('/GetTestimonial', [TestimonialController::class, 'getAlltestimonial']);
Route::post('/GetPageData',[PageContentController::class,'getAllpagecontent']);
//Route::post('/AgentLogin', [UserController::class, 'login']);
Route::post('/AgentBooking', [AgentBookingController::class, 'agentBooking']);
Route::post('/AgentWalletPayment', [ChannelController::class, 'walletPayment']);
Route::post('/AgentPaymentStatus', [ChannelController::class, 'agentPaymentStatus']);
Route::get('/AllPathUrls', [OfferController::class, 'getPathUrls']);
Route::get('/seolist', [SeoController::class, 'seolist']);
Route::post('/RecentSearch', [RecentSearchController::class, 'createSearch']);
Route::get('/RecentSearch/{userId}', [RecentSearchController::class, 'getSearchDetails']);
//Route::get('/busSeats', [ArticleController::class, 'getBusSeats']);
Route::post('/downloadapp', [PopularController::class, 'downloadApp']);
Route::post('/GenerateFailedTicket', [ChannelController::class, 'generateFailedTicket']);
Route::get('/getPnrDetail/{pnr}', [BookingManageController::class, 'pnrDetail']);

Route::post('/PassengerInfo', [ClientBookingController::class, 'clientBooking']);

Route::group(['excluded_middleware' => 'throttle:api'], function() {
   Route::post('/SeatBlock', [ClientBookingController::class, 'seatBlock']);
   Route::post('/TicketConfirmation', [ClientBookingController::class, 'ticketConfirmation']);         
});


Route::post('/ClientCancelticket', [ClientBookingController::class, 'clientCancelTicket']);
Route::post('/ClientCancelTicketinfo', [ClientBookingController::class, 'clientCancelTicketInfos']);
Route::post('/ClientTicketCancellation', [ClientBookingController::class, 'clientTicketCancel']);
Route::post('/TicketDetails', [ClientBookingController::class, 'ticketDetails']);
Route::get('/WalletBalance', [ClientBookingController::class, 'walletBalance']);

Route::post('/GetFAQ', [TestimonialController::class, 'getFAQ']);
Route::get('/CityPair', [PopularController::class, 'CityPair']);
Route::post('/SendNotification', [UsersController::class, 'sendNotification']);
Route::post('/PopularInfo', [HomepageController::class, 'homePage']);
Route::post('/ResendOTP', [UsersController::class, 'resendOTP']);
Route::post('/apiReference', [ApiReferenceController::class, 'apiReference']);
Route::get('/GetPnr/{trans_id}', [BookingManageController::class, 'GetPnr']);

});

Route::match(['get', 'post'], 'botman', [BotManController::class, 'handle']);
Route::post('/ClientLogin', [UserController::class, 'clientLogin']);
Route::get('/ClientDetails', [UserController::class, 'clienDetails']); 
Route::post('/RazorpayWebhook', [ChannelController::class, 'RazorpayWebhook']);
Route::get('/Appversion', [CommonController::class, 'Appversion']);
Route::get('/testing', [ChannelController::class, 'testing']);
Route::post('/ClientCancelTicket', [ClientBookingController::class, 'clientCancelTicket']);
Route::post('/ClientCancelTicketInfo', [ClientBookingController::class, 'clientCancelTicketInfo']);

Route::get('/UpdateDolphinApiLocation', [ListingController::class, 'UpdateExternalApiLocation']);
Route::get('/countries', [SoapController::class, 'getCountries']);
Route::get('/DolphinCancelPolicy', [SoapController::class, 'DolphinCancelPolicy']);
Route::get('/DolphinCronJobEmailSms', [SoapController::class, 'DolphinCronJobEmailSms']);
Route::get('/FeedbackCronJob', [BookingManageController::class, 'FeedbackCronJob']);
Route::get('/UpdateMantisApiLocation', [ListingController::class, 'updateMantisApiLocation']);
Route::get('/GetToken', [MantisController::class, 'getToken']);

//});





