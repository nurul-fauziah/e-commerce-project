@extends('layouts.front')

@section('title', $product->name . ' - SmartTech')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-12 md:py-16">
    <form action="{{ route('front.save_order', $product->slug) }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="variant_details" id="selected_variant_details" value="">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            <!-- KIRI: Gambar -->
            <div class="lg:sticky lg:top-32">
                <div class="bg-white border-4 border-black p-4 shadow-[20px_20px_0px_0px_#000]">
                    <div class="aspect-square bg-[#E4E3E0] border-2 border-black overflow-hidden relative group">
                        <img src="{{ Storage::url($product->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $product->name }}">
                    </div>
                </div>
            </div>

            <!-- KANAN: Info & Form -->
            <div class="flex flex-col gap-10">
                <div>
                    <h1 class="text-5xl md:text-7xl font-black italic uppercase tracking-tighter leading-[0.85] mb-2">{{ $product->name }}</h1>
                    <p class="text-[10px] font-bold uppercase tracking-widest opacity-40">// {{ $product->category->name }}</p>
                </div>

                <div class="bg-[#C5F277] border-4 border-black p-8 shadow-[10px_10px_0px_0px_#000]">
                    <p class="text-5xl md:text-6xl font-black italic tracking-tighter">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <!-- Varian -->
                <div class="flex flex-col gap-6">
                    <h2 class="text-xl font-black italic uppercase border-b-4 border-black pb-1">Select_Variant</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($product->variants as $variant)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="variant_id" value="{{ $variant->id }}" class="variant-radio sr-only" required
                                   onchange="document.getElementById('selected_variant_details').value = '{{ $variant->name }} {{ $variant->value }}'">
                            <div class="variant-card border-4 border-black p-4 bg-white hover:border-[#C5F277] transition-all">
                                <p class="font-black italic uppercase text-sm">{{ $variant->name }}</p>
                                <p class="font-bold opacity-50 text-[11px]">{{ $variant->value }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="w-full bg-black text-white py-6 px-8 font-black italic uppercase text-2xl shadow-[10px_10px_0px_0px_#C5F277] border-2 border-black">
                    Initialize_Purchase
                </button>
            </div>
        </div>
    </form>
</main>
@endsection
