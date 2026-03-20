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
        $success = $this->orderService->beginCheckout();

        if (!$success) {
            return redirect()->route('front.cart')->withErrors(['error' => 'Keranjang kosong. Tidak dapat melakukan checkout.']);
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

        if ($transactionId) {
            session()->put('transaction_id', $transactionId);
            // PERBAIKAN: Memaksa penyimpanan session sebelum redirect
            session()->save();

            return redirect()->route('order.payment');
        }

        return redirect()->back()->withErrors(['error' => 'Gagal membuat ID Transaksi.']);
    }

    public function payment()
    {
        $id = session()->get('transaction_id');

        // CEK 1: Apakah Session berhasil tersimpan?
        if (!$id) {
            dd('ERROR CEK 1: Session transaction_id KOSONG! Artinya proses saveCustomerData gagal menyimpan session.');
        }

        $transaction = ProductTransaction::findOrFail($id);

        try {
            $snapToken = $this->orderService->getSnapToken($id);
            return view('order.payment', compact('transaction', 'snapToken'));
        } catch (\Exception $e) {
            // CEK 2: Apakah Midtrans menolak data kita?
            dd('ERROR CEK 2 (MIDTRANS MENOLAK): ' . $e->getMessage());
        }
    }

    // Step 6: Halaman Sukses
    public function orderFinished($id)
    {
        // Panggil transaksi beserta detail dan produknya
        $productTransaction = ProductTransaction::with('transactionDetails.product')->findOrFail($id);

        return view('order.order_finished', compact('productTransaction'));
    }
}
