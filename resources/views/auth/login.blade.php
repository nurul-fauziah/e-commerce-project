<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F5F5F0] flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white border-8 border-black p-10 shadow-[20px_20px_0px_0px_#000]">
        <h1 class="text-4xl font-black italic uppercase mb-8 tracking-tighter">Identify_Yourself</h1>

        <!-- Notif Error Umum -->
        @if($errors->any())
        <div class="bg-red-500 text-white border-4 border-black p-4 mb-6 font-bold uppercase text-xs shadow-[4px_4px_0px_0px_#000]">
            <p>! Error: {{ $errors->first() }}</p>
        </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="flex flex-col gap-6">
            @csrf
            <div class="flex flex-col gap-2">
                <label class="font-black uppercase text-xs tracking-widest">Email_Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none @error('email') border-red-500 @enderror">
                @error('email')
                    <span class="text-red-500 text-[10px] font-black uppercase italic">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-black uppercase text-xs tracking-widest">Security_Password</label>
                <input type="password" name="password" required
                       class="border-4 border-black p-4 font-bold focus:bg-[#C5F277] outline-none">
            </div>

            <button type="submit" class="bg-black text-white py-5 font-black italic uppercase text-xl border-2 border-black shadow-[8px_8px_0px_0px_#C5F277] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                Initialize_Login
            </button>
        </form>

        <p class="mt-10 pt-6 border-t-4 border-black border-dashed font-bold text-sm uppercase opacity-50">
            New_User? <a href="{{ route('register') }}" class="underline decoration-4 decoration-[#C5F277] hover:text-black transition-colors">Create_Identity</a>
        </p>
    </div>
</body>
</html>
