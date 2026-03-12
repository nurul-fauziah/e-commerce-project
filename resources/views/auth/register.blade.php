<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SmartTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Mencegah horizontal scroll karena bayangan besar */
        .overflow-fix { overflow-x: hidden; }
    </style>
</head>
<body class="bg-[#F5F5F0] flex items-center justify-center min-h-screen p-6 overflow-fix">
    <!-- Lebar dinaikin ke max-w-lg biar gak sesak -->
    <div class="max-w-lg w-full bg-white border-[6px] md:border-8 border-black p-6 md:p-10 shadow-[15px_15px_0px_0px_#000] my-10">

        <div class="mb-10">
            <h1 class="text-4xl md:text-5xl font-black italic uppercase tracking-tighter leading-none">
                Create_New <br> <span class="bg-black text-white px-2">Identity</span>
            </h1>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-40 mt-4">System_Registration_Protocol_v1.0</p>
        </div>

        <form action="{{ url('/register') }}" method="POST" class="flex flex-col gap-6">
            @csrf

            <!-- Name -->
            <div class="flex flex-col gap-2">
                <label class="font-black uppercase text-[10px] tracking-[0.2em] opacity-60">Full_Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all @error('name') border-red-500 @enderror"
                       placeholder="John Doe">
                @error('name')
                    <span class="text-red-500 text-[10px] font-black uppercase italic tracking-widest mt-1">! {{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-2">
                <label class="font-black uppercase text-[10px] tracking-[0.2em] opacity-60">Email_Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all @error('email') border-red-500 @enderror"
                       placeholder="name@domain.com">
                @error('email')
                    <span class="text-red-500 text-[10px] font-black uppercase italic tracking-widest mt-1">! {{ $message }}</span>
                @enderror
            </div>

            <!-- Password Grid (Biar gak terlalu panjang ke bawah) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-[10px] tracking-[0.2em] opacity-60">Password</label>
                    <input type="password" name="password" required
                           class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all @error('password') border-red-500 @enderror">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-[10px] tracking-[0.2em] opacity-60">Confirm</label>
                    <input type="password" name="password_confirmation" required
                           class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none transition-all">
                </div>
            </div>
            @error('password')
                <span class="text-red-500 text-[10px] font-black uppercase italic tracking-widest">! {{ $message }}</span>
            @enderror

            <button type="submit" class="bg-black text-white py-6 font-black italic uppercase text-2xl border-2 border-black shadow-[8px_8px_0px_0px_#C5F277] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all mt-6 active:scale-95">
                Register_Now
            </button>
        </form>

        <div class="mt-12 pt-8 border-t-4 border-black border-dashed">
            <p class="font-bold text-xs uppercase opacity-50 mb-4 tracking-widest">Already_Registered?</p>
            <a href="{{ route('login') }}" class="inline-block font-black italic uppercase text-xl hover:text-emerald-600 transition-colors underline decoration-[6px] decoration-[#C5F277] underline-offset-8">
                Access_Terminal
            </a>
        </div>
    </div>
</body>
</html>
