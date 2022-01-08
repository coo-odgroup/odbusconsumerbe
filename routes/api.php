<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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


Route::post('/countries', [SoapController::class, 'getCountries']);
//Route::group(['middleware' => ['check.scope:read:messages']], function() { 
    /*Route::get('/getLocation', [ListingController::class, 'getLocation']);
    Route::get('/FilterOptions', [ListingController::class, 'getFilterOptions']);
    Route::get('/Listing', [ListingController::class, 'getAllListing']);
    Route::get('/Filter', [ListingController::class, 'filter']);    
    Route::get('/BusDetails', [ListingController::class, 'busDetails']);

    Route::get('/viewSeats', [ViewSeatsController::class, 'getAllViewSeats']);
    Route::get('/BoardingDroppingPoints', [ViewSeatsController::class, 'getBoardingDroppingPoints']);
    Route::get('/PriceOnSeatsSelection', [ViewSeatsController::class, 'getPriceOnSeatsSelection']);

    Route::post('/BookTicket', [BookTicketController::class, 'bookTicket']);

    Route::post('/SendSms', [ChannelController::class, 'sendSms']);
    //Route::post('/SendSmsTicket', [ChannelController::class, 'sendSmsTicket']);
    Route::post('/smsDeliveryStatus', [ChannelController::class, 'smsDeliveryStatus']);
    Route::post('/MakePayment', [ChannelController::class, 'makePayment']);
    Route::post('/PaymentStatus', [ChannelController::class, 'pay']);
    Route::post('/TestingEmail', [ChannelController::class, 'testingEmail']);
    //Route::post('/SendEmail', [ChannelController::class, 'sendEmail']);
    //Route::post('/SendEmailTicket', [ChannelController::class, 'sendEmailTicket']);
    Route::post('/storeGWInfo', [ChannelController::class, 'storeGWInfo']);

    Route::get('/PopularRoutes', [PopularController::class, 'getPopularRoutes']);
    Route::get('/TopOperators', [PopularController::class, 'getTopOperators']);
    Route::get('/AllRoutes', [PopularController::class, 'allRoutes']);
    Route::get('/AllOperators', [PopularController::class, 'allOperators']);
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

    Route::get('/allReviews', [ReviewController::class, 'getAllReview']);
    Route::get('/SingleBusReviewList/{bid}', [ReviewController::class, 'getReviewByBid']);
    Route::post('/AddReview', [ReviewController::class, 'createReview']);
    Route::put('/UpdateReview/{id}', [ReviewController::class, 'updateReview']);
    Route::delete('/DeleteReview/{id}', [ReviewController::class, 'deleteReview']);
    Route::get('/ReviewDetail/{id}', [ReviewController::class, 'getReview']);

    Route::post('/Register', [UsersController::class, 'Register']);
    Route::post('/VerifyOtp', [UsersController::class, 'verifyOtp']);
    Route::post('/Login', [UsersController::class, 'login']); 
    Route::get('/UserProfile', [UsersController::class, 'userProfile']);
    Route::put('/updateProfile/{userId}/{token}', [UsersController::class, 'updateProfile']);
    Route::post('/updateProfile', [UsersController::class, 'updateProfile']);
    Route::post('/BookingHistory', [UsersController::class, 'BookingHistory']);
    Route::get('/UserReviews', [UsersController::class, 'userReviews']);

    Route::post('/CommonService', [CommonController::class, 'getAll']);
    Route::post('/GetTestimonial', [TestimonialController::class, 'getAlltestimonial']);
    Route::post('/GetPageData',[PageContentController::class,'getAllpagecontent']);
    Route::post('/AgentLogin', [UserController::class, 'login']);
    Route::post('/AgentBooking', [AgentBookingController::class, 'agentBooking']);
    Route::post('/AgentWalletPayment', [ChannelController::class, 'walletPayment']);
    Route::post('/AgentPaymentStatus', [ChannelController::class, 'agentPaymentStatus']);

    Route::get('/AllPathUrls', [OfferController::class, 'getPathUrls']);
    Route::get('/seolist', [SeoController::class, 'seolist']);
    Route::post('/RecentSearch', [RecentSearchController::class, 'createSearch']);
    Route::get('/RecentSearch/{userId}', [RecentSearchController::class, 'getSearchDetails']);*/
//});


Route::post('/RazorpayWebhook', [ChannelController::class, 'RazorpayWebhook']);
Route::match(['get', 'post'], 'botman', [BotManController::class, 'handle']);



Route::middleware(['checkIp'])->group(function () {
    Route::get('/getLocation', [ListingController::class, 'getLocation']);
    Route::get('/FilterOptions', [ListingController::class, 'getFilterOptions']);
    Route::get('/Listing', [ListingController::class, 'getAllListing']);
    Route::get('/Filter', [ListingController::class, 'filter']);    
    Route::get('/BusDetails', [ListingController::class, 'busDetails']);
    Route::get('/viewSeats', [ViewSeatsController::class, 'getAllViewSeats']);
    Route::get('/BoardingDroppingPoints', [ViewSeatsController::class, 'getBoardingDroppingPoints']);
    Route::get('/PriceOnSeatsSelection', [ViewSeatsController::class, 'getPriceOnSeatsSelection']);
    Route::post('/BookTicket', [BookTicketController::class, 'bookTicket']);
    Route::post('/SendSms', [ChannelController::class, 'sendSms']);   
    Route::post('/smsDeliveryStatus', [ChannelController::class, 'smsDeliveryStatus']);
    Route::post('/MakePayment', [ChannelController::class, 'makePayment']);
    Route::post('/PaymentStatus', [ChannelController::class, 'pay']);
    Route::post('/TestingEmail', [ChannelController::class, 'testingEmail']);   
    Route::post('/storeGWInfo', [ChannelController::class, 'storeGWInfo']);
    Route::get('/PopularRoutes', [PopularController::class, 'getPopularRoutes']);
    Route::get('/TopOperators', [PopularController::class, 'getTopOperators']);
    Route::get('/AllRoutes', [PopularController::class, 'allRoutes']);
    Route::get('/AllOperators', [PopularController::class, 'allOperators']);
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
    Route::get('/allReviews', [ReviewController::class, 'getAllReview']);
    Route::get('/SingleBusReviewList/{bid}', [ReviewController::class, 'getReviewByBid']);
    Route::post('/AddReview', [ReviewController::class, 'createReview']);
    Route::put('/UpdateReview/{id}', [ReviewController::class, 'updateReview']);
    Route::delete('/DeleteReview/{id}', [ReviewController::class, 'deleteReview']);
    Route::get('/ReviewDetail/{id}', [ReviewController::class, 'getReview']);
    Route::post('/Register', [UsersController::class, 'Register']);
    Route::post('/VerifyOtp', [UsersController::class, 'verifyOtp']);
    Route::post('/Login', [UsersController::class, 'login']); 
    Route::get('/UserProfile', [UsersController::class, 'userProfile']);
    Route::put('/updateProfile/{userId}/{token}', [UsersController::class, 'updateProfile']);
    Route::post('/updateProfile', [UsersController::class, 'updateProfile']);
    Route::post('/BookingHistory', [UsersController::class, 'BookingHistory']);
    Route::get('/UserReviews', [UsersController::class, 'userReviews']);
    Route::post('/CommonService', [CommonController::class, 'getAll']);
    Route::post('/GetTestimonial', [TestimonialController::class, 'getAlltestimonial']);
    Route::post('/GetPageData',[PageContentController::class,'getAllpagecontent']);
    Route::post('/AgentLogin', [UserController::class, 'login']);
    Route::post('/AgentBooking', [AgentBookingController::class, 'agentBooking']);
    Route::post('/AgentWalletPayment', [ChannelController::class, 'walletPayment']);
    Route::post('/AgentPaymentStatus', [ChannelController::class, 'agentPaymentStatus']);
    Route::get('/AllPathUrls', [OfferController::class, 'getPathUrls']);
    Route::get('/seolist', [SeoController::class, 'seolist']);
    Route::post('/RecentSearch', [RecentSearchController::class, 'createSearch']);
    Route::get('/RecentSearch/{userId}', [RecentSearchController::class, 'getSearchDetails']);
});


