<?php

namespace App\Http\Controllers;

use App\Models\ProductTransaction;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $productTransaction->load('transactionDetails.product');

        return view('order.my_order_details', compact('productTransaction'));
    }

    public function invoice(ProductTransaction $productTransaction)
    {
        if ($productTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        $productTransaction->load('transactionDetails.product');

        $pdf = Pdf::loadView('order.invoice_pdf', [
            'productTransaction' => $productTransaction,
        ]);

        return $pdf->download('invoice-' . $productTransaction->invoice_number . '.pdf');
    }
}
