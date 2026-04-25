<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransCallbackController;

// --- PUBLIC ROUTES ---
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/catalog', [FrontController::class, 'catalog'])->name('front.catalog');
Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');
Route::get('/details/{product:slug}', [FrontController::class, 'details'])->name('front.details');

// --- CART ROUTES ---
Route::get('/cart', [CartController::class, 'index'])->name('front.cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('front.cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('front.cart.remove');

// --- PROTECTED ROUTES ---
Route::middleware('auth')->group(function () {
    Route::post('/checkout/begin', [OrderController::class, 'beginCheckout'])->name('front.begin_checkout');
    Route::get('/checkout/booking', [OrderController::class, 'booking'])->name('front.booking');
    Route::get('/checkout/customer-data', [OrderController::class, 'customerData'])->name('order.customer_data');
    Route::post('/checkout/customer-data/save', [OrderController::class, 'saveCustomerData'])->name('order.save_customer_data');
    Route::get('/checkout/payment', [OrderController::class, 'payment'])->name('order.payment');
    Route::get('/checkout/finished/{id}', [OrderController::class, 'orderFinished'])->name('order.order_finished');

    Route::get('/my-orders', [MyOrderController::class, 'index'])->name('order.my_orders');
    Route::get('/my-orders/details/{productTransaction}', [MyOrderController::class, 'show'])->name('order.my_order_details');
});

// --- AUTH ROUTES ---
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- COMPARE ROUTES ---
Route::get('/compare', [CompareController::class, 'index'])->name('front.compare');
Route::get('/compare/add/{id}', [CompareController::class, 'add'])->name('front.compare.add');
Route::get('/compare/remove/{id}', [CompareController::class, 'remove'])->name('front.compare.remove');

// --- PROTOCOL & DOCUMENT ROUTES ---
Route::get('/protocol/warranty-claim', [PageController::class, 'warranty'])->name('front.warranty');
Route::get('/protocol/privacy-policy', [PageController::class, 'privacy'])->name('front.privacy');
Route::get('/protocol/terms-of-service', [PageController::class, 'terms'])->name('front.terms');
Route::get('/support/contact', [PageController::class, 'contact'])->name('front.contact');



Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])
    ->name('midtrans.callback');
