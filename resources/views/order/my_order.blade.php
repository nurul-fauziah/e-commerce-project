@extends('layouts.front')

@section('title', 'My Orders - SmartTech')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="mb-12">
        <h1 class="text-5xl md:text-7xl font-black italic uppercase tracking-tighter leading-none">My <br> <span class="bg-black text-white px-2">Orders_Log</span></h1>
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-40 mt-4">Database_Access: Authorized_User_{{ Auth::user()->name }}</p>
    </div>

    <div class="grid grid-cols-1 gap-8">
        @forelse($orders as $order)
            <div class="bg-white border-4 border-black p-6 md:p-8 shadow-[10px_10px_0px_0px_#000] flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-6 w-full md:w-auto">
                    <div class="w-24 h-24 border-2 border-black bg-[#F5F5F0] overflow-hidden flex-shrink-0">
                        <img src="{{ Storage::url($order->product->thumbnail) }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div>
                        <span class="bg-black text-white px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest mb-2 inline-block">#{{ $order->booking_trx_id }}</span>
                        <h2 class="text-2xl font-black italic uppercase leading-none mb-2">{{ $order->product->name }}</h2>
                        <p class="font-bold text-sm opacity-50 uppercase">Ordered_At: {{ $order->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex flex-col md:items-end gap-4 w-full md:w-auto">
                    <!-- Status Badge -->
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-400',
                            'paid' => 'bg-blue-400',
                            'processing' => 'bg-purple-400',
                            'shipped' => 'bg-orange-400',
                            'completed' => 'bg-[#C5F277]',
                            'canceled' => 'bg-red-500 text-white',
                        ];
                    @endphp
                    <span class="{{ $statusColors[$order->status] ?? 'bg-gray-200' }} border-2 border-black px-4 py-1 font-black italic uppercase text-xs shadow-[4px_4px_0px_0px_#000]">
                        Status: {{ $order->status }}
                    </span>

                    <p class="font-black text-2xl italic">Rp {{ number_format($order->grand_total_amount, 0, ',', '.') }}</p>

                    <a href="{{ route('front.my_order_details', $order->id) }}" class="bg-black text-white px-6 py-2 font-black italic uppercase text-xs hover:bg-[#C5F277] hover:text-black transition-all border-2 border-black text-center">
                        View_Details
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-[#F5F5F0] border-4 border-black border-dashed p-20 text-center">
                <p class="font-black italic uppercase text-3xl opacity-20">No_Transactions_Found</p>
                <a href="{{ route('front.index') }}" class="mt-6 inline-block underline font-bold uppercase text-sm">Start_Shopping_Now</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
