@extends('layouts.front')

@section('title', 'Review Pesanan - SmartTech')

@section('content')
<main class="st-page-wrap">

    <!-- HERO -->
    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">
            Step 1 of 3 • Review
        </span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4">
            Review Pesanan
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Pastikan produk, jumlah, dan total pembayaran sudah sesuai sebelum lanjut ke pengiriman.
        </p>
    </section>

    <div class="grid lg:grid-cols-12 gap-6">

        <!-- LEFT: ITEMS -->
        <section class="lg:col-span-8 space-y-4">

            @foreach($orderData['cart_items'] as $item)
                <div class="st-card p-5 flex flex-col md:flex-row gap-5">

                    <div class="w-28 h-28 rounded-xl overflow-hidden border border-slate-200 bg-white">
                        <img src="{{ is_string($item['thumbnail']) && str_starts_with($item['thumbnail'], 'http') ? $item['thumbnail'] : Storage::url($item['thumbnail']) }}"
                             class="w-full h-full object-cover"
                             alt="{{ $item['name'] }}">
                    </div>

                    <div class="flex-1">

                        <h3 class="st-title text-lg">
                            {{ $item['name'] }}
                        </h3>

                        <p class="st-muted text-sm mt-1">
                            Varian: {{ $item['variant_details'] ?? 'Standard' }}
                        </p>

                        <p class="st-muted text-sm mt-2">
                            Qty: {{ $item['quantity'] }}
                        </p>

                        <p class="mt-3 font-semibold text-slate-900">
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                        </p>

                    </div>

                    <div class="text-right">
                        <p class="st-muted text-xs">Subtotal</p>
                        <p class="text-lg font-black text-slate-950">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </p>
                    </div>

                </div>
            @endforeach

        </section>

        <!-- RIGHT: SUMMARY -->
        <aside class="lg:col-span-4">

            <div class="st-card p-6 sticky top-28">

                <h2 class="st-title text-xl mb-4">
                    Ringkasan Pembayaran
                </h2>

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between">
                        <span class="st-muted">Subtotal</span>
                        <span class="font-semibold text-slate-900">
                            Rp {{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Diskon</span>
                        <span class="text-emerald-600 font-semibold">
                            - Rp {{ number_format($orderData['discount_amount'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Pajak</span>
                        <span class="font-semibold text-slate-900">
                            Rp {{ number_format($orderData['total_tax'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

                <div class="border-t my-4"></div>

                <div class="flex justify-between items-center">
                    <span class="st-muted font-semibold">Total</span>
                    <span class="text-2xl font-black text-slate-950">
                        Rp {{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('order.customer_data') }}"
                   class="st-btn-accent w-full mt-5">
                    Lanjut ke Pengiriman →
                </a>

                <div class="mt-5 text-xs text-slate-500 space-y-1">
                    <p>✔ Pesanan akan diproses setelah pembayaran</p>
                    <p>✔ Simpan bukti transaksi</p>
                </div>

            </div>

        </aside>

    </div>

</main>
@endsection
