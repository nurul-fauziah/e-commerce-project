<?php

namespace App\Http\Controllers;

use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Midtrans callback received', $request->all());

        if ($request->order_id && str_starts_with($request->order_id, 'payment_notif_test_')) {
            return response()->json([
                'message' => 'Midtrans test notification OK',
            ], 200);
        }

        if (!$request->order_id) {
            return response()->json([
                'message' => 'Order ID is required',
            ], 400);
        }

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

        // Contoh order_id dari Midtrans:
        // INV-20260427-ABC123-PAY-1714210000
        // Yang dicari di DB tetap invoice asli:
        // INV-20260427-ABC123
        $invoiceNumber = preg_replace('/-PAY-\d+$/', '', $request->order_id);

        $transaction = ProductTransaction::where('invoice_number', $invoiceNumber)->first();

        if (!$transaction) {
            Log::warning('Midtrans transaction not found', [
                'order_id' => $request->order_id,
                'invoice_number' => $invoiceNumber,
            ]);

            return response()->json([
                'message' => 'Transaction not found',
            ], 404);
        }

        $transactionStatus = $request->transaction_status;

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
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
        ], 200);
    }
}
