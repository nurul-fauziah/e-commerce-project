@extends('layouts.front')

@section('title', 'Data Pengiriman - SmartTech')

@section('content')
<main class="st-page-wrap">

    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">Shipping Details</span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4">
            Data Pengiriman
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Lengkapi alamat dan kontak penerima supaya pesanan bisa diproses dengan benar.
        </p>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1fr_360px]">

        <div class="st-card p-6 md:p-8">
            <h2 class="st-title text-2xl mb-2">Alamat Penerima</h2>
            <p class="st-muted text-sm mb-6">
                Nama dan email otomatis mengikuti akun login kamu.
            </p>

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-100 bg-red-50 p-4 text-sm text-red-700">
                    <strong class="block mb-2">Ada data yang perlu diperbaiki:</strong>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('order.save_customer_data') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-500">
                            Receiver Name
                        </label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" readonly
                               class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 font-semibold text-slate-600 outline-none cursor-not-allowed">
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-500">
                            Email Address
                        </label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" readonly
                               class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 font-semibold text-slate-600 outline-none cursor-not-allowed">
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-800">
                    <strong class="block">Info akun</strong>
                    Nama dan email dikunci dari akun login. Data di bawah dipakai untuk pengiriman.
                </div>

                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-slate-500">
                        Contact Number
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-4 font-semibold text-slate-900 placeholder:text-slate-400 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                           placeholder="Contoh: 08123456789">
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-500">
                            Delivery City
                        </label>
                        <input type="text" name="city" value="{{ old('city') }}" required
                               class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-4 font-semibold text-slate-900 placeholder:text-slate-400 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                               placeholder="Jakarta">
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-500">
                            Post Code
                        </label>
                        <input type="text" name="post_code" value="{{ old('post_code') }}" required
                               class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-4 font-semibold text-slate-900 placeholder:text-slate-400 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                               placeholder="12345">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-slate-500">
                        Full Address
                    </label>
                    <textarea name="address" rows="5" required
                              class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-4 font-semibold text-slate-900 placeholder:text-slate-400 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                              placeholder="Nama jalan, nomor rumah, RT/RW, patokan, kecamatan, dll.">{{ old('address') }}</textarea>
                    <p class="mt-2 text-xs text-slate-500">
                        Tambahkan patokan alamat supaya kurir lebih mudah menemukan lokasi.
                    </p>
                </div>

                <button type="submit" class="st-btn-accent w-full">
                    Proceed to Payment
                </button>
            </form>
        </div>

        <aside class="lg:sticky lg:top-28 h-fit">
            <div class="st-card p-6">
                <h3 class="st-title text-xl mb-2">Ringkasan Pesanan</h3>
                <p class="st-muted text-sm mb-5">
                    Cek lagi item sebelum lanjut ke pembayaran.
                </p>

                <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                    @foreach($orderData['cart_items'] as $item)
                        <div class="flex gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-3">
                            <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                <img src="{{ is_string($item['thumbnail']) && str_starts_with($item['thumbnail'], 'http') ? $item['thumbnail'] : Storage::url($item['thumbnail']) }}"
                                     class="h-full w-full object-cover"
                                     alt="{{ $item['name'] }}">
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-bold text-slate-950">
                                    {{ $item['name'] }}
                                </p>
                                <p class="mt-1 line-clamp-1 text-xs text-slate-500">
                                    {{ $item['variant_details'] }}
                                </p>
                                <div class="mt-2 flex items-center justify-between gap-2">
                                    <span class="rounded-full bg-white px-2 py-1 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                        x{{ $item['quantity'] }}
                                    </span>
                                    <span class="text-sm font-black text-slate-950">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="my-5 border-t border-dashed border-slate-200"></div>

                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                    <div class="flex justify-between text-sm text-blue-800">
                        <span>Total item</span>
                        <span class="font-bold">{{ count($orderData['cart_items']) }} item</span>
                    </div>

                    <div class="mt-3 flex items-end justify-between gap-4">
                        <span class="text-sm font-bold text-blue-800">Total Payment</span>
                        <span class="text-2xl font-black text-slate-950">
                            Rp {{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3 text-xs">
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-3 text-emerald-800">
                        <p class="font-bold">Secure Checkout</p>
                        <p class="mt-1 text-emerald-700/70">Data diproses aman.</p>
                    </div>

                    <div class="rounded-2xl border border-amber-100 bg-amber-50 p-3 text-amber-800">
                        <p class="font-bold">Fast Process</p>
                        <p class="mt-1 text-amber-700/70">Pesanan cepat masuk.</p>
                    </div>
                </div>
            </div>
        </aside>

    </section>

</main>
@endsection
