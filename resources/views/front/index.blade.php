@extends('layouts.front')

@section('title', 'SmartTech - Industrial Electronics Store')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
    <!-- Category Section -->
    <section id="categories" class="mb-24 md:mb-32">
        <div class="flex items-center justify-between mb-12">
            <div class="flex flex-col">
                <span class="text-[10px] font-bold uppercase tracking-[0.4em] opacity-40 mb-2">System_Modules</span>
                <h2 class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter leading-none">Hardware_Classification</h2>
            </div>
            <div class="h-1 flex-1 bg-black ml-12 hidden lg:block"></div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            @foreach($categories as $category)
            <a href="{{ route('front.category', $category->slug) }}" class="group">
                <div class="bg-white border-4 border-black p-6 md:p-10 shadow-brutal group-hover:shadow-brutal-neon group-hover:-translate-x-1 group-hover:-translate-y-1 transition-all h-full flex flex-col justify-between">
                    <div class="w-14 h-14 md:w-20 md:h-20 bg-[#F5F5F0] border-2 border-black flex items-center justify-center group-hover:bg-[#C5F277] transition-colors mb-8">
                        <span class="font-black text-2xl md:text-4xl italic uppercase">{{ substr($category->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="font-black italic uppercase text-xl md:text-3xl leading-none mb-2">{{ $category->name }}</h3>
                        <p class="text-[9px] md:text-[11px] font-bold opacity-40 tracking-widest uppercase">
                            {{ $category->products_count ?? $category->products->count() }} Items_Logged
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <!-- Featured Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 md:mb-20 gap-8">
        <div class="max-w-3xl">
            <div class="flex items-center gap-4 mb-6">
                <span class="bg-black text-white px-3 py-1 text-[9px] md:text-[10px] font-bold uppercase tracking-[0.3em]">Status: Operational</span>
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
            </div>
            <h2 class="text-6xl md:text-9xl font-black italic tracking-tighter leading-[0.8] uppercase">
                Hardware <br><span class="text-white bg-black px-4">Terpopuler</span>
            </h2>
        </div>
        <div class="max-w-xs">
            <p class="text-xs md:text-sm font-semibold opacity-60 border-l-8 border-[#C5F277] pl-6 py-2 italic">
                "Kurasi perangkat keras terbaik dengan standar industri. Performa maksimal untuk kebutuhan profesional."
            </p>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-16">
        @forelse ($popularProducts as $product)
        <div class="group relative">
            <a href="{{ route('front.details', $product->slug) }}" class="block bg-white border-4 border-black p-6 shadow-brutal-lg transition-all group-hover:shadow-brutal-neon group-hover:-translate-x-2 group-hover:-translate-y-2">
                <div class="aspect-square bg-[#E4E3E0] border-2 border-black mb-8 overflow-hidden relative">
                    <img src="{{ is_string($product->thumbnail) && str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : Storage::url($product->thumbnail) }}"
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-105 group-hover:scale-100"
                         alt="{{ $product->name }}">
                    <div class="absolute top-4 right-4 bg-black text-white text-[9px] px-3 py-1 font-bold uppercase tracking-widest shadow-[4px_4px_0px_0px_#C5F277]">In_Stock</div>
                </div>
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <h3 class="text-3xl md:text-4xl font-black italic tracking-tight uppercase leading-none">{{ $product->name }}</h3>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-8 border-t-4 border-black border-dashed">
                    <div class="flex flex-col">
                        <span class="text-[9px] font-bold opacity-40 uppercase tracking-widest">Unit_Price</span>
                        <span class="font-black text-2xl md:text-3xl italic">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-black text-white p-4 group-hover:bg-[#C5F277] group-hover:text-black transition-all border-2 border-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <p>No products found.</p>
        @endforelse
    </div>
</main>
@endsection
