@extends('layouts.front')

@section('title', 'Status Pesanan - SmartTech')

@section('content')
<main class="st-page-wrap">

    <!-- HERO STATUS -->
    <section class="st-hero p-6 md:p-10 mb-6 text-center">

        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-blue-600 ring-1 ring-blue-100">
            ⏳
        </div>

        <span class="st-eyebrow st-eyebrow-blue">
            Order Status
        </span>

        <h1 class="st-hero-title mt-4 text-3xl md:text-5xl">
            Pesanan Sedang Diproses
        </h1>

        <p class="st-hero-text mx-auto mt-4 max-w-2xl text-sm md:text-base">
            Pembayaran kamu sedang diverifikasi oleh sistem. Status akan otomatis diperbarui.
        </p>

    </section>

    <section class="grid gap-6 lg:grid-cols-[1fr_360px]">

        <!-- LEFT -->
        <div class="space-y-6">

            <!-- ORDER INFO -->
            <div class="st-card p-6 md:p-8">

                <h2 class="st-title text-2xl mb-5">
                    Informasi Pesanan
                </h2>

                <div class="space-y-4 text-sm">

                    <div class="flex justify-between">
                        <span class="st-muted">Transaction ID</span>
                        <span class="font-bold text-slate-900">
                            #{{ $transaction->booking_trx_id }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Status</span>
                        <span class="font-semibold text-blue-600">
                            {{ ucfirst($transaction->payment_status ?? 'Pending') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Total</span>
                        <span class="text-lg font-black text-slate-950">
                            Rp {{ number_format($transaction->grand_total_amount, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

            </div>

            <!-- STATUS INFO -->
            <div class="grid md:grid-cols-3 gap-4">

                <div class="st-card-soft p-5 text-center">
                    <div class="st-icon-blue mb-3 mx-auto">1</div>
                    <h3 class="st-subtitle">Verifikasi</h3>
                    <p class="st-muted text-xs mt-1">
                        Pembayaran dicek sistem
                    </p>
                </div>

                <div class="st-card-soft p-5 text-center">
                    <div class="st-icon-orange mb-3 mx-auto">2</div>
                    <h3 class="st-subtitle">Diproses</h3>
                    <p class="st-muted text-xs mt-1">
                        Pesanan disiapkan
                    </p>
                </div>

                <div class="st-card-soft p-5 text-center">
                    <div class="st-icon-green mb-3 mx-auto">3</div>
                    <h3 class="st-subtitle">Dikirim</h3>
                    <p class="st-muted text-xs mt-1">
                        Barang dikirim ke kamu
                    </p>
                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <aside class="lg:sticky lg:top-28 h-fit">

            <div class="st-card p-6">

                <h3 class="st-title text-xl mb-4">
                    Aksi Selanjutnya
                </h3>

                <div class="grid gap-3">

                    <a href="{{ route('order.my_orders') }}"
                       class="st-btn-primary w-full">
                        Lihat Pesanan
                    </a>

                    <a href="{{ route('front.catalog') }}"
                       class="st-btn-ghost w-full">
                        Lanjut Belanja
                    </a>

                </div>

                <div class="mt-5 rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-800">
                    <strong>Status otomatis</strong>
                    <p class="mt-1 text-xs">
                        Status akan berubah otomatis setelah pembayaran dikonfirmasi.
                    </p>
                </div>

            </div>

        </aside>

    </section>

</main>
@endsection
