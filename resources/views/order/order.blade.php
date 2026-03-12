@extends('layouts.front')

@section('title', 'Review Your Order - SmartTech')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="flex flex-col lg:flex-row gap-12 items-start">

        <!-- Kiri: Review Produk -->
        <div class="flex-1 bg-white border-8 border-black p-6 md:p-10 shadow-[15px_15px_0px_0px_#000]">
            <div class="mb-10">
                <h1 class="text-5xl md:text-6xl font-black italic uppercase tracking-tighter leading-none">Review <br> <span class="bg-black text-white px-2">Your_Order</span></h1>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-40 mt-4">Step_01: Technical_Specification_Check</p>
            </div>

            <div class="flex flex-col md:flex-row gap-8 items-center bg-[#F5F5F0] border-4 border-black p-6 mb-10">
                <div class="w-full md:w-48 aspect-square border-2 border-black bg-white overflow-hidden">
                    <img src="{{ is_string($product->thumbnail) && str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : Storage::url($product->thumbnail) }}"
                         class="w-full h-full object-cover" alt="{{ $product->name }}">
                </div>
                <div class="flex-1 text-center md:text-left">
                    <span class="bg-black text-white px-2 py-1 text-[10px] font-bold uppercase tracking-widest mb-2 inline-block">{{ $product->category->name }}</span>
                    <h2 class="text-3xl md:text-4xl font-black italic uppercase tracking-tight leading-none mb-4">{{ $product->name }}</h2>
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                        <span class="border-2 border-black px-3 py-1 font-bold text-xs uppercase bg-[#C5F277]">{{ $orderData['variant_details'] ?? 'Standard_Unit' }}</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <h3 class="text-xl font-black italic uppercase border-b-4 border-black pb-1 w-fit">Price_Summary</h3>
                <div class="flex justify-between font-bold text-sm uppercase py-2 border-b-2 border-black border-dashed">
                    <span>Unit_Price</span>
                    <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-sm uppercase py-2 border-b-2 border-black border-dashed">
                    <span>Quantity</span>
                    <span>x{{ $orderData['quantity'] ?? 1 }}</span>
                </div>
                <div class="flex justify-between font-bold text-sm uppercase py-2 border-b-2 border-black border-dashed">
                    <span>Tax_PPN_11%</span>
                    <span>Rp {{ number_format($orderData['total_tax'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-black text-2xl uppercase py-4 bg-[#C5F277] px-4 border-2 border-black mt-4">
                    <span>Grand_Total</span>
                    <span>Rp {{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-12">
                <a href="{{ route('front.customer_data') }}" class="block w-full text-center bg-black text-white py-6 font-black italic uppercase text-2xl shadow-[10px_10px_0px_0px_#C5F277] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95 border-2 border-black">
                    Continue_To_Shipping
                </a>
            </div>
        </div>

        <!-- Kanan: Info Tambahan -->
        <div class="w-full lg:w-1/3 flex flex-col gap-8">
            <div class="bg-white border-4 border-black p-8 shadow-[10px_10px_0px_0px_#000]">
                <h4 class="font-black italic uppercase text-lg mb-4 border-b-2 border-black pb-2">Purchase_Protocol</h4>
                <ul class="text-[10px] font-bold uppercase space-y-4 opacity-60 tracking-widest">
                    <li class="flex gap-3"><span class="text-[#C5F277] bg-black px-1">01</span> Data yang dimasukkan harus sesuai dengan identitas asli.</li>
                    <li class="flex gap-3"><span class="text-[#C5F277] bg-black px-1">02</span> Transaksi akan diproses setelah pembayaran terverifikasi.</li>
                    <li class="flex gap-3"><span class="text-[#C5F277] bg-black px-1">03</span> Garansi resmi berlaku sesuai kebijakan brand.</li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
