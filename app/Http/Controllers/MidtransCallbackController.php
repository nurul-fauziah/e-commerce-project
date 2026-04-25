<?php

namespace App\Http\Controllers;

use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $signatureKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            Log::warning('Invalid Midtrans signature', $request->all());

            return response()->json([
                'message' => 'Invalid signature',
            ], 403);
        }

        $transaction = ProductTransaction::where('booking_trx_id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found',
            ], 404);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $transaction->update([
                    'status' => 'paid',
                    'is_paid' => true,
                    'payment_method' => $request->payment_type,
                ]);
            }
        } elseif ($transactionStatus === 'settlement') {
            $transaction->update([
                'status' => 'paid',
                'is_paid' => true,
                'payment_method' => $request->payment_type,
            ]);
        } elseif ($transactionStatus === 'pending') {
            $transaction->update([
                'status' => 'pending',
                'is_paid' => false,
                'payment_method' => $request->payment_type,
            ]);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $transaction->update([
                'status' => 'failed',
                'is_paid' => false,
                'payment_method' => $request->payment_type,
            ]);
        }

        return response()->json([
            'message' => 'Callback processed',
        ]);
    }
}
