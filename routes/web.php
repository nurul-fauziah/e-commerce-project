<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES (Bisa liat-liat doang) ---
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/browse/category/{slug}', [FrontController::class, 'category'])->name('front.category');
Route::get('/details/{product:slug}', [FrontController::class, 'details'])->name('front.details');

// --- PROTECTED ROUTES (Wajib Login/Daftar buat Checkout) ---
Route::middleware('auth')->group(function () {

    // 1. Mulai Order (Simpan pilihan ke session/service)
    Route::post('/order/begin/{product:slug}', [OrderController::class, 'saveOrder'])->name('front.save_order');

    // 2. Review Order (Halaman Booking)
    Route::get('/order/booking', [OrderController::class, 'booking'])->name('front.booking');

    // 3. Input Data Pelanggan
    Route::get('/order/booking/customer-data', [OrderController::class, 'customerData'])->name('front.customer_data');
    Route::post('/order/booking/customer-data/save', [OrderController::class, 'saveCustomerData'])->name('front.save_customer_data');

    // 4. Pembayaran (Payment Gateway)
    Route::post('/order/payment/confirm', [OrderController::class, 'paymentConfirm'])->name('front.payment_confirm');
    Route::get('/order/payment', [OrderController::class, 'payment'])->name('front.payment');
    
    // 5. Success Page
    Route::get('/order/finished/{productTransaction:id}', [OrderController::class, 'orderFinished'])->name('front.order_finished');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
