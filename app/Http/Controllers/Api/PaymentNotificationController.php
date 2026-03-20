<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentNotificationController extends Controller
{
    public function handler(Request $request)
    {
        // 1. Set Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            // 2. Tangkap Notifikasi dari Midtrans
            $notif = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id; // Ini adalah booking_trx_id kita

        // 3. Cari Transaksi di Database
        $transaction = ProductTransaction::where('booking_trx_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // 4. Update Status Berdasarkan Laporan Midtrans
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Pembayaran Berhasil
            $transaction->update([
                'is_paid' => true,
                'status'  => 'paid' // Atau 'processing' sesuai logic bisnis lu
            ]);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            // Pembayaran Gagal / Kedaluwarsa
            $transaction->update([
                'is_paid' => false,
                'status'  => 'canceled'
            ]);
        } elseif ($transactionStatus == 'pending') {
            // Menunggu Pembayaran
            $transaction->update([
                'is_paid' => false,
                'status'  => 'pending'
            ]);
        }

        return response()->json(['message' => 'Notification successfully processed']);
    }
}
