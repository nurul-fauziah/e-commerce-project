@extends('layouts.front')

@section('title', $category->name . ' - SmartTech')

@section('content')
<main class="relative overflow-hidden">
    <!-- Subtle modern accents: keep the e-commerce structure, add visual warmth -->
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-28 right-[-12%] h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute top-[28rem] left-[-10%] h-80 w-80 rounded-full bg-orange-400/10 blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">

        <!-- Category Header -->
        <section class="mb-10 md:mb-14">
            <div class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_10%,rgba(37,99,235,0.13),transparent_34%),radial-gradient(circle_at_85%_0%,rgba(245,158,11,0.15),transparent_32%)]"></div>

                <div class="relative grid lg:grid-cols-[1.15fr_0.85fr] gap-8 items-center p-6 sm:p-8 md:p-10">
                    <div>
                        <a href="{{ route('front.catalog') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600 transition mb-5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Kembali ke katalog
                        </a>

                        <div class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-[10px] font-black uppercase tracking-[0.24em] text-blue-700 mb-5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Category Shelf
                        </div>

                        <h1 class="text-4xl sm:text-5xl md:text-7xl font-black tracking-tight leading-[0.95] text-slate-950 uppercase">
                            {{ $category->name }}
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-orange-500">Collection</span>
                        </h1>

                        <p class="mt-5 max-w-2xl text-sm sm:text-base leading-7 text-slate-600">
                            Pilihan produk dalam kategori {{ $category->name }} dengan harga jelas, status stok terlihat, dan akses cepat ke detail sebelum checkout.
                        </p>

                        <div class="mt-7 grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-2xl">
                            <div class="rounded-2xl border border-slate-200 bg-white/75 p-4">
                                <p class="text-lg font-black text-slate-950">{{ $category->products->count() }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Produk tersedia</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white/75 p-4">
                                <p class="text-lg font-black text-slate-950">Original</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Produk resmi</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white/75 p-4">
                                <p class="text-lg font-black text-slate-950">Warranty</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Garansi toko</p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block">
                        <div class="relative rounded-[2rem] bg-slate-950 p-5 shadow-2xl overflow-hidden">
                            <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(37,99,235,0.30),transparent_40%),radial-gradient(circle_at_85%_18%,rgba(245,158,11,0.28),transparent_34%)]"></div>
                            <div class="relative aspect-[4/3] rounded-[1.5rem] border border-white/10 bg-slate-900 p-6 flex items-center justify-center">
                                <div class="grid grid-cols-2 gap-4 rotate-2">
                                    <div class="h-28 w-28 rounded-3xl bg-white/10 border border-white/10 p-4 shadow-xl">
                                        <div class="h-10 w-10 rounded-2xl bg-blue-500"></div>
                                        <div class="mt-4 h-3 w-16 rounded-full bg-white/20"></div>
                                        <div class="mt-2 h-3 w-12 rounded-full bg-white/10"></div>
                                    </div>
                                    <div class="mt-8 h-28 w-28 rounded-3xl bg-white/10 border border-white/10 p-4 shadow-xl">
                                        <div class="h-10 w-10 rounded-2xl bg-orange-400"></div>
                                        <div class="mt-4 h-3 w-16 rounded-full bg-white/20"></div>
                                        <div class="mt-2 h-3 w-12 rounded-full bg-white/10"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative mt-4 flex items-center justify-between rounded-2xl bg-white/10 p-4 backdrop-blur">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Current Category</p>
                                    <p class="text-white font-black">{{ $category->name }}</p>
                                </div>
                                <span class="rounded-full bg-emerald-400/20 px-3 py-1 text-xs font-bold text-emerald-300">Open</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Category Toolbar -->
        <section class="mb-8 md:mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 rounded-3xl border border-slate-200 bg-white p-4 md:p-5 shadow-sm">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.28em] text-blue-600">Filtered Product Shelf</p>
                    <h2 class="mt-1 text-2xl md:text-3xl font-black uppercase tracking-tight text-slate-950">
                        Produk {{ $category->name }}
                    </h2>
                </div>

                <div class="grid grid-cols-2 sm:flex gap-3">
                    <div class="rounded-2xl bg-blue-50 px-4 py-3 text-center sm:text-left">
                        <p class="text-[10px] font-black uppercase tracking-widest text-blue-700">Total Produk</p>
                        <p class="text-sm font-black text-slate-950">{{ $category->products->count() }} Item</p>
                    </div>
                    <div class="rounded-2xl bg-orange-50 px-4 py-3 text-center sm:text-left">
                        <p class="text-[10px] font-black uppercase tracking-widest text-orange-700">Kategori</p>
                        <p class="text-sm font-black text-slate-950">{{ $category->slug }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Grid -->
        <section>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @forelse ($category->products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full st-card p-10 md:p-14 text-center">
                        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                        </div>

                        <p class="text-2xl font-black uppercase tracking-tight text-slate-950">
                            Kategori masih kosong
                        </p>

                        <p class="mt-3 text-sm text-slate-500">
                            Belum ada produk di kategori {{ $category->name }}.
                        </p>

                        <a href="{{ route('front.catalog') }}" class="st-btn-primary mt-6">
                            Lihat Katalog
                        </a>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</main>
@endsection
