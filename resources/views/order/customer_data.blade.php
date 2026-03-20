@extends('layouts.front')

@section('title', 'Shipping Details - SmartTech')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="flex flex-col lg:flex-row gap-12 items-start">

        <!-- Form Kiri -->
        <div class="flex-1 bg-white border-8 border-black p-6 md:p-10 shadow-[15px_15px_0px_0px_#000]">
            <div class="mb-10">
                <h1 class="text-5xl font-black italic uppercase tracking-tighter leading-none">Shipping <br> <span class="bg-black text-white px-2">Details</span></h1>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-40 mt-4">Step_02: Customer_Information_Input</p>
            </div>

            @if($errors->any())
                <div class="bg-red-500 text-white border-4 border-black p-4 mb-8 font-black uppercase text-xs shadow-[4px_4px_0px_0px_#000] italic">
                    <p class="mb-2">! System_Error_Detected:</p>
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('order.save_customer_data') }}" method="POST" class="flex flex-col gap-6">
                @csrf

                <!-- Nama & Email (Otomatis dari Auth) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="font-black uppercase text-xs tracking-widest">Receiver_Name</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" readonly class="border-4 border-black p-4 font-bold bg-gray-200 outline-none">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-black uppercase text-xs tracking-widest">Email_Address</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" readonly class="border-4 border-black p-4 font-bold bg-gray-200 outline-none">
                    </div>
                </div>

                <!-- Phone -->
                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-xs tracking-widest">Contact_Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none"
                           placeholder="e.g. 08123456789">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="font-black uppercase text-xs tracking-widest">Delivery_City</label>
                        <input type="text" name="city" value="{{ old('city') }}" required
                               class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none"
                               placeholder="Jakarta">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-black uppercase text-xs tracking-widest">Post_Code</label>
                        <input type="text" name="post_code" value="{{ old('post_code') }}" required
                               class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none"
                               placeholder="12345">
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-xs tracking-widest">Full_Address</label>
                    <textarea name="address" rows="4" required
                              class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none"
                              placeholder="Street name, Building number, etc.">{{ old('address') }}</textarea>
                </div>

                <button type="submit" class="bg-black text-white py-6 font-black italic uppercase text-2xl shadow-[8px_8px_0px_0px_#C5F277] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all mt-6 border-2 border-black">
                    Proceed_To_Payment
                </button>
            </form>
        </div>

        <!-- Ringkasan Kanan (MULTI-ITEM) -->
        <div class="w-full lg:w-1/3">
            <div class="bg-[#C5F277] border-4 border-black p-8 sticky top-32 shadow-[10px_10px_0px_0px_#000]">
                <h2 class="text-2xl font-black italic uppercase mb-6 border-b-2 border-black pb-2">Order_Summary</h2>

                <div class="flex flex-col gap-4 mb-6 max-h-64 overflow-y-auto pr-2">
                    @foreach($orderData['cart_items'] as $item)
                    <div class="flex gap-4 bg-white border-2 border-black p-2">
                        <div class="w-16 h-16 border-2 border-black bg-[#E4E3E0] overflow-hidden shrink-0">
                            <img src="{{ is_string($item['thumbnail']) && str_starts_with($item['thumbnail'], 'http') ? $item['thumbnail'] : Storage::url($item['thumbnail']) }}" class="w-full h-full object-cover grayscale" alt="Thumb">
                        </div>
                        <div class="flex-1">
                            <p class="font-black italic uppercase leading-none text-xs truncate">{{ $item['name'] }}</p>
                            <p class="text-[9px] font-bold opacity-50 uppercase mt-1 line-clamp-1">{{ $item['variant_details'] }}</p>
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-[10px] font-bold">x{{ $item['quantity'] }}</p>
                                <p class="font-black text-sm">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t-4 border-black border-dashed pt-4 flex flex-col gap-2">
                    <div class="flex justify-between items-end mt-2">
                        <span class="font-black text-lg uppercase">Total</span>
                        <span class="font-black italic text-2xl">Rp {{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
