@extends('layouts.front')

@section('title', 'Pesanan Saya - SmartTech')

@section('content')
<main class="st-page-wrap">

    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">Order Center</span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4">
            Pesanan Saya
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Pantau status pembayaran, cek detail produk, dan lihat riwayat transaksi SmartTech kamu.
        </p>
    </section>

    <section class="grid gap-5">
        @forelse($orders as $order)
            @php
                $firstItem = $order->transactionDetails->first();
                $additionalItemsCount = $order->transactionDetails->count() - 1;
                $status = $order->status ?? 'pending';

                $statusClass = [
                    'paid' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
                    'pending' => 'bg-amber-50 text-amber-700 ring-amber-100',
                    'failed' => 'bg-red-50 text-red-700 ring-red-100',
                ][$status] ?? 'bg-slate-50 text-slate-700 ring-slate-100';
            @endphp

            <article class="st-card p-5 md:p-6 transition hover:-translate-y-0.5 hover:shadow-xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

                    <div class="flex min-w-0 flex-1 items-center gap-5">
                        <div class="h-24 w-24 shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 md:h-28 md:w-28">
                            @if($firstItem && $firstItem->product)
                                <img src="{{ Storage::url($firstItem->product->thumbnail) }}"
                                     class="h-full w-full object-cover"
                                     alt="{{ $firstItem->product->name }}">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <div class="mb-2 flex flex-wrap items-center gap-2">

                                <span class="rounded-full bg-slate-950 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-white">
                                    #{{ $order->invoice_number }}
                                </span>

                                <span class="rounded-full {{ $statusClass }} px-3 py-1 text-[11px] font-bold uppercase tracking-wide ring-1">
                                    {{ strtoupper($status) }}
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

                            <p class="mt-2 text-xs text-slate-400">
                                Transaction ID: #{{ $order->booking_trx_id }}
                            </p>
                        </div>
                    </div>

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

                            @if($status === 'pending')
                                <a href="{{ route('order.order_finished', $order->id) }}"
                                   class="st-btn-ghost w-full">
                                    Cek Status
                                </a>
                            @endif

                            @if($status === 'failed')
                                <a href="{{ route('front.catalog') }}"
                                   class="st-btn-ghost w-full">
                                    Belanja Lagi
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </article>
        @empty
            <div class="st-card p-8 md:p-14 text-center">
                <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-blue-400 ring-1 ring-blue-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                </div>

                <h2 class="st-title text-3xl">
                    Belum Ada Pesanan
                </h2>

                <p class="st-muted mx-auto mt-3 max-w-md text-sm leading-6">
                    Pesanan kamu nanti muncul di sini setelah checkout.
                </p>

                <a href="{{ route('front.catalog') }}" class="st-btn-accent mt-6">
                    Mulai Belanja
                </a>
            </div>
        @endforelse
    </section>

</main>
@endsection
