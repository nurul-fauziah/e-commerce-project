@props(['product'])

@php
    $stock = (int) ($product->stock ?? 0);
    $isReady = $stock > 0;

    $thumbnail = is_string($product->thumbnail) && str_starts_with($product->thumbnail, 'http')
        ? $product->thumbnail
        : Storage::url($product->thumbnail);

    $categoryName = $product->category->name ?? 'Product';

    // FAKE SOCIAL PROOF (sementara)
    $rating = number_format(rand(46, 50) / 10, 1); // 4.6 - 5.0
    $sold = rand(20, 150);
@endphp

<article class="st-product-card group h-full">
    <a href="{{ route('front.details', $product->slug) }}"
       class="flex h-full flex-col st-focus-ring"
       aria-label="View details for {{ $product->name }}">

        <!-- IMAGE -->
        <div class="relative aspect-square overflow-hidden bg-slate-100">
            <img src="{{ $thumbnail }}"
                 class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                 alt="{{ $product->name }}"
                 loading="lazy">

            <!-- CATEGORY -->
            <div class="absolute left-4 top-4 st-badge st-badge-category max-w-[70%] truncate">
                {{ $categoryName }}
            </div>

            <!-- STATUS -->
            @if($isReady)
                <div class="absolute right-4 top-4 st-badge st-badge-stock">
                    Ready
                </div>
            @else
                <div class="absolute right-4 top-4 st-badge bg-rose-50 text-rose-700 border border-rose-100">
                    Sold Out
                </div>
            @endif

            <!-- POPULAR BADGE -->
            <div class="absolute left-4 bottom-4">
                <span class="rounded-full bg-orange-500 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white shadow">
                    Popular
                </span>
            </div>

            <!-- HOVER CTA -->
            <div class="absolute inset-x-4 bottom-4 translate-y-3 opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                <div class="rounded-2xl border border-white/60 bg-white/90 px-4 py-3 text-center text-xs font-black uppercase tracking-widest text-slate-900 shadow-xl backdrop-blur">
                    Lihat Detail
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="flex flex-1 flex-col p-5">

            <div class="flex-1">

                <!-- TAGS -->
                <div class="mb-3 flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-black uppercase tracking-widest text-blue-700 ring-1 ring-blue-100">
                        Original
                    </span>

                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-700 ring-1 ring-emerald-100">
                        Warranty
                    </span>
                </div>

                <!-- TITLE -->
                <h3 class="st-line-clamp-2 text-lg font-black leading-tight text-slate-950 group-hover:text-blue-700 transition">
                    {{ $product->name }}
                </h3>

                <!-- SOCIAL PROOF -->
                <div class="mt-2 flex items-center gap-3 text-xs font-bold text-slate-500">
                    <span>⭐ {{ $rating }}</span>
                    <span>•</span>
                    <span>{{ $sold }}+ terjual</span>
                </div>

                <!-- DESC -->
                <p class="mt-2 st-line-clamp-2 text-sm leading-6 text-slate-500">
                    {{ $product->description ?? 'Gadget original dengan kualitas terjamin dan dukungan garansi resmi.' }}
                </p>
            </div>

            <!-- INFO -->
            <div class="mt-4 grid grid-cols-2 gap-2 text-xs">
                <div class="rounded-2xl bg-slate-50 px-3 py-2 ring-1 ring-slate-100">
                    <p class="font-black text-slate-900">Stock</p>
                    <p class="mt-0.5 font-semibold {{ $isReady ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $isReady ? $stock . ' tersedia' : 'Habis' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 px-3 py-2 ring-1 ring-slate-100">
                    <p class="font-black text-slate-900">Support</p>
                    <p class="mt-0.5 font-semibold text-slate-500">
                        Garansi
                    </p>
                </div>
            </div>

            <!-- PRICE -->
            <div class="mt-5 border-t border-slate-100 pt-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-400">
                    Harga
                </p>

                <div class="mt-1 flex items-end justify-between gap-4">
                    <p class="st-price text-2xl">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl {{ $isReady ? 'bg-blue-600 group-hover:bg-orange-500' : 'bg-slate-300' }} text-white shadow-lg shadow-blue-600/20 transition">
                        →
                    </span>
                </div>

                <!-- URGENCY -->
                @if($isReady && $stock <= 5)
                    <p class="mt-2 text-[11px] font-bold text-orange-600">
                        Stok terbatas!
                    </p>
                @endif

                <p class="mt-2 text-[11px] font-semibold text-slate-400">
                    Harga dapat berubah sesuai varian.
                </p>
            </div>
        </div>
    </a>
</article>
