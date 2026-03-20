<!-- resources/views/front/checkout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - SmartTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F5F5F0] text-black antialiased">
    <nav class="border-b-4 border-black bg-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
            <a href="{{ route('front.details', $product->slug) }}" class="font-black italic uppercase flex items-center gap-2">
                <span class="bg-black text-white px-2 py-1">CANCEL</span>
            </a>
            <span class="font-black text-xl italic uppercase tracking-tighter">Secure_Checkout</span>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-12">
        <form action="{{ route('front.store_checkout', $product->slug) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            @csrf
            <!-- Left: Form Details -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                <div class="bg-white border-4 border-black p-8 shadow-[10px_10px_0px_0px_#000]">
                    <h2 class="text-3xl font-black italic uppercase mb-8 border-b-4 border-black pb-4">Customer_Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="font-black uppercase text-xs tracking-widest">Full_Name</label>
                            <input type="text" name="name" required class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all" placeholder="Enter your name">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="font-black uppercase text-xs tracking-widest">Email_Address</label>
                            <input type="email" name="email" required class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all" placeholder="name@domain.com">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="font-black uppercase text-xs tracking-widest">Phone_Number</label>
                            <input type="text" name="phone" required class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all" placeholder="+62...">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="font-black uppercase text-xs tracking-widest">City</label>
                            <input type="text" name="city" required class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all" placeholder="Jakarta">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 mt-6">
                        <label class="font-black uppercase text-xs tracking-widest">Complete_Address</label>
                        <textarea name="address" required rows="3" class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all" placeholder="Street name, building number..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mt-6">
                        <div class="flex flex-col gap-2">
                            <label class="font-black uppercase text-xs tracking-widest">Post_Code</label>
                            <input type="text" name="post_code" required class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all" placeholder="12345">
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="bg-white border-4 border-black p-8 shadow-[10px_10px_0px_0px_#000]">
                    <h2 class="text-3xl font-black italic uppercase mb-8 border-b-4 border-black pb-4">Payment_Transfer</h2>
                    <div class="bg-[#F5F5F0] border-2 border-black p-6 mb-8">
                        <p class="font-bold text-sm uppercase opacity-50 mb-2">Transfer_To:</p>
                        <p class="text-2xl font-black italic">BANK CENTRAL ASIA (BCA)</p>
                        <p class="text-3xl font-black tracking-tighter">8820 1234 5678</p>
                        <p class="font-bold mt-2">A/N SMARTTECH INDUSTRIAL</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-black uppercase text-xs tracking-widest">Upload_Proof_Of_Payment</label>
                        <input type="file" name="proof" required class="border-4 border-dashed border-black p-8 font-bold hover:bg-[#C5F277] transition-all cursor-pointer">
                        <p class="text-[10px] font-bold opacity-40 mt-2 italic">*MAX_FILE_SIZE: 2MB (JPG/PNG)</p>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-black text-white p-8 sticky top-32 shadow-[10px_10px_0px_0px_#C5F277]">
                    <h2 class="text-2xl font-black italic uppercase mb-8 border-b-2 border-white/20 pb-4">Order_Summary</h2>

                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-20 h-20 bg-white border-2 border-white overflow-hidden shrink-0">
                            <img src="{{ Storage::url($product->thumbnail) }}" class="w-full h-full object-cover" alt="thumb">
                        </div>
                        <div>
                            <p class="font-black italic uppercase text-lg leading-none">{{ $product->name }}</p>
                            <p class="text-[10px] font-bold opacity-50 mt-2">QTY: 1 UNIT</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 border-t-2 border-white/20 pt-6">
                        <div class="flex justify-between font-bold text-sm">
                            <span>SUBTOTAL</span>
                            <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-sm">
                            <span>TAX (0%)</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="flex justify-between items-end mt-4">
                            <span class="font-black italic text-xl">GRAND_TOTAL</span>
                            <span class="font-black italic text-3xl text-[#C5F277]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#C5F277] text-black py-6 mt-10 font-black italic uppercase text-xl hover:bg-white transition-all border-2 border-black">
                        Confirm_Order
                    </button>
                </div>
            </div>
        </form>
    </main>
</body>
</html>
