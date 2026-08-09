@extends('layouts.front')

@section('title', 'Keranjang Belanja - SmartTech')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-10 md:py-16">

    <!-- Page Header -->
    <section class="mb-8 overflow-hidden rounded-[2rem] border border-slate-200 bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 text-white shadow-2xl">
        <div class="relative p-6 md:p-10">
            <div class="absolute right-0 top-0 h-40 w-40 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-1/3 h-32 w-32 rounded-full bg-amber-400/20 blur-3xl"></div>

            <div class="relative flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="mb-3 inline-flex rounded-full bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-blue-100 ring-1 ring-white/15">
                        Shopping Cart
                    </p>

                    <h1 class="text-4xl font-black tracking-tight md:text-6xl">
                        Review Gadget Pilihan Kamu
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300 md:text-base">
                        Cek smartphone, laptop, tablet, komputer, atau aksesori yang mau kamu beli sebelum lanjut checkout.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-3 text-center text-xs font-bold uppercase tracking-wide text-slate-300">
                    <div class="rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/10">
                        <span class="block text-lg text-white">01</span>
                        Cart
                    </div>
                    <div class="rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/10">
                        <span class="block text-lg text-white">02</span>
                        Checkout
                    </div>
                    <div class="rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/10">
                        <span class="block text-lg text-white">03</span>
                        Payment
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form action="{{ route('front.begin_checkout') }}" method="POST" id="cart-form">
        @csrf

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            <!-- CART LIST -->
            <section class="lg:col-span-2">

                <div class="mb-5 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                        <strong class="block">Gadget original</strong>
                        Produk pilihan SmartTech
                    </div>

                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <strong class="block">Checkout aman</strong>
                        Data pesanan terlindungi
                    </div>

                    <div class="rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                        <strong class="block">Garansi support</strong>
                        Bantuan setelah pembelian
                    </div>
                </div>

                @if(count($cart) > 0)
                    <div class="mb-5 flex items-center justify-between rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <label class="flex cursor-pointer items-center gap-4">
                            <input type="checkbox" id="select-all" class="h-5 w-5 cursor-pointer rounded accent-blue-600">
                            <span class="font-bold text-slate-900">Pilih semua produk</span>
                        </label>

                        <a href="{{ route('front.catalog') }}" class="hidden text-sm font-bold text-blue-600 hover:text-blue-700 sm:inline">
                            Lanjut belanja
                        </a>
                    </div>
                @endif

                <div class="flex flex-col gap-4">
                    @forelse($cart as $cartKey => $item)
                        <article class="group rounded-3xl border border-slate-200 bg-white p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl sm:p-5">
                            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                                <input type="checkbox"
                                       name="cart_keys[]"
                                       value="{{ $cartKey }}"
                                       class="item-checkbox h-5 w-5 cursor-pointer rounded accent-blue-600"
                                       data-price="{{ $item['subtotal'] }}">

                                <div class="h-28 w-28 shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                                    <img src="{{ Storage::url($item['thumbnail']) }}"
                                         class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                         alt="{{ $item['name'] }}">
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="mb-2 flex flex-wrap items-center gap-2">
                                        <span class="rounded-full bg-blue-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-blue-700">
                                            Gadget
                                        </span>

                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-emerald-700">
                                            Ready Stock
                                        </span>

                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-slate-600">
                                            Qty {{ $item['quantity'] }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-black leading-tight text-slate-950 md:text-xl">
                                        {{ $item['name'] }}
                                    </h3>

                                    @if(!empty($item['variant_details']))
                                        <p class="mt-1 text-sm text-slate-500">
                                            Varian: {{ $item['variant_details'] }}
                                        </p>
                                    @endif

                                    <p class="mt-3 text-sm font-semibold text-slate-700">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        <span class="font-normal text-slate-400">/ item</span>
                                    </p>
                                </div>

                                <div class="flex w-full items-end justify-between border-t border-dashed border-slate-200 pt-4 sm:w-auto sm:flex-col sm:items-end sm:border-t-0 sm:pt-0">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                                            Subtotal
                                        </p>

                                        <p class="mt-1 text-xl font-black text-slate-950">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <a href="{{ route('front.cart.remove', $cartKey) }}"
                                       class="rounded-full px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50">
                                        Hapus
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-[2rem] border border-slate-200 bg-white p-12 text-center shadow-sm">
                            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                            </div>

                            <p class="text-2xl font-black text-slate-900">
                                Keranjang masih kosong
                            </p>

                            <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                                Yuk cari smartphone, laptop, tablet, komputer, atau aksesori favorit kamu dulu.
                            </p>

                            <a href="{{ route('front.catalog') }}"
                               class="mt-6 inline-flex rounded-full bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                                Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- SUMMARY -->
            <aside class="lg:sticky lg:top-28 h-max">
                <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-200/70">
                    <div class="bg-gradient-to-br from-blue-600 to-slate-900 p-6 text-white">
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-blue-100">
                            Order Summary
                        </p>

                        <h2 class="mt-2 text-2xl font-black">
                            Ringkasan checkout
                        </h2>
                    </div>

                    <div class="p-6">
                        <div class="mb-5 rounded-2xl bg-slate-50 p-4">
                            <div class="mb-3 flex justify-between text-sm">
                                <span class="font-semibold text-slate-500">Produk dipilih</span>
                                <span id="summary-count" class="font-black text-slate-950">0</span>
                            </div>

                            <div class="flex items-end justify-between border-t border-dashed border-slate-200 pt-4">
                                <span class="text-sm font-semibold text-slate-500">Estimasi total</span>
                                <span id="summary-total" class="text-2xl font-black tracking-tight text-slate-950">Rp 0</span>
                            </div>
                        </div>

                        <div class="mb-5 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-800">
                            <strong class="block">Belanja aman</strong>
                            Pastikan gadget dan varian yang dipilih sudah sesuai sebelum lanjut checkout.
                        </div>

                        <button type="submit"
                                id="btn-checkout"
                                class="w-full rounded-2xl bg-amber-500 px-5 py-4 text-base font-black text-white shadow-lg shadow-amber-500/25 transition hover:-translate-y-0.5 hover:bg-amber-600 disabled:cursor-not-allowed disabled:bg-slate-300 disabled:shadow-none"
                                disabled>
                            Lanjut ke Checkout
                        </button>

                        <p class="mt-4 text-center text-xs leading-5 text-slate-400">
                            Setelah ini kamu akan mengisi data pelanggan dan melanjutkan pembayaran.
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </form>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const summaryCount = document.getElementById('summary-count');
        const summaryTotal = document.getElementById('summary-total');
        const btnCheckout = document.getElementById('btn-checkout');

        function calculateTotal() {
            let total = 0;
            let count = 0;

            checkboxes.forEach(box => {
                if (box.checked) {
                    total += parseInt(box.dataset.price || 0);
                    count++;
                }
            });

            summaryCount.innerText = count;
            summaryTotal.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(total);

            btnCheckout.disabled = count === 0;

            if (selectAll && checkboxes.length > 0) {
                selectAll.checked = count === checkboxes.length;
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(box => {
                    box.checked = this.checked;
                });

                calculateTotal();
            });
        }

        checkboxes.forEach(box => {
            box.addEventListener('change', calculateTotal);
        });

        calculateTotal();
    });
</script>
@endsection
