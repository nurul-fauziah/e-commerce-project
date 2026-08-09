@extends('layouts.front')

@section('title', 'Gadget Catalog - SmartTech')

@section('content')
<main class="relative overflow-hidden">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-28 right-[-10%] h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute top-[34rem] left-[-10%] h-80 w-80 rounded-full bg-orange-400/10 blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">

        <!-- Catalog Header -->
        <section class="mb-10 md:mb-14">
            <div class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_10%,rgba(37,99,235,0.13),transparent_34%),radial-gradient(circle_at_85%_0%,rgba(245,158,11,0.15),transparent_32%)]"></div>

                <div class="relative grid lg:grid-cols-[1.2fr_0.8fr] gap-8 items-center p-6 sm:p-8 md:p-10">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-[10px] font-black uppercase tracking-[0.24em] text-blue-700 mb-5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Gadget Collection
                        </div>

                        <h1 class="text-4xl sm:text-5xl md:text-7xl font-black tracking-tight leading-[0.95] text-slate-950 uppercase">
                            Full Gadget
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-orange-500">
                                Catalog
                            </span>
                        </h1>

                        <p class="mt-5 max-w-2xl text-sm sm:text-base leading-7 text-slate-600">
                            Jelajahi smartphone, laptop, tablet, iPad, komputer, dan aksesori pilihan dengan harga jelas, stok terlihat, dan checkout yang mudah.
                        </p>

                        <form action="{{ route('front.catalog') }}" method="GET" class="mt-7 max-w-2xl">
                            <div class="flex flex-col sm:flex-row gap-3 rounded-3xl border border-slate-200 bg-white/80 p-2 shadow-sm backdrop-blur">
                                <input type="search"
                                       name="search"
                                       value="{{ $search ?? request('search') }}"
                                       placeholder="Cari iPhone, Samsung, laptop, iPad, MacBook..."
                                       class="min-h-12 flex-1 rounded-2xl border-0 bg-transparent px-4 text-sm font-bold text-slate-900 placeholder:text-slate-400 focus:outline-none">

                                <button type="submit"
                                        class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-black text-white transition hover:bg-blue-700">
                                    Search
                                </button>
                            </div>
                        </form>

                        <div class="mt-7 grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-2xl">
                            <div class="rounded-2xl border border-slate-200 bg-white/75 p-4">
                                <p class="text-lg font-black text-slate-950">Original</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Produk pilihan</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white/75 p-4">
                                <p class="text-lg font-black text-slate-950">Secure</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Checkout aman</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white/75 p-4">
                                <p class="text-lg font-black text-slate-950">Warranty</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">After-sales support</p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block">
                        <div class="relative rounded-[2rem] bg-slate-950 p-5 shadow-2xl overflow-hidden">
                            <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(37,99,235,0.3),transparent_38%),radial-gradient(circle_at_85%_18%,rgba(245,158,11,0.28),transparent_34%)]"></div>

                            <div class="relative aspect-[4/3] rounded-[1.5rem] border border-white/10 bg-slate-900 p-6 flex items-center justify-center">
                                <div class="relative h-44 w-56 rounded-[1.75rem] bg-gradient-to-br from-slate-700 to-slate-950 border border-white/10 shadow-2xl rotate-2">
                                    <div class="absolute inset-5 rounded-2xl border border-blue-400/30 bg-blue-500/10"></div>
                                    <div class="absolute left-7 top-7 h-10 w-24 rounded-xl bg-white/10"></div>
                                    <div class="absolute right-7 top-7 h-10 w-10 rounded-xl bg-orange-400/85"></div>
                                    <div class="absolute bottom-7 left-7 right-7 h-14 rounded-2xl bg-white/10 border border-white/10"></div>
                                    <div class="absolute -right-5 bottom-7 h-16 w-16 rounded-2xl bg-blue-500 shadow-xl shadow-blue-500/30"></div>
                                </div>
                            </div>

                            <div class="relative mt-4 flex items-center justify-between rounded-2xl bg-white/10 p-4 backdrop-blur">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Catalog Status</p>
                                    <p class="text-white font-black">Ready to Shop</p>
                                </div>

                                <span class="rounded-full bg-emerald-400/20 px-3 py-1 text-xs font-bold text-emerald-300">
                                    Live
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Catalog Filter -->
        <section class="mb-8 md:mb-10">
            <form action="{{ route('front.catalog') }}" method="GET"
                class="rounded-3xl border border-slate-200 bg-white p-4 md:p-5 shadow-sm">

                <div class="flex flex-col lg:flex-row lg:items-end gap-4">

                    <div class="flex-1">
                        <p class="text-[10px] font-black uppercase tracking-[0.28em] text-blue-600">
                            Product Filter
                        </p>

                        <h2 class="mt-1 text-2xl md:text-3xl font-black uppercase tracking-tight text-slate-950">
                            Semua Gadget
                        </h2>

                        @if(!empty($search))
                            <p class="mt-2 text-sm font-semibold text-slate-500">
                                Showing results for
                                <span class="font-black text-slate-950">“{{ $search }}”</span>
                            </p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 flex-[2]">

                        <input type="search"
                            name="search"
                            value="{{ $search ?? request('search') }}"
                            placeholder="Cari gadget..."
                            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 placeholder:text-slate-400 focus:border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-100">

                        <select name="category"
                                class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 focus:border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" @selected(($category ?? request('category')) == $cat->slug)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="number"
                            name="min_price"
                            value="{{ $minPrice ?? request('min_price') }}"
                            placeholder="Harga min"
                            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 placeholder:text-slate-400 focus:border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-100">

                        <input type="number"
                            name="max_price"
                            value="{{ $maxPrice ?? request('max_price') }}"
                            placeholder="Harga max"
                            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 placeholder:text-slate-400 focus:border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-100">

                        <select name="stock"
                                class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 focus:border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            <option value="">Semua Stok</option>
                            <option value="ready" @selected(($stock ?? request('stock')) == 'ready')>Ready Stock</option>
                            <option value="sold_out" @selected(($stock ?? request('stock')) == 'sold_out')>Sold Out</option>
                        </select>

                        <select name="sort"
                                class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-800 focus:border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            <option value="latest" @selected(($sort ?? request('sort')) == 'latest')>Terbaru</option>
                            <option value="price_low" @selected(($sort ?? request('sort')) == 'price_low')>Harga Termurah</option>
                            <option value="price_high" @selected(($sort ?? request('sort')) == 'price_high')>Harga Termahal</option>
                            <option value="name" @selected(($sort ?? request('sort')) == 'name')>Nama A-Z</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white transition hover:bg-blue-700">
                            Filter
                        </button>

                        <a href="{{ route('front.catalog') }}"
                        class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-700 transition hover:bg-slate-50">
                            Reset
                        </a>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-5">
                    <div class="flex flex-wrap gap-2">
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700 ring-1 ring-blue-100">
                            {{ $products->total() }} Produk
                        </span>

                        <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-black text-orange-700 ring-1 ring-orange-100">
                            {{ !empty(request()->query()) ? 'Filter Aktif' : 'Semua Produk' }}
                        </span>
                    </div>

                    @if(!empty(request()->query()))
                        <a href="{{ route('front.catalog') }}"
                        class="text-xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-800">
                            Clear all filters
                        </a>
                    @endif
                </div>
            </form>
        </section>

        <!-- Product Grid -->
        <section>
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            @else
                <div class="st-card p-10 md:p-14 text-center">
                    <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>

                    @if(!empty($search))
                        <p class="text-2xl font-black uppercase tracking-tight text-slate-950">
                            Produk tidak ditemukan
                        </p>

                        <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-slate-500">
                            Tidak ada gadget yang cocok dengan pencarian
                            <span class="font-bold text-slate-800">“{{ $search }}”</span>.
                            Coba gunakan keyword lain seperti iPhone, Samsung, laptop, tablet, komputer, atau aksesori.
                        </p>

                        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">
                            <a href="{{ route('front.catalog') }}"
                               class="st-btn-primary">
                                Lihat Semua Gadget
                            </a>

                            <a href="{{ route('front.contact') }}"
                               class="st-btn-ghost">
                                Tanya Support
                            </a>
                        </div>
                    @else
                        <p class="text-2xl font-black uppercase tracking-tight text-slate-950">
                            Katalog masih kosong
                        </p>

                        <p class="mt-3 text-sm text-slate-500">
                            Produk belum tersedia. Silakan cek lagi nanti.
                        </p>
                    @endif
                </div>
            @endif
        </section>

        @if($products->hasPages())
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</main>
@endsection
