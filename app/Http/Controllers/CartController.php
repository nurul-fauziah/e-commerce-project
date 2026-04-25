<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang belanja.
     */
    public function index()
    {
        // Ambil data keranjang dari session, default array kosong jika belum ada
        $cart = session()->get('cart', []);

        // Kalkulasi total harga keranjang
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['subtotal'];
        }

        return view('order.cart', compact('cart', 'totalAmount'));
    }

    /**
     * Menambahkan produk & varian spesifikasinya ke keranjang.
     */
public function add(Request $request, Product $product)
    {
        $variantId = $request->input('variant_id');
        $variantDetails = $request->input('variant_details');
        $quantity = (int) $request->input('quantity', 1);
        $action = $request->input('action', 'cart');

        $finalPrice = $product->price;
        $availableStock = $product->stock;

        if ($variantId) {
            $variant = \App\Models\ProductVariant::find($variantId);
            if ($variant) {
                $finalPrice = $variant->price > 0 ? $variant->price : $product->price;
                $availableStock = $variant->stock;
            } else {
                return redirect()->back()->withErrors(['error' => 'Konfigurasi tidak ditemukan.']);
            }
        }

        if ($availableStock < $quantity) {
            return redirect()->back()->withErrors(['error' => 'Stok tidak mencukupi.']);
        }

        $cart = session()->get('cart', []);
        $cartKey = $variantId ? $product->id . '-' . $variantId : $product->id . '-std';

        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $quantity;
            if ($newQuantity > $availableStock) {
                return redirect()->back()->withErrors(['error' => 'Batas maksimal stok tercapai.']);
            }
            $cart[$cartKey]['quantity'] = $newQuantity;
            $cart[$cartKey]['subtotal'] = $cart[$cartKey]['quantity'] * $cart[$cartKey]['price'];
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'variant_id' => $variantId,
                'name' => $product->name,
                'thumbnail' => $product->thumbnail,
                'variant_details' => $variantDetails ?: 'Standard Configuration',
                'price' => $finalPrice,
                'quantity' => $quantity,
                'subtotal' => $finalPrice * $quantity,
                'slug' => $product->slug,
            ];
        }

        session()->put('cart', $cart);

        // --- PERBAIKAN LOGIKA BUY NOW ---
        if ($action === 'buy_now') {
            // 1. Kunci ID barang yang mau dibeli instan
            session()->put('selected_cart_keys', [$cartKey]);

            // 2. Panggil mesin kalkulator OrderService secara manual
            $orderService = app(\App\Services\OrderService::class);
            $success = $orderService->beginCheckout();

            if (!$success) {
                return redirect()->back()->withErrors(['error' => 'Gagal memproses kalkulasi Buy Now.']);
            }

            // 3. Setelah kalkulasi selesai, baru lempar ke halaman Booking
            return redirect()->route('front.booking');
        }

        // Jika hanya Add to Cart biasa
        return redirect()->route('front.cart')->with('success', 'Hardware berhasil ditambahkan.');
    }

    /**
     * Menghapus item spesifik dari keranjang.
     */
    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Hardware dihapus dari keranjang.');
    }
}
