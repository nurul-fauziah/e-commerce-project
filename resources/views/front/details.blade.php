@extends('layouts.front')

@section('title', $product->name . ' - SmartTech')

@section('content')
<main class="st-page-wrap">

    <form action="{{ route('front.cart.add', $product->id) }}" method="POST">
        @csrf

        <input type="hidden" name="variant_id" id="selected_variant_id" required>
        <input type="hidden" name="variant_details" id="selected_variant_details" value="">

        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-wrap items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-400">
            <a href="{{ route('front.index') }}" class="hover:text-blue-600 transition st-focus-ring">Home</a>
            <span>/</span>
            <a href="{{ route('front.category', $product->category->slug ?? $product->category->id) }}" class="hover:text-blue-600 transition st-focus-ring">
                {{ $product->category->name }}
            </a>
            <span>/</span>
            <span class="text-slate-700">{{ Str::limit($product->name, 28) }}</span>
        </div>

        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10 items-start">

            <!-- LEFT: PRODUCT IMAGE -->
            <div class="lg:sticky lg:top-28 space-y-4">

                <div class="st-card overflow-hidden">
                    <div class="p-4 md:p-5">
                        <div class="mb-4 flex items-center justify-between gap-3">
                            <span class="st-eyebrow st-eyebrow-blue">
                                Original Gadget
                            </span>

                            <span class="inline-flex rounded-full {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-700 ring-emerald-100' : 'bg-rose-50 text-rose-700 ring-rose-100' }} px-3 py-1 text-xs font-bold ring-1">
                                {{ $product->stock > 0 ? 'Ready Stock' : 'Sold Out' }}
                            </span>
                        </div>

                        <div class="group aspect-square overflow-hidden rounded-3xl border border-slate-200 bg-slate-100">
                            <img src="{{ is_string($product->thumbnail) && str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : Storage::url($product->thumbnail) }}"
                                 class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                 alt="{{ $product->name }}">
                        </div>
                    </div>
                </div>

                @if($product->photos->count() > 0)
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($product->photos as $photo)
                            <button type="button"
                                    class="group aspect-square overflow-hidden rounded-2xl border border-slate-200 bg-white p-1 transition hover:border-blue-300 hover:shadow-md st-focus-ring">
                                <img src="{{ Storage::url($photo->photo) }}"
                                     class="h-full w-full rounded-xl object-cover opacity-80 transition group-hover:scale-105 group-hover:opacity-100"
                                     alt="{{ $product->name }} gallery">
                            </button>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-3 gap-3 text-xs">
                    <div class="st-card-soft p-4">
                        <p class="font-bold text-slate-950">Original</p>
                        <p class="mt-1 st-muted">Produk pilihan</p>
                    </div>

                    <div class="st-card-soft p-4">
                        <p class="font-bold text-slate-950">Garansi</p>
                        <p class="mt-1 st-muted">After-sales</p>
                    </div>

                    <div class="st-card-soft p-4">
                        <p class="font-bold text-slate-950">Aman</p>
                        <p class="mt-1 st-muted">Checkout jelas</p>
                    </div>
                </div>

            </div>

            <!-- RIGHT: PRODUCT INFO -->
            <div class="space-y-6">

                <!-- Product Title -->
                <section class="st-hero p-6 md:p-8">
                    <div class="mb-4 flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black uppercase tracking-widest text-blue-700 ring-1 ring-blue-100">
                            {{ $product->category->name }}
                        </span>

                        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-black uppercase tracking-widest text-amber-700 ring-1 ring-amber-100">
                            Best Choice
                        </span>
                    </div>

                    <h1 class="st-hero-title text-3xl md:text-5xl">
                        {{ $product->name }}
                    </h1>

                    <div class="mt-4 flex flex-wrap items-center gap-3 text-xs font-bold text-slate-500">
                        <span class="inline-flex items-center gap-1 rounded-full bg-white/80 px-3 py-1 ring-1 ring-slate-200">
                            <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                            4.8 Rating
                        </span>

                        <span class="inline-flex items-center gap-1 rounded-full bg-white/80 px-3 py-1 ring-1 ring-slate-200">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                            Ready to Order
                        </span>

                        <span class="inline-flex items-center gap-1 rounded-full bg-white/80 px-3 py-1 ring-1 ring-slate-200">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            Support Garansi
                        </span>
                    </div>

                    <p class="st-hero-text mt-4 text-sm">
                        Pilih varian gadget yang sesuai, cek stok, lalu lanjutkan ke keranjang atau langsung beli sekarang.
                    </p>

                    <div class="mt-6 rounded-3xl border border-orange-100 bg-orange-50 p-5">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-orange-700">
                            Harga Produk
                        </p>

                        <p id="dynamic-price" class="mt-2 text-3xl md:text-5xl font-black tracking-tight text-slate-950">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <p class="mt-2 text-xs text-slate-500">
                            Harga dapat berubah sesuai varian, kapasitas, warna, atau konfigurasi yang dipilih.
                        </p>
                    </div>

                    @if(($product->stock ?? 0) > 0 && ($product->stock ?? 0) <= 5)
                        <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3">
                            <p class="text-sm font-bold text-amber-800">
                                Stok terbatas — tersisa {{ $product->stock }} unit.
                            </p>
                        </div>
                    @endif
                </section>

                <!-- Variation -->
                <section id="variation-selector"
                         data-variants="{{ json_encode($product->variants) }}"
                         class="st-card p-6 md:p-8">

                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <h2 class="st-title text-xl">
                                Pilih Varian
                            </h2>
                            <p class="st-muted mt-1 text-sm">
                                Pilih opsi seperti warna, kapasitas, RAM, storage, atau konfigurasi lain sebelum checkout.
                            </p>
                        </div>

                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 ring-1 ring-blue-100">
                            Variant
                        </span>
                    </div>

                    @if(isset($availableAttributes) && count($availableAttributes) > 0)
                        <div class="space-y-5">
                            @foreach($availableAttributes as $attributeName => $options)
                                <div>
                                    <p class="mb-3 text-sm font-bold text-slate-700">
                                        {{ $attributeName }}
                                    </p>

                                    <div class="flex flex-wrap gap-2">
                                        @foreach($options as $opt)
                                            <button type="button"
                                                    class="spec-btn rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 st-focus-ring"
                                                    data-key="{{ $attributeName }}"
                                                    data-value="{{ $opt }}">
                                                {{ $opt }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-4">
                            <p class="text-sm font-semibold text-slate-600">
                                Produk ini tersedia dalam konfigurasi standar.
                            </p>
                        </div>
                    @endif
                </section>

                <!-- Quantity + CTA -->
                <section class="st-card p-6 md:p-8">
                    <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="st-title text-lg">
                                Jumlah Pembelian
                            </h2>

                            <p class="st-muted mt-1 text-sm">
                                Stok tersedia: {{ $product->stock }}
                            </p>
                        </div>

                        <div class="flex w-max items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 p-1">
                            <button type="button" id="btn-minus"
                                    class="h-11 w-11 rounded-xl bg-white text-lg font-black text-slate-900 ring-1 ring-slate-200 transition hover:bg-blue-600 hover:text-white st-focus-ring">
                                -
                            </button>

                            <input type="number"
                                   name="quantity"
                                   id="input-quantity"
                                   value="1"
                                   min="1"
                                   max="{{ $product->stock }}"
                                   class="w-16 bg-transparent text-center text-xl font-black text-slate-950 focus:outline-none"
                                   readonly>

                            <button type="button" id="btn-plus"
                                    class="h-11 w-11 rounded-xl bg-white text-lg font-black text-slate-900 ring-1 ring-slate-200 transition hover:bg-blue-600 hover:text-white st-focus-ring">
                                +
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <button type="submit"
                                name="action"
                                value="cart"
                                id="btn-add-cart"
                                class="st-btn-primary w-full disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            + Tambah ke Keranjang
                        </button>

                        <button type="submit"
                                name="action"
                                value="buy_now"
                                id="btn-buy-now"
                                class="st-btn-accent w-full disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            Beli Sekarang
                        </button>
                    </div>

                    <p class="mt-4 text-center text-xs font-semibold text-slate-400">
                        Checkout aman · Produk original · Support setelah pembelian
                    </p>
                </section>

                <!-- Trust -->
                <section class="st-card p-6 md:p-8">
                    <h2 class="st-title text-xl">
                        Kenapa beli gadget di SmartTech?
                    </h2>

                    <div class="mt-5 grid gap-3 sm:grid-cols-3">
                        <div class="st-card-soft p-4">
                            <div class="st-icon-blue mb-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg></div>
                            <p class="text-sm font-bold text-slate-950">Produk Original</p>
                            <p class="st-muted mt-1 text-xs">Informasi produk jelas.</p>
                        </div>

                        <div class="st-card-soft p-4">
                            <div class="st-icon-green mb-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg></div>
                            <p class="text-sm font-bold text-slate-950">Garansi & Support</p>
                            <p class="st-muted mt-1 text-xs">Bantuan setelah beli.</p>
                        </div>

                        <div class="st-card-soft p-4">
                            <div class="st-icon-orange mb-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg></div>
                            <p class="text-sm font-bold text-slate-950">Checkout Aman</p>
                            <p class="st-muted mt-1 text-xs">Alur pembayaran jelas.</p>
                        </div>
                    </div>
                </section>

                <!-- Description -->
                <section class="st-card p-6 md:p-8">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <h2 class="st-title text-xl">
                            Deskripsi Produk
                        </h2>

                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 ring-1 ring-blue-100">
                            Overview
                        </span>
                    </div>

                    <p class="text-sm leading-7 text-slate-600">
                        {{ $product->description ?? 'Gadget pilihan SmartTech untuk kebutuhan harian, kerja, belajar, hiburan, dan produktivitas. Produk memiliki informasi yang jelas agar customer lebih mudah memilih sebelum checkout.' }}
                    </p>
                </section>

                @if(!empty($product->specifications))
                    <section class="st-card p-6 md:p-8">
                        <div class="mb-6 flex items-center justify-between gap-4 border-b border-slate-100 pb-4">
                            <h2 class="st-title text-xl">
                                Spesifikasi Gadget
                            </h2>

                            <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700 ring-1 ring-orange-100">
                                Specs
                            </span>
                        </div>

                        <div class="divide-y divide-slate-100 text-sm">
                            @foreach($product->specifications as $key => $value)
                                <div class="grid gap-1 py-3 md:grid-cols-2">
                                    <span class="font-semibold text-slate-500">
                                        {{ str_replace('_', ' ', $key) }}
                                    </span>

                                    <span class="font-bold text-slate-950 md:text-right">
                                        {{ $value }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

            </div>
        </section>
    </form>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const variationSelector = document.getElementById('variation-selector');

        if (!variationSelector) return;

        const variants = JSON.parse(variationSelector.dataset.variants || '[]');
        const btnSubmit = document.getElementById('btn-add-cart');
        const btnBuyNow = document.getElementById('btn-buy-now');
        const priceDisplay = document.getElementById('dynamic-price');
        const inputVariantId = document.getElementById('selected_variant_id');
        const inputVariantDetails = document.getElementById('selected_variant_details');

        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');
        const inputQty = document.getElementById('input-quantity');

        btnMinus?.addEventListener('click', () => {
            let qty = parseInt(inputQty.value);
            if (qty > 1) inputQty.value = qty - 1;
        });

        btnPlus?.addEventListener('click', () => {
            let qty = parseInt(inputQty.value);
            let max = parseInt(inputQty.getAttribute('max')) || 99;
            if (qty < max) inputQty.value = qty + 1;
        });

        const basePrice = {{ $product->price }};

        if (variants.length === 0) {
            [btnSubmit, btnBuyNow].forEach(btn => {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
            return;
        }

        let selectedSpecs = {};
        const totalKeys = {{ isset($availableAttributes) ? count($availableAttributes) : 0 }};

        document.querySelectorAll('.spec-btn').forEach(button => {
            button.addEventListener('click', function() {
                let key = this.dataset.key;

                document.querySelectorAll(`.spec-btn[data-key="${key}"]`).forEach(btn => {
                    btn.classList.remove('border-blue-500', 'bg-blue-600', 'text-white', 'shadow-lg');
                    btn.classList.add('border-slate-200', 'bg-white', 'text-slate-700');
                });

                this.classList.remove('border-slate-200', 'bg-white', 'text-slate-700');
                this.classList.add('border-blue-500', 'bg-blue-600', 'text-white', 'shadow-lg');

                selectedSpecs[key] = this.dataset.value;

                if (Object.keys(selectedSpecs).length === totalKeys) {
                    findMatchingVariant();
                }
            });
        });

        function findMatchingVariant() {
            const matchedVariant = variants.find(variant => {
                let isMatch = true;

                if (variant.attributes) {
                    for (const [key, value] of Object.entries(selectedSpecs)) {
                        if (variant.attributes[key] !== value) {
                            isMatch = false;
                            break;
                        }
                    }
                } else {
                    isMatch = false;
                }

                return isMatch;
            });

            if (matchedVariant) {
                inputVariantId.value = matchedVariant.id;
                inputVariantDetails.value = Object.entries(selectedSpecs).map(([k, v]) => `${k}: ${v}`).join(', ');
                inputQty.setAttribute('max', matchedVariant.stock);

                let finalPrice = matchedVariant.price > 0 ? matchedVariant.price : basePrice;
                priceDisplay.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(finalPrice);

                [btnSubmit, btnBuyNow].forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            } else {
                inputVariantId.value = '';
                inputVariantDetails.value = '';
                priceDisplay.innerText = "Varian tidak tersedia";

                [btnSubmit, btnBuyNow].forEach(btn => {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                });
            }
        }
    });
</script>
@endsection
