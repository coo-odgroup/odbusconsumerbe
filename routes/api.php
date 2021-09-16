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

//Route::middleware([LogRoute::class])->group(function () {
Route::get('/coreTable', [DTController::class, 'coreTable']);
Route::get('/HelloWorld', [DTController::class, 'HelloWorld']);

Route::get('/getLocation', [ListingController::class, 'getLocation']);
Route::get('/FilterOptions', [ListingController::class, 'getFilterOptions']);
Route::get('/Listing', [ListingController::class, 'getAllListing']);
Route::get('/Filter', [ListingController::class, 'filter']);
Route::get('/viewSeats', [ViewSeatsController::class, 'getAllViewSeats']);
Route::get('/BoardingDroppingPoints', [ViewSeatsController::class, 'getBoardingDroppingPoints']);
Route::get('/PriceOnSeatsSelection', [ViewSeatsController::class, 'getPriceOnSeatsSelection']);
Route::post('/BookTicket', [BookTicketController::class, 'bookTicket']);
Route::post('/SendSms', [ChannelController::class, 'sendSms']);
//Route::post('/SendSmsTicket', [ChannelController::class, 'sendSmsTicket']);
Route::post('/smsDeliveryStatus', [ChannelController::class, 'smsDeliveryStatus']);
Route::post('/MakePayment', [ChannelController::class, 'makePayment']);
Route::post('/PaymentStatus', [ChannelController::class, 'pay']);
Route::post('/Register', [UsersController::class, 'Register']);
Route::post('/VerifyOtp', [UsersController::class, 'verifyOtp']);
Route::post('/Login', [UsersController::class, 'login']);
Route::get('/UserProfile', [UsersController::class, 'userProfile']);
Route::post('/Logout', [UsersController::class, 'logout']);
Route::post('/RefreshToken', [UsersController::class, 'refreshToken']);
//Route::post('/SendEmail', [ChannelController::class, 'sendEmail']);
//Route::post('/SendEmailTicket', [ChannelController::class, 'sendEmailTicket']);
Route::post('/storeGWInfo', [ChannelController::class, 'storeGWInfo']);
Route::get('/BusDetails', [ListingController::class, 'busDetails']);
Route::get('/PopularRoutes', [PopularController::class, 'getPopularRoutes']);
Route::get('/TopOperators', [PopularController::class, 'getTopOperators']);
Route::get('/AllRoutes', [PopularController::class, 'allRoutes']);
Route::get('/AllOperators', [PopularController::class, 'allOperators']);
Route::get('/OperatorDetails', [PopularController::class, 'operatorDetails']);
Route::post('/CancelTicket', [CancelTicketController::class, 'cancelTicket']);


Route::post('/JourneyDetails', [BookingManageController::class, 'getJourneyDetails']);
Route::post('/PassengerDetails', [BookingManageController::class, 'getPassengerDetails']);
Route::post('/BookingDetails', [BookingManageController::class, 'getBookingDetails']);
Route::post('/EmailSms', [BookingManageController::class, 'emailSms']);
Route::post('/cancelTicketInfo', [BookingManageController::class, 'cancelTicketInfo']);


Route::post('/AddReview', [ReviewController::class, 'createReview']);
Route::get('/allReviews', [ReviewController::class, 'getAllReview']);
Route::put('/UpdateReview/{id}', [ReviewController::class, 'updateReview']);
Route::delete('/DeleteReview/{id}', [ReviewController::class, 'deleteReview']);
Route::get('/ReviewDetail/{id}', [ReviewController::class, 'getReview']);
Route::get('/SingleBusReviewList/{bid}', [ReviewController::class, 'getReviewByBid']);

//});




