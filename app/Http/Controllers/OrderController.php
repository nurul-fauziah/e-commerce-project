<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerDataRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\ProductTransaction;
use App\Models\Product;
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

    // Step 1: Simpan produk & varian ke session
    public function saveOrder(StoreOrderRequest $request, Product $product)
    {
        $validated = $request->validated();
        $validated['product_id'] = $product->id;

        $this->orderService->beginOrder($validated);

        return redirect()->route('front.booking');
    }

    // Step 2: Tampilkan ringkasan order
    public function booking()
    {
        $data = $this->orderService->getOrderDetails();
        if (!$data['product']) return redirect()->route('front.index');

        return view('order.order', $data);
    }

    // Step 3: Form Data Diri
    public function customerData()
    {
        $data = $this->orderService->getOrderDetails();
        if (!$data['product']) return redirect()->route('front.index');

        return view('order.customer_data', $data);
    }

    // Step 4: Simpan data diri ke session & buat transaksi di DB

    public function saveCustomerData(StoreCustomerDataRequest $request)
    {
        $validated = $request->validated();

        // 1. Update data customer di session
        $this->orderService->updateCustomerData($validated);

        // 2. PINDAHKAN DATA DARI SESSION KE DATABASE (Penting!)
        $transactionId = $this->orderService->finalizeOrder();

        if ($transactionId) {
            // 3. Simpan ID transaksi ke session buat dipake di halaman payment
            session()->put('transaction_id', $transactionId);

            return redirect()->route('front.payment');
        }

        // Kalau gagal simpan ke DB, balik ke form dengan error
        return redirect()->back()->withErrors(['error' => 'Failed to initialize transaction. Check your database logs.']);
    }



    // Step 5: Halaman Pembayaran (Munculin Tombol Bayar)
    public function payment()
    {
        // Ambil ID dari session
        $id = session()->get('transaction_id');

        if (!$id) {
            // Kalau ID nggak ada di session, lempar ke home (ini yang bikin lo balik ke awal)
            return redirect()->route('front.index')->withErrors(['error' => 'No active transaction found.']);
        }

        $transaction = ProductTransaction::findOrFail($id);

        try {
            $snapToken = $this->orderService->getSnapToken($id);
            return view('order.payment', compact('transaction', 'snapToken'));
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->route('front.index')->withErrors(['error' => 'Payment gateway error.']);
        }
    }

    // Step 6: Halaman Sukses
    public function orderFinished(ProductTransaction $productTransaction)
    {
        return view('order.order_finished', compact('productTransaction'));
    }
}
