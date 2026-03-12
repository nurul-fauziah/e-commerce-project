<!-- resources/views/front/success.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success - SmartTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#C5F277] text-black antialiased flex items-center justify-center min-h-screen p-4">
    <div class="max-w-2xl w-full bg-white border-8 border-black p-12 shadow-[20px_20px_0px_0px_#000] text-center">
        <div class="w-24 h-24 bg-black text-[#C5F277] flex items-center justify-center mx-auto mb-8 rounded-full">
            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
        </div>

        <h1 class="text-6xl font-black italic uppercase tracking-tighter mb-4">Order_Logged</h1>
        <p class="text-xl font-bold opacity-60 mb-12 uppercase tracking-widest">Your transaction has been initialized. Our system will verify your payment shortly.</p>

        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <a href="{{ route('front.index') }}" class="bg-black text-white px-10 py-5 font-black italic uppercase text-xl border-2 border-black hover:bg-[#C5F277] hover:text-black transition-all">
                Return_To_Base
            </a>
            <button class="border-4 border-black px-10 py-5 font-black italic uppercase text-xl hover:bg-black hover:text-white transition-all">
                Check_Status
            </button>
        </div>
    </div>
</body>
</html>
