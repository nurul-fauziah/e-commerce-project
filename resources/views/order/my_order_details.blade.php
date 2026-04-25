@extends('layouts.front')

@section('title', 'Detail Pesanan - SmartTech')

@section('content')
<main class="st-page-wrap">

    @php
        $isPaid = $productTransaction->is_paid;
        $itemsCount = $productTransaction->transactionDetails->count();
    @endphp

    <a href="{{ route('order.my_orders') }}" class="st-btn-ghost mb-6">
        ← Kembali ke Pesanan
    </a>

    <!-- HERO -->
    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">
            Detail Pesanan
        </span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4 break-all">
            #{{ $productTransaction->booking_trx_id }}
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Dibuat pada {{ $productTransaction->created_at->format('d M Y, H:i') }} • {{ $itemsCount }} item dalam pesanan ini.
        </p>
    </section>

    <!-- STATUS BAR -->
    <section class="grid gap-3 md:grid-cols-3 mb-6">
        <div class="st-card-soft p-5">
            <div class="st-icon-blue mb-3">#</div>
            <h3 class="st-subtitle">Order ID Aman</h3>
            <p class="st-muted text-sm mt-1">
                Simpan nomor pesanan untuk konfirmasi.
            </p>
        </div>

        <div class="st-card-soft p-5">
            <div class="{{ $isPaid ? 'st-icon-green' : 'st-icon-orange' }} mb-3">
                {{ $isPaid ? '✓' : '!' }}
            </div>
            <h3 class="st-subtitle">Status Pembayaran</h3>
            <p class="st-muted text-sm mt-1">
                {{ $isPaid ? 'Sudah dibayar dan siap diproses.' : 'Masih menunggu pembayaran/verifikasi.' }}
            </p>
        </div>

        <div class="st-card-soft p-5">
            <div class="st-icon-orange mb-3">?</div>
            <h3 class="st-subtitle">Bantuan Customer</h3>
            <p class="st-muted text-sm mt-1">
                Hubungi admin kalau ada kendala pesanan.
            </p>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1fr_360px]">

        <!-- LEFT -->
        <div class="space-y-6">

            <!-- PRODUCTS -->
            <article class="st-card overflow-hidden">
                <div class="border-b border-slate-100 p-5 md:p-6">
                    <h2 class="st-title text-2xl">
                        Produk yang Dibeli
                    </h2>
                    <p class="st-muted text-sm mt-1">
                        Cek nama produk, varian, jumlah, dan subtotal.
                    </p>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($productTransaction->transactionDetails as $detail)
                        <div class="flex flex-col gap-4 p-5 transition hover:bg-slate-50 md:flex-row md:items-center md:p-6">
                            <div class="h-24 w-24 shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                                @if($detail->product && $detail->product->thumbnail)
                                    <img src="{{ Storage::url($detail->product->thumbnail) }}"
                                         class="h-full w-full object-cover"
                                         alt="{{ $detail->product->name }}">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-3xl text-slate-300">
                                        📦
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg font-black tracking-tight text-slate-950 md:text-xl">
                                    {{ $detail->product->name ?? 'Produk' }}
                                </h3>

                                <p class="st-muted text-sm mt-1">
                                    {{ $detail->variant_details ?: 'Varian standar' }}
                                </p>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                        Qty: {{ $detail->quantity }}
                                    </span>

                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 ring-1 ring-blue-100">
                                        Original Product
                                    </span>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4 text-left ring-1 ring-slate-100 md:min-w-[180px] md:text-right">
                                <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                                    Subtotal
                                </p>

                                <p class="mt-1 text-xl font-black text-slate-950">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>

            <!-- SHIPPING -->
            <article class="st-card p-5 md:p-6">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div>
                        <h2 class="st-title text-2xl">
                            Alamat Pengiriman
                        </h2>
                        <p class="st-muted text-sm mt-1">
                            Pastikan data penerima sudah sesuai.
                        </p>
                    </div>

                    <div class="st-icon-blue">
                        🚚
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-100">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            Penerima
                        </p>
                        <p class="mt-1 font-black text-slate-950">
                            {{ $productTransaction->name }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-100">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            Kontak
                        </p>
                        <p class="mt-1 font-black text-slate-950">
                            {{ $productTransaction->phone }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-100">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            Kota / Kode Pos
                        </p>
                        <p class="mt-1 font-black text-slate-950">
                            {{ $productTransaction->city }} • {{ $productTransaction->post_code }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-100 sm:col-span-2">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            Alamat Lengkap
                        </p>
                        <p class="mt-1 leading-6 text-slate-700">
                            {{ $productTransaction->address }}
                        </p>
                    </div>
                </div>
            </article>

        </div>

        <!-- RIGHT SUMMARY -->
        <aside class="lg:sticky lg:top-28 h-fit">
            <div class="st-card p-6">
                <span class="st-eyebrow">
                    Transaction Summary
                </span>

                <h3 class="st-title text-xl mt-4 mb-5">
                    Ringkasan Transaksi
                </h3>

                <div class="space-y-4 text-sm">
                    <div class="flex items-center justify-between gap-4">
                        <span class="st-muted font-semibold">Subtotal</span>
                        <span class="font-black text-slate-950">
                            Rp {{ number_format($productTransaction->sub_total_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <span class="st-muted font-semibold">Diskon</span>
                        <span class="font-black text-rose-600">
                            - Rp {{ number_format($productTransaction->discount_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="border-t border-dashed border-slate-200 pt-4">
                        <div class="flex items-end justify-between gap-4">
                            <span class="font-black text-slate-950">
                                Grand Total
                            </span>
                            <span class="text-2xl font-black text-slate-950">
                                Rp {{ number_format($productTransaction->grand_total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 rounded-2xl {{ $isPaid ? 'bg-emerald-50 text-emerald-800 ring-emerald-100' : 'bg-amber-50 text-amber-800 ring-amber-100' }} p-4 text-sm ring-1">
                    <strong class="block">
                        {{ $isPaid ? 'Pembayaran Berhasil' : 'Menunggu Pembayaran' }}
                    </strong>

                    <span>
                        {{ $isPaid ? 'Pesanan akan diproses sesuai antrean toko.' : 'Kalau sudah transfer, tunggu admin melakukan verifikasi.' }}
                    </span>
                </div>

                <div class="mt-5 grid gap-3">
                    @if(!$isPaid)
                        <a href="{{ route('front.contact') }}" class="st-btn-accent w-full">
                            Konfirmasi ke Admin
                        </a>
                    @endif

                    <a href="{{ route('front.catalog') }}" class="st-btn-ghost w-full">
                        Belanja Lagi
                    </a>
                </div>
            </div>
        </aside>

    </section>

</main>
@endsection
