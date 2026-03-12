<?php

namespace App\Http\Controllers;

use App\Models\ProductTransaction;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi milik user yang login, urutkan dari yang terbaru
        $orders = ProductTransaction::with('product')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('order.my_orders', compact('orders'));
    }

    public function show(ProductTransaction $productTransaction)
    {
        // Pastiin user cuma bisa liat punya dia sendiri
        if ($productTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.my_order_details', compact('productTransaction'));
    }
}
