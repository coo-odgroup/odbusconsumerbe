<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ViewSeatsController;
use App\Http\Controllers\BookTicketController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PopularController;
use App\Http\Middleware\LogRoute;

//Route::middleware([LogRoute::class])->group(function () {

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

//});




