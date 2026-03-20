<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MyOrderController;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES ---
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/browse/category/{slug}', [FrontController::class, 'category'])->name('front.category');
Route::get('/details/{product:slug}', [FrontController::class, 'details'])->name('front.details');

// --- CART ROUTES (Disimpan di Session, tidak harus login dulu) ---
Route::get('/cart', [CartController::class, 'index'])->name('front.cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('front.cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('front.cart.remove');

// --- PROTECTED ROUTES (Wajib Login buat Checkout) ---
Route::middleware('auth')->group(function () {
    // 1. Checkout dari Keranjang
    Route::post('/checkout/begin', [OrderController::class, 'beginCheckout'])->name('front.begin_checkout');

    // 2. Review Order
    Route::get('/checkout/booking', [OrderController::class, 'booking'])->name('front.booking');

    // 3. Input Data Pelanggan
    Route::get('/checkout/customer-data', [OrderController::class, 'customerData'])->name('order.customer_data');
    Route::post('/checkout/customer-data/save', [OrderController::class, 'saveCustomerData'])->name('order.save_customer_data');

    // 4. Pembayaran
    Route::get('/checkout/payment', [OrderController::class, 'payment'])->name('order.payment');

    // 5. Success Page
    Route::get('/checkout/finished/{id}', [OrderController::class, 'orderFinished'])->name('order.order_finished');

    // 👇 TAMBAHKAN DUA RUTE INI UNTUK TRACKING PESANAN (MY ORDERS) 👇
    // 6. My Orders (Riwayat Pesanan)
    Route::get('/my-orders', [MyOrderController::class, 'index'])->name('order.my_orders');
    Route::get('/my-orders/details/{productTransaction}', [MyOrderController::class, 'show'])->name('order.my_order_details');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

