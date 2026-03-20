<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FrontService;
use App\Services\OrderService;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopApiController extends Controller
{
    protected $frontService;
    protected $orderService;

    public function __construct(FrontService $frontService, OrderService $orderService)
    {
        $this->frontService = $frontService;
        $this->orderService = $orderService;
    }

    // Untuk Halaman Home B2C (Banner, Kategori, Produk Populer)
    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Untuk Halaman Detail Produk
    public function details(Product $product)
    {
        $product->load(['category', 'brand', 'photos', 'variants']);
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    // Untuk Filter berdasarkan Kategori
    public function category(Category $category)
    {
        $category->load(['products.brand']);
        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    // Untuk Cek Status Pesanan (B2C Customer mau tau barangnya udah dikirim/belum)
    public function checkBooking(Request $request)
    {
        $request->validate([
            'booking_trx_id' => 'required',
            'phone' => 'required',
        ]);

        $transaction = $this->orderService->getBookingDetails($request->all());

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $transaction
        ]);
    }
}
