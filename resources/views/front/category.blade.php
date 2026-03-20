<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dept: {{ $category->name }} - SmartTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F5F5F0] text-black antialiased">
    <!-- Navbar -->
    <nav class="border-b-4 border-black bg-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
            <a href="{{ route('front.index') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-black flex items-center justify-center rounded-sm shadow-[3px_3px_0px_0px_#C5F277] group-hover:shadow-none group-hover:translate-x-1 group-hover:translate-y-1 transition-all">
                    <span class="text-white font-black text-xl italic">S</span>
                </div>
                <span class="font-black text-xl tracking-tighter uppercase italic">SmartTech</span>
            </a>
            <div class="flex items-center gap-2 font-black italic uppercase text-sm">
                <span class="bg-black text-white px-2 py-1">DEPT</span>
                <span class="border-2 border-black px-2 py-1">{{ $category->name }}</span>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-16">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
            <div class="max-w-2xl">
                <span class="bg-black text-white px-3 py-1 text-[10px] font-bold uppercase tracking-[0.3em] mb-6 inline-block">Classification: {{ $category->slug }}</span>
                <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter leading-[0.85] uppercase">
                    {{ $category->name }} <br><span class="text-white bg-black px-4">Inventory</span>
                </h1>
            </div>
            <div class="flex flex-col items-end gap-2">
                <p class="text-right text-sm font-bold uppercase opacity-40 tracking-widest">Total_Records_Found</p>
                <p class="text-5xl font-black italic leading-none">{{ $category->products->count() }}</p>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @forelse ($category->products as $product)
            <div class="group relative">
                <div class="bg-white border-4 border-black p-6 shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] transition-all group-hover:shadow-[15px_15px_0px_0px_#C5F277] group-hover:-translate-x-2 group-hover:-translate-y-2">
                    <a href="{{ route('front.details', $product->slug) }}">
                        <div class="aspect-square bg-[#E4E3E0] border-2 border-black mb-6 overflow-hidden relative">
                            <img src="{{ Storage::url($product->thumbnail) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" alt="{{ $product->name }}">
                            <div class="absolute bottom-4 left-4 bg-[#C5F277] border-2 border-black text-[10px] px-3 py-1 font-bold uppercase tracking-widest shadow-[3px_3px_0px_0px_#000]">
                                View_Specs
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-3xl font-black italic tracking-tight uppercase leading-none mb-2">{{ $product->name }}</h3>
                            <p class="text-sm font-semibold opacity-50 line-clamp-2">{{ $product->description }}</p>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t-2 border-black border-dashed">
                            <span class="font-black text-2xl italic">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <div class="bg-black text-white p-4 group-hover:bg-[#C5F277] group-hover:text-black transition-all border-2 border-black">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 border-4 border-dashed border-black/10 flex flex-col items-center justify-center">
                <p class="text-gray-300 font-black text-4xl uppercase tracking-tighter italic">No_Hardware_Found</p>
                <p class="text-gray-400 font-bold uppercase tracking-widest mt-2">This_Department_Is_Currently_Empty</p>
                <a href="{{ route('front.index') }}" class="mt-8 bg-black text-white px-8 py-4 font-black italic uppercase hover:bg-[#C5F277] hover:text-black transition-all border-2 border-black shadow-[6px_6px_0px_0px_#000]">
                    Return_To_Base
                </a>
            </div>
            @endforelse
        </div>
    </main>

    <!-- Footer Info -->
    <footer class="max-w-7xl mx-auto px-4 py-20 border-t-4 border-black mt-20">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
            <p class="font-bold text-xs uppercase tracking-[0.4em] opacity-30">SmartTech_Industrial_Catalog_2026</p>
            <div class="flex gap-8 font-black italic uppercase text-sm">
                <a href="#" class="hover:text-[#C5F277] transition-colors">Privacy_Protocol</a>
                <a href="#" class="hover:text-[#C5F277] transition-colors">Terms_Of_Service</a>
            </div>
        </div>
    </footer>
</body>
</html>
