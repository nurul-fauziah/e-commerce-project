@extends('layouts.front')

@section('title', 'Order Successful - SmartTech')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-24 text-center">
    <div class="bg-white border-8 border-black p-10 md:p-20 shadow-[20px_20px_0px_0px_#C5F277]">

        <!-- Icon Sukses -->
        <div class="w-24 h-24 bg-black text-[#C5F277] flex items-center justify-center rounded-full mx-auto mb-10 border-4 border-black shadow-[8px_8px_0px_0px_#000]">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-5xl md:text-7xl font-black italic uppercase tracking-tighter leading-none mb-6">Transaction <br> <span class="bg-black text-white px-2">Successful</span></h1>

        <p class="text-xl font-bold uppercase opacity-60 mb-12 tracking-widest italic">
            "Identity verified. Payment authorized. Your hardware is being prepared for deployment."
        </p>

        <!-- Detail Transaksi -->
        <div class="bg-[#F5F5F0] border-4 border-black p-8 text-left mb-12">
            <div class="flex justify-between border-b-2 border-black border-dashed py-3">
                <span class="font-black uppercase text-xs opacity-50">Order_ID</span>
                <span class="font-black italic text-lg">#{{ $productTransaction->booking_trx_id }}</span>
            </div>

            <div class="flex justify-between border-b-2 border-black border-dashed py-3 items-center">
                <span class="font-black uppercase text-xs opacity-50">Hardware_Unit</span>

                <!-- LOGIKA MULTI-ITEM -->
                @php
                    $firstDetail = $productTransaction->transactionDetails->first();
                    $extraCount = $productTransaction->transactionDetails->count() - 1;
                @endphp

                <div class="text-right">
                    <span class="font-black italic text-lg uppercase block leading-none">
                        {{ $firstDetail ? $firstDetail->product->name : 'Hardware Modules' }}
                    </span>
                    @if($extraCount > 0)
                        <span class="text-[10px] font-bold bg-black text-[#C5F277] px-2 py-1 mt-1 inline-block">
                            + {{ $extraCount }} Other Module(s)
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex justify-between py-3 items-end mt-2">
                <span class="font-black uppercase text-xs opacity-50">Total_Paid</span>
                <span class="font-black italic text-3xl">Rp {{ number_format($productTransaction->grand_total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-6">
            <a href="{{ route('front.index') }}" class="flex-1 bg-black text-white py-6 font-black italic uppercase text-xl border-2 border-black shadow-[8px_8px_0px_0px_#C5F277] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                Return_To_Base
            </a>
            <a href="{{ route('order.my_orders') }}" class="flex-1 border-4 border-black py-6 font-black italic uppercase text-xl hover:bg-[#C5F277] transition-all shadow-[8px_8px_0px_0px_#000] active:shadow-none">
                Track_Deployment
            </a>
        </div>

        <p class="mt-12 text-[10px] font-bold opacity-30 uppercase tracking-[0.5em]">SmartTech_Logistics_Protocol_v4.0</p>
    </div>
</div>
@endsection
