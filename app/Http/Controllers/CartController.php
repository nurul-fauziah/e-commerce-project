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
        $quantity = $request->input('quantity', 1); // Default 1 jika tidak ada input qty

        // Tentukan harga dan stok dasar (berasumsi dari produk utama)
        $finalPrice = $product->price;
        $availableStock = $product->stock;

        // Jika pembeli memilih varian spesifik (misal: RAM 16GB, 512GB SSD)
        if ($variantId) {
            $variant = ProductVariant::find($variantId);

            if ($variant) {
                // Gunakan harga varian jika di-set lebih dari 0, jika tidak gunakan harga dasar produk
                $finalPrice = $variant->price > 0 ? $variant->price : $product->price;
                $availableStock = $variant->stock;
            } else {
                return redirect()->back()->withErrors(['error' => 'Konfigurasi spesifikasi tidak ditemukan.']);
            }
        }

        // Validasi ketersediaan stok fisik
        if ($availableStock < $quantity) {
            return redirect()->back()->withErrors(['error' => 'Stok hardware tidak mencukupi untuk spesifikasi ini.']);
        }

        // Ambil keranjang saat ini
        $cart = session()->get('cart', []);

        // Buat ID unik untuk item di keranjang.
        // Kenapa? Agar "MacBook RAM 8GB" dan "MacBook RAM 16GB" dihitung sebagai 2 baris berbeda di keranjang.
        $cartKey = $variantId ? $product->id . '-' . $variantId : $product->id . '-std';

        // Logika Penambahan Item
        if (isset($cart[$cartKey])) {
            // Jika produk dengan spek yang sama persis sudah ada, tambah kuantitasnya
            $newQuantity = $cart[$cartKey]['quantity'] + $quantity;

            // Cek ulang stok sebelum menambah kuantitas di keranjang
            if ($newQuantity > $availableStock) {
                return redirect()->back()->withErrors(['error' => 'Batas maksimal stok tercapai.']);
            }

            $cart[$cartKey]['quantity'] = $newQuantity;
            $cart[$cartKey]['subtotal'] = $cart[$cartKey]['quantity'] * $cart[$cartKey]['price'];
        } else {
            // Jika item benar-benar baru di keranjang
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

        // Simpan kembali array yang sudah di-update ke dalam Laravel Session
        session()->put('cart', $cart);

        return redirect()->route('front.cart')->with('success', 'Hardware berhasil ditambahkan ke keranjang.');
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
