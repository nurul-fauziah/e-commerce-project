<?php

namespace App\Http\Controllers;

use App\Models\ProductTransaction;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {
        $orders = ProductTransaction::with('transactionDetails.product')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('order.my_order', compact('orders'));
    }

    public function show(ProductTransaction $productTransaction)
    {
        if ($productTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        // Load relasi untuk detailnya
        $productTransaction->load('transactionDetails.product');

        return view('order.my_order_details', compact('productTransaction'));
    }
}
