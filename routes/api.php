<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShopApiController;
use App\Http\Controllers\Api\PaymentNotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// B2C Public Routes
Route::get('/shop-data', [ShopApiController::class, 'index']);
Route::get('/category/{category:slug}', [ShopApiController::class, 'category']);
Route::get('/product/{product:slug}', [ShopApiController::class, 'details']);
Route::post('/check-booking', [ShopApiController::class, 'checkBooking']);
Route::post('/midtrans/notification', [PaymentNotificationController::class, 'handler']);
