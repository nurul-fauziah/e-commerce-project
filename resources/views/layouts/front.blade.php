<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartTech - Premium Industrial Electronics')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        html { scroll-behavior: smooth; }
        .shadow-brutal { box-shadow: 6px 6px 0px 0px rgba(0,0,0,1); }
        .shadow-brutal-lg { box-shadow: 12px 12px 0px 0px rgba(0,0,0,1); }
        .shadow-brutal-neon { box-shadow: 10px 10px 0px 0px #C5F277; }
        /* Custom radio styling for variants */
        .variant-radio:checked + .variant-card {
            background-color: #C5F277;
            border-color: black;
            box-shadow: 4px 4px 0px 0px #000;
            transform: translate(-2px, -2px);
        }
    </style>
    @stack('after-styles')
</head>
<body class="bg-[#F5F5F0] text-black antialiased">

    <!-- NAVBAR (HEADER) -->
    <nav class="border-b-4 border-black bg-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('front.index') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-black flex items-center justify-center rounded-sm shadow-[3px_3px_0px_0px_#C5F277] group-hover:shadow-none group-hover:translate-x-1 group-hover:translate-y-1 transition-all">
                    <span class="text-white font-black text-xl md:text-2xl italic">S</span>
                </div>
                <span class="font-black text-xl md:text-2xl tracking-tighter uppercase italic">SmartTech</span>
            </a>

            <div class="hidden md:flex gap-8 font-bold text-xs uppercase tracking-widest">
                <a href="#catalog" class="hover:text-emerald-600 transition-colors">Catalog</a>
                <a href="#categories" class="hover:text-emerald-600 transition-colors">Categories</a>
                @auth
                    <a href="{{ route('order.my_orders') }}" class="hover:text-emerald-600 transition-colors">My_Orders</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-red-600 transition-colors uppercase">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-emerald-600 transition-colors">Login</a>
                @endauth
            </div>

            <button class="p-2 md:p-3 border-2 border-black bg-[#C5F277] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </button>
        </div>
    </nav>

    <!-- TEMPAT KONTEN HALAMAN -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="bg-black text-white py-20 mt-20 border-t-8 border-[#C5F277]">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-12">
            <div class="flex flex-col items-center md:items-start">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-[#C5F277] flex items-center justify-center rounded-sm">
                        <span class="text-black font-black text-xl italic">S</span>
                    </div>
                    <span class="font-black text-2xl tracking-tighter uppercase italic">SmartTech</span>
                </div>
                <p class="text-[10px] font-bold tracking-[0.5em] uppercase opacity-50">Industrial_Systems_Division_2026</p>
            </div>

            <div class="flex gap-12 font-black italic uppercase text-sm tracking-widest">
                <a href="#" class="hover:text-[#C5F277] transition-colors">Protocol</a>
                <a href="#" class="hover:text-[#C5F277] transition-colors">Terminal</a>
                <a href="#" class="hover:text-[#C5F277] transition-colors">Support</a>
            </div>
        </div>
    </footer>

    @stack('after-scripts')
</body>
</html>
