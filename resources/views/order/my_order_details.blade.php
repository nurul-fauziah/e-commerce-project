@extends('layouts.front')

@section('title', 'Order Details - SmartTech')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-16">
    <a href="{{ route('order.my_orders') }}" class="font-bold text-xs uppercase hover:underline mb-8 inline-block">< BACK_TO_LOGS</a>

    <div class="bg-white border-8 border-black p-8 md:p-12 shadow-[20px_20px_0px_0px_#000]">

        <div class="flex flex-col md:flex-row justify-between md:items-end border-b-4 border-black pb-8 mb-8">
            <div>
                <h1 class="text-4xl md:text-5xl font-black italic uppercase tracking-tighter leading-none mb-2">TRX_#{{ $productTransaction->booking_trx_id }}</h1>
                <p class="font-bold uppercase opacity-50">Date: {{ $productTransaction->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="mt-4 md:mt-0 text-right">
                <span class="bg-black text-white px-4 py-2 font-black italic uppercase text-sm shadow-[4px_4px_0px_0px_#C5F277]">
                    STATUS: {{ $productTransaction->is_paid ? 'PAID' : 'PENDING' }}
                </span>
            </div>
        </div>

        <!-- Tabel Barang -->
        <h3 class="font-black text-xl italic uppercase mb-4">Hardware_Deployed</h3>
        <div class="border-4 border-black mb-10 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-black text-white font-bold uppercase text-xs tracking-widest">
                        <th class="p-4 border-r-2 border-white/20">Module</th>
                        <th class="p-4 border-r-2 border-white/20">Config</th>
                        <th class="p-4 border-r-2 border-white/20 text-center">Qty</th>
                        <th class="p-4 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productTransaction->transactionDetails as $detail)
                    <tr class="border-b-2 border-black font-bold text-sm bg-white hover:bg-[#F5F5F0]">
                        <td class="p-4 border-r-2 border-black italic uppercase">{{ $detail->product->name }}</td>
                        <td class="p-4 border-r-2 border-black text-xs opacity-60">{{ $detail->variant_details }}</td>
                        <td class="p-4 border-r-2 border-black text-center">{{ $detail->quantity }}</td>
                        <td class="p-4 text-right italic">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Info Pengiriman -->
            <div>
                <h3 class="font-black text-xl italic uppercase mb-4 border-b-2 border-black pb-2">Shipping_Vector</h3>
                <ul class="font-bold text-sm space-y-2 uppercase">
                    <li><span class="opacity-50 inline-block w-24">Receiver:</span> {{ $productTransaction->name }}</li>
                    <li><span class="opacity-50 inline-block w-24">Contact:</span> {{ $productTransaction->phone }}</li>
                    <li><span class="opacity-50 inline-block w-24">City:</span> {{ $productTransaction->city }} ({{ $productTransaction->post_code }})</li>
                    <li class="pt-2"><span class="opacity-50 block mb-1">Address:</span> {{ $productTransaction->address }}</li>
                </ul>
            </div>

            <!-- Total -->
            <div class="bg-[#C5F277] border-4 border-black p-6 flex flex-col justify-end">
                <div class="flex justify-between font-bold text-sm uppercase mb-2">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($productTransaction->sub_total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-sm uppercase mb-4 text-red-600">
                    <span>Discount</span>
                    <span>- Rp {{ number_format($productTransaction->discount_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-black text-2xl italic uppercase border-t-4 border-black border-dashed pt-4">
                    <span>Grand_Total</span>
                    <span>Rp {{ number_format($productTransaction->grand_total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
