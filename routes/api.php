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

use App\Http\Middleware\LogRoute;
use Laravel\Passport\Passport;

//Route::middleware([LogRoute::class])->group(function () {

Route::get('/getLocation', [ListingController::class, 'getLocation']);
//Route::get('/BusOperators', [ListingController::class, 'getBusOpertors']);
Route::get('/FilterOptions', [ListingController::class, 'getFilterOptions']);
Route::post('/Listing', [ListingController::class, 'getAllListing']);
Route::post('/Filter', [ListingController::class, 'filter']);
Route::get('/viewSeats', [ViewSeatsController::class, 'getAllViewSeats']);
Route::get('/BoardingDroppingPoints', [ViewSeatsController::class, 'getBoardingDroppingPoints']);
Route::post('/PriceOnSeatsSelection', [ViewSeatsController::class, 'getPriceOnSeatsSelection']);
Route::post('/BookTicket', [BookTicketController::class, 'bookTicket']);
Route::post('/SendSms', [ChannelController::class, 'sendSms']);
Route::post('/SendEmail', [ChannelController::class, 'sendEmail']);
Route::post('/MakePayment', [ChannelController::class, 'makePayment']);
//Route::post('/Register', [UsersController::class, 'Register']);
Route::post('/RegisterSession', [UsersController::class, 'RegisterSession']);
Route::post('/Login', [UsersController::class, 'login']);
Route::post('/submitOtp', [UsersController::class, 'submitOtp']);


//});
//Route::post('/sendSmstextLocal', [ChannelController::class, 'sendSmstextLocal']);






