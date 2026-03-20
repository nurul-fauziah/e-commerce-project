@extends('layouts.front')

@section('title', 'System Cart - SmartTech')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-12 md:py-16">
    <!-- Header -->
    <div class="flex flex-col mb-12">
        <span class="text-[10px] font-bold uppercase tracking-[0.4em] opacity-40 mb-2">Order_Queue</span>
        <h1 class="text-5xl md:text-7xl font-black italic uppercase tracking-tighter leading-none">System_Cart</h1>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-[#C5F277] border-4 border-black p-4 mb-8 font-bold uppercase text-sm shadow-[4px_4px_0px_0px_#000]">
            > SYSTEM_LOG: {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-500 text-white border-4 border-black p-4 mb-8 font-bold uppercase text-sm shadow-[4px_4px_0px_0px_#000]">
            > ERROR_DETECTED: {{ $errors->first() }}
        </div>
    @endif

    <!-- Cart Content -->
    @if(count($cart ?? []) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12 items-start">

            <!-- KIRI: Daftar Hardware yang Dipesan -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                @foreach($cart as $key => $item)
                    <div class="bg-white border-4 border-black p-4 md:p-6 flex flex-col md:flex-row gap-6 items-start md:items-center shadow-[8px_8px_0px_0px_#000]">
                        <!-- Thumbnail Produk -->
                        <div class="w-24 h-24 bg-[#E4E3E0] border-2 border-black shrink-0 relative">
                            <img src="{{ is_string($item['thumbnail']) && str_starts_with($item['thumbnail'], 'http') ? $item['thumbnail'] : Storage::url($item['thumbnail']) }}"
                                 class="w-full h-full object-cover grayscale"
                                 alt="{{ $item['name'] }}">
                        </div>

                        <!-- Informasi Varian & Harga -->
                        <div class="flex-1 w-full">
                            <a href="{{ route('front.details', $item['slug']) }}" class="hover:underline decoration-4 underline-offset-4">
                                <h3 class="text-xl md:text-2xl font-black italic uppercase leading-tight">{{ $item['name'] }}</h3>
                            </a>
                            <p class="text-xs font-mono text-gray-500 uppercase mt-2">> Config: {{ $item['variant_details'] }}</p>

                            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm font-bold">
                                <span class="bg-black text-white px-3 py-1 font-mono">QTY: {{ $item['quantity'] }}</span>
                                <span class="opacity-60 italic">Rp {{ number_format($item['price'], 0, ',', '.') }} / item</span>
                            </div>
                        </div>

                        <!-- Subtotal & Tombol Hapus -->
                        <div class="flex flex-col items-end gap-4 shrink-0 w-full md:w-auto mt-4 md:mt-0 pt-4 md:pt-0 border-t-2 md:border-t-0 border-dashed border-black">
                            <p class="text-2xl md:text-3xl font-black italic text-right w-full">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </p>
                            <form action="{{ route('front.cart.remove', $key) }}" method="POST" class="w-full text-right">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold uppercase text-red-600 hover:text-white hover:bg-red-600 border-2 border-transparent hover:border-black px-2 py-1 transition-all">
                                    [ Remove_Module ]
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- KANAN: Ringkasan & Checkout -->
            <div class="lg:col-span-1 lg:sticky lg:top-32">
                <div class="bg-[#C5F277] border-4 border-black p-6 md:p-8 shadow-[10px_10px_0px_0px_#000]">
                    <h2 class="text-2xl font-black italic uppercase border-b-4 border-black pb-4 mb-6">Execution_Summary</h2>

                    <div class="flex justify-between items-center mb-4 font-bold uppercase text-sm">
                        <span>Allocated_Modules</span>
                        <span class="font-mono bg-black text-white px-2">{{ count($cart) }}</span>
                    </div>

                    <div class="flex justify-between items-end mb-8 pt-6 border-t-4 border-black border-dashed">
                        <span class="font-black italic uppercase text-lg">Subtotal</span>
                        <span class="text-3xl font-black italic tracking-tighter">
                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Tombol Lanjut ke Checkout -->
                    <form action="{{ route('front.begin_checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-black text-white py-5 px-6 font-black italic uppercase text-xl border-2 border-black hover:bg-white hover:text-black transition-all group">
                            Initialize_Checkout
                            <span class="block text-[10px] font-mono opacity-50 mt-1 group-hover:opacity-100">> Secure Connection</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @else
        <!-- Tampilan Jika Keranjang Kosong -->
        <div class="py-32 border-4 border-dashed border-black/20 flex flex-col items-center justify-center text-center">
            <p class="text-gray-300 font-black text-5xl uppercase tracking-tighter italic mb-4">Queue_Empty</p>
            <p class="text-gray-400 font-bold uppercase tracking-widest text-sm mb-8">No_Hardware_Selected_For_Purchase</p>
            <a href="{{ route('front.index') }}" class="bg-black text-white px-8 py-4 font-black italic uppercase hover:bg-[#C5F277] hover:text-black transition-all border-2 border-black shadow-[6px_6px_0px_0px_#000]">
                Browse_Catalog
            </a>
        </div>
    @endif
</main>
@endsection
