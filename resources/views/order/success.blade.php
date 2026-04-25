@extends('layouts.front')

@section('title', 'Pembayaran Berhasil - SmartTech')

@section('content')
<main class="st-page-wrap">

    <!-- HERO -->
    <section class="st-hero p-6 md:p-10 mb-6 text-center">
        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">
            ✓
        </div>

        <span class="st-eyebrow st-eyebrow-blue">
            Order Successful
        </span>

        <h1 class="st-hero-title mt-4 text-3xl md:text-5xl">
            Pembayaran Berhasil
        </h1>

        <p class="st-hero-text mx-auto mt-4 max-w-2xl text-sm md:text-base">
            Terima kasih! Pesanan kamu sedang diproses 🚀
        </p>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1fr_360px]">

        <!-- LEFT -->
        <div class="space-y-6">

            <div class="st-card p-6 md:p-8">
                <h2 class="st-title text-2xl mb-5">
                    Ringkasan Transaksi
                </h2>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="st-muted">Order ID</span>
                        <span class="font-bold text-slate-900">
                            #{{ $order->id ?? 'ORD-XXXX' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Metode</span>
                        <span class="font-bold text-slate-900">
                            {{ $order->payment_method ?? 'Transfer Bank' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Total</span>
                        <span class="font-black text-slate-950 text-lg">
                            Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT -->
        <aside>
            <div class="st-card p-6">
                <h3 class="st-title text-xl mb-4">
                    Next Step
                </h3>

                <div class="grid gap-3">
                    <a href="{{ route('order.my_orders') }}" class="st-btn-primary w-full">
                        Lihat Pesanan
                    </a>

                    <a href="{{ route('front.catalog') }}" class="st-btn-ghost w-full">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </aside>

    </section>

</main>
@endsection
