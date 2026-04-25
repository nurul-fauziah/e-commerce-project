@extends('layouts.front')

@section('title', 'SmartTech - Gadget Store')

@section('content')
<main class="relative overflow-hidden">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-32 right-[-10%] h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute top-[38rem] left-[-8%] h-80 w-80 rounded-full bg-orange-400/10 blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">

        <!-- HERO -->
        <section class="mb-14 md:mb-20">
            <div class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.10)]">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.14),transparent_34%),radial-gradient(circle_at_80%_0%,rgba(245,158,11,0.16),transparent_30%)]"></div>

                <div class="relative grid lg:grid-cols-[1.08fr_0.92fr] gap-8 items-center p-6 sm:p-8 md:p-12">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-[11px] font-extrabold uppercase tracking-[0.22em] text-blue-700 mb-6">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Gadget Store
                        </div>

                        <h1 class="text-4xl sm:text-5xl md:text-7xl font-black tracking-tight leading-[0.95] text-slate-950 uppercase">
                            Gadget Terbaik
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-orange-500">
                                Untuk Kerja, Belajar & Hiburan
                            </span>
                        </h1>

                        <p class="mt-6 max-w-2xl text-sm sm:text-base leading-7 text-slate-600">
                            Temukan smartphone, laptop, tablet, iPad, komputer, dan aksesori pilihan dengan produk original, harga jelas, checkout aman, dan dukungan setelah pembelian.
                        </p>

                        <form action="{{ route('front.catalog') }}" method="GET" class="mt-7 max-w-2xl">
                            <div class="flex flex-col sm:flex-row gap-3 rounded-3xl border border-slate-200 bg-white/80 p-2 shadow-sm backdrop-blur">
                                <input type="search"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Cari iPhone, Samsung, laptop, iPad, MacBook..."
                                       class="min-h-12 flex-1 rounded-2xl border-0 bg-transparent px-4 text-sm font-bold text-slate-900 placeholder:text-slate-400 focus:outline-none">

                                <button type="submit"
                                        class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-black text-white transition hover:bg-blue-700">
                                    Search
                                </button>
                            </div>
                        </form>

                        <div class="mt-8 flex flex-col sm:flex-row gap-3">
                            <a href="#catalog" class="inline-flex items-center justify-center rounded-2xl bg-orange-500 px-6 py-3 text-sm font-extrabold uppercase tracking-wide text-white shadow-lg shadow-orange-500/25 transition hover:-translate-y-0.5 hover:bg-orange-600">
                                Belanja Sekarang
                            </a>

                            <a href="{{ route('front.catalog') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white/70 px-6 py-3 text-sm font-extrabold uppercase tracking-wide text-slate-800 transition hover:-translate-y-0.5 hover:border-blue-300 hover:bg-blue-50">
                                Lihat Semua Produk
                            </a>
                        </div>

                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-2xl">
                            <div class="rounded-2xl border border-slate-200 bg-white/70 p-4">
                                <p class="text-lg font-black text-slate-950">100%</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Original Product</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white/70 p-4">
                                <p class="text-lg font-black text-slate-950">Secure</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Safe Checkout</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white/70 p-4">
                                <p class="text-lg font-black text-slate-950">Warranty</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">After-sales</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative hidden lg:block">
                        <div class="absolute -inset-4 rounded-[2rem] bg-gradient-to-br from-blue-600/10 to-orange-400/10 blur-2xl"></div>

                        <div class="relative rounded-[2rem] border border-slate-200 bg-slate-950 p-5 shadow-2xl overflow-hidden">
                            <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(37,99,235,0.28),transparent_35%),radial-gradient(circle_at_80%_20%,rgba(245,158,11,0.28),transparent_32%)]"></div>

                            <div class="relative aspect-square rounded-[1.5rem] border border-white/10 bg-slate-900 p-6 flex items-center justify-center">
                                <div class="relative h-64 w-64 rounded-[2rem] bg-gradient-to-br from-slate-700 to-slate-950 border border-white/10 shadow-2xl rotate-3">
                                    <div class="absolute inset-6 rounded-2xl border border-blue-400/30 bg-blue-500/10"></div>
                                    <div class="absolute left-8 top-8 h-12 w-32 rounded-xl bg-white/10"></div>
                                    <div class="absolute right-8 top-8 h-12 w-12 rounded-xl bg-orange-400/80"></div>
                                    <div class="absolute bottom-8 left-8 right-8 h-20 rounded-2xl bg-white/10 border border-white/10"></div>
                                    <div class="absolute -right-5 bottom-10 h-20 w-20 rounded-2xl bg-blue-500 shadow-xl shadow-blue-500/30"></div>
                                </div>
                            </div>

                            <div class="relative mt-4 grid grid-cols-2 gap-3">
                                <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Featured Device</p>
                                    <p class="text-white font-black">Premium Gadget</p>
                                </div>

                                <div class="rounded-2xl bg-emerald-400/10 p-4 backdrop-blur">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-300">Status</p>
                                    <p class="text-white font-black">Ready Stock</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TRUST STRIP -->
        <section class="mb-16 md:mb-24">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="st-card-soft p-5">
                    <div class="st-icon-blue mb-4">✓</div>
                    <h3 class="font-black text-slate-950">Produk Original</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Gadget pilihan dengan informasi produk yang jelas dan mudah dicek.</p>
                </div>

                <div class="st-card-soft p-5">
                    <div class="st-icon-green mb-4">🛡</div>
                    <h3 class="font-black text-slate-950">Garansi & Support</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Bantuan setelah pembelian untuk pengecekan produk dan klaim garansi.</p>
                </div>

                <div class="st-card-soft p-5">
                    <div class="st-icon-orange mb-4">💳</div>
                    <h3 class="font-black text-slate-950">Checkout Aman</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Alur pembelian dibuat simpel, jelas, dan nyaman untuk customer.</p>
                </div>

                <div class="st-card-soft p-5">
                    <div class="st-icon-blue mb-4">📦</div>
                    <h3 class="font-black text-slate-950">Stok Terlihat</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Customer bisa cek ketersediaan gadget sebelum lanjut checkout.</p>
                </div>
            </div>
        </section>

        <!-- CATEGORIES -->
        <section id="categories" class="mb-20 md:mb-28 scroll-mt-28">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8 md:mb-10">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-[0.35em] text-blue-600">
                        Gadget Categories
                    </span>

                    <h2 class="mt-3 text-3xl sm:text-4xl md:text-5xl font-black uppercase tracking-tight text-slate-950">
                        Kategori Gadget
                    </h2>
                </div>

                <p class="max-w-md text-sm leading-6 text-slate-500">
                    Pilih kategori seperti smartphone, laptop, tablet, komputer, atau aksesori supaya lebih cepat menemukan produk yang kamu butuhkan.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('front.category', $category->slug) }}" class="group block st-focus-ring">
                        <div class="relative h-full overflow-hidden rounded-3xl border border-slate-200 bg-white p-5 md:p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/10">
                            <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-blue-500/10 transition group-hover:bg-orange-400/15"></div>

                            <div class="relative mb-8 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-950 text-white shadow-lg shadow-slate-900/10 transition group-hover:scale-105 group-hover:bg-blue-600">
                                <span class="font-black text-2xl uppercase">{{ substr($category->name, 0, 1) }}</span>
                            </div>

                            <div class="relative">
                                <h3 class="st-line-clamp-2 text-base md:text-xl font-black uppercase leading-tight text-slate-950">
                                    {{ $category->name }}
                                </h3>

                                <p class="mt-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                    {{ $category->products_count ?? $category->products->count() }} Produk Tersedia
                                </p>

                                <div class="mt-5 inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wide text-blue-600">
                                    Explore
                                    <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- POPULAR PRODUCTS -->
        <section id="catalog" class="scroll-mt-28">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 md:mb-12 gap-6">
                <div class="max-w-3xl">
                    <span class="st-eyebrow st-eyebrow-blue">
                        Ready to Shop
                    </span>

                    <h2 class="st-title mt-4 text-4xl sm:text-5xl md:text-6xl">
                        Gadget Terlaris
                    </h2>

                    <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-500">
                        Pilihan gadget populer untuk kerja, belajar, gaming ringan, editing, hiburan, dan kebutuhan harian.
                    </p>
                </div>

                <a href="{{ route('front.catalog') }}"
                   class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-blue-700">
                    View Full Catalog
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @forelse ($popularProducts as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full st-card p-10 text-center">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                            📦
                        </div>

                        <p class="text-xl font-black uppercase tracking-tight text-slate-500">
                            Belum ada produk yang tersedia
                        </p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- CTA -->
        <section class="mt-20 md:mt-28">
            <div class="relative overflow-hidden rounded-[2rem] bg-slate-950 p-6 md:p-10 text-white">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.35),transparent_34%),radial-gradient(circle_at_90%_0%,rgba(245,158,11,0.28),transparent_30%)]"></div>

                <div class="relative grid gap-6 md:grid-cols-[1fr_auto] md:items-center">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-amber-300">
                            Need recommendation?
                        </p>

                        <h2 class="mt-3 text-2xl md:text-4xl font-black tracking-tight">
                            Bingung pilih gadget yang cocok?
                        </h2>

                        <p class="mt-3 max-w-2xl text-sm leading-7 text-white/60">
                            Hubungi support SmartTech untuk bantu pilih smartphone, laptop, tablet, atau komputer yang sesuai kebutuhan dan budget kamu.
                        </p>
                    </div>

                    <a href="{{ route('front.contact') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-amber-400 px-6 py-3 text-sm font-black text-slate-950 transition hover:-translate-y-0.5 hover:bg-amber-300">
                        Talk to Support
                    </a>
                </div>
            </div>
        </section>

    </div>
</main>
@endsection
