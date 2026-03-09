<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama & Katalog
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/browse/category/{slug}', [FrontController::class, 'category'])->name('front.category');

// Detail Produk
Route::get('/details/{product:slug}', [FrontController::class, 'details'])->name('front.details');

// Alur Pemesanan (Checkout)
// 1. Mulai Order (Pilih Varian)
Route::post('/order/begin/{product:slug}', [OrderController::class, 'saveOrder'])->name('front.save_order');

// 2. Ringkasan Booking (Review Order)
Route::get('/order/booking', [OrderController::class, 'booking'])->name('front.booking');

// 3. Input Data Pelanggan
Route::get('/order/booking/customer-data', [OrderController::class, 'customerData'])->name('front.customer_data');
Route::post('/order/booking/customer-data/save', [OrderController::class, 'saveCustomerData'])->name('front.save_customer_data');

// 4. Pembayaran
Route::get('/order/payment', [OrderController::class, 'payment'])->name('front.payment');
Route::post('/order/payment/confirm', [OrderController::class, 'paymentConfirm'])->name('front.payment_confirm');

// 5. Selesai (Success Page)
Route::get('/order/finished/{productTransaction:id}', [OrderController::class, 'orderFinished'])->name('front.order_finished');