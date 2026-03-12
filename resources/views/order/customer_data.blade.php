<!-- resources/views/order/customer_data.blade.php -->
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

            <!-- Tambahin ini di atas tag <form> di customer_data.blade.php -->
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

            <!-- PERBAIKAN: Nama route diganti ke 'front.save_customer_data' dan hapus parameter slug -->
            <form action="{{ route('front.save_customer_data') }}" method="POST" class="flex flex-col gap-6">
                @csrf

                <!-- Phone -->
                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-xs tracking-widest">Contact_Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none @error('phone') border-red-500 @enderror"
                           placeholder="e.g. 08123456789">
                    @error('phone') <span class="text-red-500 text-[10px] font-black uppercase italic">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- City -->
                    <div class="flex flex-col gap-2">
                        <label class="font-black uppercase text-xs tracking-widest">Delivery_City</label>
                        <input type="text" name="city" value="{{ old('city') }}" required
                               class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none @error('city') border-red-500 @enderror"
                               placeholder="Jakarta">
                        @error('city') <span class="text-red-500 text-[10px] font-black uppercase italic">{{ $message }}</span> @enderror
                    </div>

                    <!-- Post Code (WAJIB ADA buat StoreCustomerDataRequest) -->
                    <div class="flex flex-col gap-2">
                        <label class="font-black uppercase text-xs tracking-widest">Post_Code</label>
                        <input type="text" name="post_code" value="{{ old('post_code') }}" required
                               class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none @error('post_code') border-red-500 @enderror"
                               placeholder="12345">
                        @error('post_code') <span class="text-red-500 text-[10px] font-black uppercase italic">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-xs tracking-widest">Full_Address</label>
                    <textarea name="address" rows="4" required
                              class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none @error('address') border-red-500 @enderror"
                              placeholder="Street name, Building number, etc.">{{ old('address') }}</textarea>
                    @error('address') <span class="text-red-500 text-[10px] font-black uppercase italic">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="bg-black text-white py-6 font-black italic uppercase text-2xl shadow-[8px_8px_0px_0px_#C5F277] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all mt-6 active:scale-95 border-2 border-black">
                    Proceed_To_Payment
                </button>
            </form>
        </div>

        <!-- Ringkasan Kanan -->
        <div class="w-full lg:w-1/3">
            <div class="bg-[#C5F277] border-4 border-black p-8 sticky top-32 shadow-[10px_10px_0px_0px_#000]">
                <h2 class="text-2xl font-black italic uppercase mb-6 border-b-2 border-black pb-2">Order_Summary</h2>

                <div class="flex gap-4 mb-6">
                    <div class="w-20 h-20 border-2 border-black bg-white overflow-hidden">
                        <img src="{{ Storage::url($product->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                    </div>
                    <div class="flex-1">
                        <p class="font-black italic uppercase leading-none text-sm">{{ $product->name }}</p>
                        <p class="text-[10px] font-bold opacity-50 uppercase mt-1">{{ $orderData['variant_details'] ?? 'Standard Variant' }}</p>
                        <p class="font-black text-xl mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="border-t-2 border-black border-dashed pt-4 flex flex-col gap-2">
                    <div class="flex justify-between font-bold text-xs uppercase">
                        <span>Quantity</span>
                        <span>{{ $orderData['quantity'] ?? 1 }} Unit</span>
                    </div>
                    <div class="flex justify-between font-black text-lg uppercase mt-2">
                        <span>Total</span>
                        <span>Rp {{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
