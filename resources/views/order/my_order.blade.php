@extends('layouts.front')

@section('title', 'Pesanan Saya - SmartTech')

@section('content')
<main class="st-page-wrap">

    <!-- HERO -->
    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">
            Order Center
        </span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4">
            Pesanan Saya
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Pantau status pembayaran, cek detail produk, dan lihat riwayat transaksi SmartTech kamu.
        </p>
    </section>

    <!-- INFO BAR -->
    <section class="grid gap-3 md:grid-cols-3 mb-6">
        <div class="st-card-soft p-5">
            <div class="st-icon-blue mb-3">✓</div>
            <h3 class="st-subtitle">Status Jelas</h3>
            <p class="st-muted text-sm mt-1">
                Cek pembayaran dan verifikasi pesanan.
            </p>
        </div>

        <div class="st-card-soft p-5">
            <div class="st-icon-green mb-3">✓</div>
            <h3 class="st-subtitle">Produk Original</h3>
            <p class="st-muted text-sm mt-1">
                Pesanan diproses sesuai stok toko.
            </p>
        </div>

        <div class="st-card-soft p-5">
            <div class="st-icon-orange mb-3">?</div>
            <h3 class="st-subtitle">Butuh Bantuan?</h3>
            <p class="st-muted text-sm mt-1">
                Simpan nomor order untuk konfirmasi.
            </p>
        </div>
    </section>

    <!-- ORDER LIST -->
    <section class="grid gap-5">
        @forelse($orders as $order)
            @php
                $firstItem = $order->transactionDetails->first();
                $additionalItemsCount = $order->transactionDetails->count() - 1;
                $isPaid = $order->is_paid;
            @endphp

            <article class="st-card p-5 md:p-6 transition hover:-translate-y-0.5 hover:shadow-xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

                    <!-- Product Summary -->
                    <div class="flex min-w-0 flex-1 items-center gap-5">
                        <div class="h-24 w-24 shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 md:h-28 md:w-28">
                            @if($firstItem && $firstItem->product)
                                <img src="{{ Storage::url($firstItem->product->thumbnail) }}"
                                     class="h-full w-full object-cover"
                                     alt="{{ $firstItem->product->name }}">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-3xl text-slate-300">
                                    📦
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-slate-950 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-white">
                                    #{{ $order->booking_trx_id }}
                                </span>

                                <span class="rounded-full {{ $isPaid ? 'bg-emerald-50 text-emerald-700 ring-emerald-100' : 'bg-amber-50 text-amber-700 ring-amber-100' }} px-3 py-1 text-[11px] font-bold uppercase tracking-wide ring-1">
                                    {{ $isPaid ? 'Paid / Verified' : 'Pending Payment' }}
                                </span>
                            </div>

                            <h2 class="truncate text-xl font-black tracking-tight text-slate-950 md:text-2xl">
                                {{ $firstItem && $firstItem->product ? $firstItem->product->name : 'SmartTech Product' }}
                            </h2>

                            <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-slate-500">
                                <span>
                                    Ordered at {{ $order->created_at->format('d M Y') }}
                                </span>

                                @if($additionalItemsCount > 0)
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 ring-1 ring-blue-100">
                                        + {{ $additionalItemsCount }} item lainnya
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Price & Action -->
                    <div class="flex flex-col gap-4 border-t border-dashed border-slate-200 pt-5 md:min-w-[260px] md:items-end md:border-t-0 md:pt-0">

                        <div class="w-full rounded-2xl bg-slate-50 p-4 text-left ring-1 ring-slate-100 md:text-right">
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                                Grand Total
                            </p>
                            <p class="mt-1 text-2xl font-black text-slate-950">
                                Rp {{ number_format($order->grand_total_amount, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex w-full flex-col gap-2 sm:flex-row md:flex-col">
                            <a href="{{ route('order.my_order_details', $order->id) }}"
                               class="st-btn-primary w-full">
                                Lihat Detail
                            </a>

                            @if(!$isPaid)
                                <a href="{{ route('front.contact') }}"
                                   class="st-btn-ghost w-full">
                                    Butuh Bantuan?
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </article>
        @empty
            <div class="st-card p-8 md:p-14 text-center">
                <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-4xl ring-1 ring-blue-100">
                    🛒
                </div>

                <h2 class="st-title text-3xl">
                    Belum Ada Pesanan
                </h2>

                <p class="st-muted mx-auto mt-3 max-w-md text-sm leading-6">
                    Pesanan kamu nanti muncul di sini setelah checkout. Yuk lihat produk SmartTech yang ready stock.
                </p>

                <a href="{{ route('front.catalog') }}" class="st-btn-accent mt-6">
                    Mulai Belanja
                </a>
            </div>
        @endforelse
    </section>

</main>
@endsection
