<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerDataRequest;
use App\Models\ProductTransaction;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function beginCheckout(Request $request)
    {
        $request->validate([
            'cart_keys' => 'required|array|min:1',
        ]);

        session()->put('selected_cart_keys', $request->cart_keys);

        $success = $this->orderService->beginCheckout();

        if (!$success) {
            return redirect()
                ->route('front.cart')
                ->withErrors(['error' => 'Gagal memproses pilihan keranjang.']);
        }

        return redirect()->route('front.booking');
    }

    public function booking()
    {
        $data = $this->orderService->getOrderDetails();

        if (empty($data['orderData']['cart_items'])) {
            return redirect()->route('front.cart');
        }

        return view('order.order', $data);
    }

    public function customerData()
    {
        $data = $this->orderService->getOrderDetails();

        if (empty($data['orderData']['cart_items'])) {
            return redirect()->route('front.cart');
        }

        return view('order.customer_data', $data);
    }

    public function saveCustomerData(StoreCustomerDataRequest $request)
    {
        $validated = $request->validated();

        $this->orderService->updateCustomerData($validated);

        $transactionId = $this->orderService->finalizeOrder();

        if (!$transactionId) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Gagal membuat ID Transaksi.']);
        }

        session()->put('transaction_id', $transactionId);
        session()->save();

        return redirect()->route('order.payment');
    }


    public function orderFinished($id)
    {
        $transaction = ProductTransaction::with('transactionDetails.product')
            ->findOrFail($id);

        return view('order.order_finished', compact('transaction'));
    }

    public function payment()
    {
        $id = session()->get('transaction_id');

        if (!$id) {
            return redirect()
                ->route('front.cart')
                ->withErrors(['error' => 'Sesi pembayaran tidak ditemukan. Silakan checkout ulang.']);
        }

        $transaction = ProductTransaction::findOrFail($id);

        return $this->showPaymentPage($transaction);
    }

    public function retryPayment(ProductTransaction $productTransaction)
    {
        if ($productTransaction->user_id !== auth()->id()) {
            abort(403);
        }

        if ($productTransaction->status !== 'pending') {
            return redirect()
                ->route('order.order_finished', $productTransaction->id)
                ->withErrors(['error' => 'Pembayaran tidak bisa diubah karena status sudah final.']);
        }

        session()->put('transaction_id', $productTransaction->id);
        session()->save();

        return $this->showPaymentPage($productTransaction);
    }

    private function showPaymentPage(ProductTransaction $transaction)
    {
        try {
            $snapToken = $this->orderService->getSnapToken($transaction->id);

            return view('order.payment', compact('transaction', 'snapToken'));
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());

            return redirect()
                ->route('order.order_finished', $transaction->id)
                ->withErrors(['error' => 'Gagal membuka pembayaran. Silakan coba lagi.']);
        }
    }
}
