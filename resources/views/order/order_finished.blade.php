@extends('layouts.front')

@section('title', 'Status Pesanan - SmartTech')

@section('content')
@php
    $status = $transaction->status ?? 'pending';

    $statusConfig = [
        'paid' => [
            'icon' => '✅',
            'title' => 'Pembayaran Berhasil',
            'text' => 'Pembayaran kamu sudah dikonfirmasi. Pesanan akan segera diproses.',
            'color' => 'text-emerald-600',
            'bg' => 'bg-emerald-50',
            'ring' => 'ring-emerald-100',
        ],
        'pending' => [
            'icon' => '⏳',
            'title' => 'Pesanan Sedang Diproses',
            'text' => 'Pembayaran kamu sedang diverifikasi oleh sistem. Kamu juga bisa mengganti metode pembayaran selama status masih pending.',
            'color' => 'text-blue-600',
            'bg' => 'bg-blue-50',
            'ring' => 'ring-blue-100',
        ],
        'failed' => [
            'icon' => '❌',
            'title' => 'Pembayaran Gagal',
            'text' => 'Pembayaran gagal, dibatalkan, atau sudah kedaluwarsa. Silakan coba checkout ulang.',
            'color' => 'text-red-600',
            'bg' => 'bg-red-50',
            'ring' => 'ring-red-100',
        ],
    ];

    $current = $statusConfig[$status] ?? $statusConfig['pending'];
@endphp

<main class="st-page-wrap">

    <section class="st-hero p-6 md:p-10 mb-6 text-center">

        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-3xl {{ $current['bg'] }} {{ $current['color'] }} ring-1 {{ $current['ring'] }}">
            {{ $current['icon'] }}
        </div>

        <span class="st-eyebrow st-eyebrow-blue">
            Order Status
        </span>

        <h1 class="st-hero-title mt-4 text-3xl md:text-5xl">
            {{ $current['title'] }}
        </h1>

        <p class="st-hero-text mx-auto mt-4 max-w-2xl text-sm md:text-base">
            {{ $current['text'] }}
        </p>

    </section>

    <section class="grid gap-6 lg:grid-cols-[1fr_360px]">

        <div class="space-y-6">

            <div class="st-card p-6 md:p-8">

                <h2 class="st-title text-2xl mb-5">
                    Informasi Pesanan
                </h2>

                <div class="space-y-4 text-sm">

                    <div class="flex items-start justify-between gap-4">
                        <span class="st-muted shrink-0">Invoice</span>

                        <span class="min-w-0 max-w-[210px] text-right">
                            <span class="block font-mono text-xs font-bold leading-relaxed text-slate-900 break-all">
                                #{{ $transaction->invoice_number }}
                            </span>
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="st-muted">Transaction ID</span>
                        <span class="font-bold text-slate-900 text-right break-all">
                            #{{ $transaction->booking_trx_id }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Status</span>
                        <span class="font-semibold {{ $current['color'] }}">
                            {{ strtoupper($status) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Metode Bayar</span>
                        <span class="font-semibold text-slate-900">
                            {{ $transaction->payment_method ? strtoupper($transaction->payment_method) : '-' }}
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

        <aside class="lg:sticky lg:top-28 h-fit">

            <div class="st-card p-6">

                <h3 class="st-title text-xl mb-4">
                    Aksi Selanjutnya
                </h3>

                <div class="grid gap-3">

                    @if($status === 'pending')
                        <a href="{{ route('order.payment.retry', $transaction->id) }}"
                           class="st-btn-accent w-full">
                            Ganti Metode Pembayaran
                        </a>
                    @endif

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
                        Status akan berubah otomatis setelah pembayaran dikonfirmasi Midtrans.
                    </p>
                </div>

                @if($status === 'pending')
                    <div class="mt-4 rounded-2xl border border-amber-100 bg-amber-50 p-4 text-sm text-amber-800">
                        <strong>Ingin ganti metode?</strong>
                        <p class="mt-1 text-xs">
                            Klik tombol ganti metode pembayaran, lalu pilih ulang metode di popup Midtrans.
                        </p>
                    </div>
                @endif

            </div>

        </aside>

    </section>

</main>
@endsection
