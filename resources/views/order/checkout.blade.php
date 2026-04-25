@extends('layouts.front')

@section('title', 'Checkout - SmartTech')

@section('content')
<main class="st-page-wrap">

    <!-- HERO -->
    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">
            Checkout
        </span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4">
            Lengkapi Pesanan Gadget
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Isi data dengan benar untuk proses pengiriman dan pembayaran yang lancar.
        </p>
    </section>

    <div class="grid lg:grid-cols-3 gap-6">

        <!-- FORM -->
        <div class="lg:col-span-2">
            <div class="st-card p-6 md:p-8">

                <h2 class="st-title text-2xl mb-6">
                    Data Pembeli
                </h2>

                <form method="POST" action="{{ route('front.store_checkout', $product->slug ?? 0) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm font-semibold text-slate-600">Nama Lengkap</label>
                            <input type="text" name="name" required
                                   placeholder="Contoh: Zia Ramadhan"
                                   class="w-full mt-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-600">Email</label>
                            <input type="email" name="email" required
                                   placeholder="email@gmail.com"
                                   class="w-full mt-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-600">No HP / WhatsApp</label>
                            <input type="text" name="phone" required
                                   placeholder="08xxxxxxxxxx"
                                   class="w-full mt-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-600">Kota</label>
                            <input type="text" name="city" required
                                   placeholder="Jakarta"
                                   class="w-full mt-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-600">Kode Pos</label>
                            <input type="text" name="post_code" required
                                   placeholder="12345"
                                   class="w-full mt-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-slate-600">Alamat Lengkap</label>
                            <textarea name="address" rows="3" required
                                      placeholder="Jl. Contoh No.123, RT/RW, Kecamatan..."
                                      class="w-full mt-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none"></textarea>
                        </div>

                        <!-- OPTIONAL NOTE -->
                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-slate-600">Catatan (opsional)</label>
                            <textarea rows="2"
                                      placeholder="Contoh: kirim sore hari"
                                      class="w-full mt-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none"></textarea>
                        </div>

                        <!-- UPLOAD BUKTI -->
                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-slate-600">
                                Upload Bukti Pembayaran
                            </label>
                            <input type="file" name="proof" required
                                   class="w-full mt-2 text-sm">
                        </div>
                    </div>

                    <!-- TRUST -->
                    <div class="mt-6 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-800">
                        <strong class="block">Checkout aman</strong>
                        Data kamu aman dan hanya digunakan untuk proses pesanan.
                    </div>

                    <button class="st-btn-accent w-full mt-6">
                        Bayar Sekarang
                    </button>

                </form>

            </div>
        </div>

        <!-- SUMMARY -->
        <div class="lg:sticky lg:top-28 h-fit">
            <div class="st-card p-6">

                <h3 class="st-title text-xl mb-4">
                    Ringkasan Pesanan
                </h3>

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between">
                        <span class="st-muted">Produk</span>
                        <span class="font-semibold text-slate-900">
                            {{ $product->name ?? 'Produk' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Harga</span>
                        <span class="font-semibold text-slate-900">
                            Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="st-muted">Qty</span>
                        <span class="font-semibold text-slate-900">1</span>
                    </div>

                </div>

                <div class="border-t my-4"></div>

                <div class="flex justify-between items-center">
                    <span class="st-muted">Total</span>
                    <span class="text-xl font-black text-slate-950">
                        Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                <div class="mt-4 text-xs text-slate-500">
                    *Harga belum termasuk ongkir
                </div>

            </div>
        </div>

    </div>

</main>
@endsection
