<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartTech - Gadget Store')</title>

    <meta name="description" content="@yield('meta_description', 'SmartTech menyediakan smartphone, laptop, tablet, dan gadget original dengan checkout aman dan garansi support.')">

    <meta name="theme-color" content="#2563eb">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --st-primary: #2563eb;
            --st-primary-soft: #dbeafe;
            --st-accent: #f59e0b;
            --st-ink: #0f172a;
            --st-muted: #64748b;
            --st-bg: #f8fafc;
            --st-card: #ffffff;
            --st-line: #e2e8f0;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, .10), transparent 32rem),
                radial-gradient(circle at top right, rgba(245, 158, 11, .10), transparent 28rem),
                var(--st-bg);
        }

        .st-container {
            max-width: 80rem;
            margin-left: auto;
            margin-right: auto;
        }

        .st-glass {
            background: rgba(255,255,255,.86);
            backdrop-filter: blur(16px);
        }

        .st-soft-shadow {
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
        }

        .st-link {
            transition: color .2s ease, background-color .2s ease, border-color .2s ease, transform .2s ease;
        }

        .st-nav-link {
            position: relative;
        }

        .st-nav-link::after {
            content: '';
            position: absolute;
            left: .5rem;
            right: .5rem;
            bottom: -.35rem;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--st-primary), var(--st-accent));
            transform: scaleX(0);
            transform-origin: center;
            transition: transform .2s ease;
        }

        .st-nav-link:hover::after {
            transform: scaleX(1);
        }

        .st-focus-ring:focus-visible {
            outline: 3px solid rgba(37, 99, 235, .28);
            outline-offset: 3px;
        }

        .variant-radio:checked + .variant-card {
            background-color: var(--st-primary-soft);
            border-color: var(--st-primary);
            box-shadow: 0 16px 35px rgba(37, 99, 235, .15);
            transform: translateY(-2px);
        }

        .st-page-wrap {
            max-width: 80rem;
            margin-left: auto;
            margin-right: auto;
            padding: 2.5rem 1rem;
        }

        @media (min-width: 640px) {
            .st-page-wrap {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .st-page-wrap {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        .st-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border-radius: 999px;
            border: 1px solid rgba(245, 158, 11, .35);
            background: rgba(255, 247, 237, .9);
            color: #c2410c;
            padding: .45rem .85rem;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .st-eyebrow-blue {
            border-color: rgba(37,99,235,.28);
            background: #eff6ff;
            color: #1d4ed8;
        }

        .st-hero {
            position: relative;
            overflow: hidden;
            border-radius: 1.75rem;
            border: 1px solid #bfdbfe;
            background:
              radial-gradient(circle at 14% 18%, rgba(37,99,235,.18), transparent 32%),
              radial-gradient(circle at 92% 0%, rgba(245,158,11,.18), transparent 35%),
              linear-gradient(135deg, #eff6ff 0%, #ffffff 48%, #fff7ed 100%);
            box-shadow: 0 24px 70px rgba(15, 23, 42, .08);
        }

        .st-hero-title {
            color: #0f172a;
            font-weight: 900;
            letter-spacing: -.04em;
            line-height: 1;
        }

        .st-hero-text {
            color: #475569;
            line-height: 1.75;
        }

        .st-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .07);
        }

        .st-card-soft {
            background: rgba(255,255,255,.78);
            backdrop-filter: blur(14px);
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
        }

        .st-card-dark {
            background: #111827;
            color: #ffffff;
            border: 1px solid rgba(148,163,184,.22);
            border-radius: 1.5rem;
            box-shadow: 0 22px 55px rgba(15, 23, 42, .18);
        }

        .st-card-dark .st-title,
        .st-card-dark .st-subtitle {
            color: #ffffff;
        }

        .st-card-dark .st-muted,
        .st-card-dark .st-body {
            color: #cbd5e1;
        }

        .st-title {
            color: #0f172a;
            font-weight: 800;
            letter-spacing: -.025em;
        }

        .st-subtitle {
            color: #334155;
            font-weight: 700;
        }

        .st-muted {
            color: #64748b;
        }

        .st-body {
            color: #475569;
            line-height: 1.75;
        }

        .st-icon-blue,
        .st-icon-orange,
        .st-icon-green {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
        }

        .st-icon-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .st-icon-orange {
            background: #fff7ed;
            color: #ea580c;
        }

        .st-icon-green {
            background: #ecfdf5;
            color: #059669;
        }

        .st-card-dark .st-icon-blue {
            background: rgba(37,99,235,.15);
            color: #93c5fd;
        }

        .st-card-dark .st-icon-orange {
            background: rgba(245,158,11,.15);
            color: #fbbf24;
        }

        .st-card-dark .st-icon-green {
            background: rgba(16,185,129,.15);
            color: #6ee7b7;
        }

        .st-btn-primary,
        .st-btn-accent,
        .st-btn-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            border-radius: 1rem;
            padding: .85rem 1.15rem;
            font-weight: 800;
            transition: .2s ease;
        }

        .st-btn-primary {
            background: #2563eb;
            color: white;
            box-shadow: 0 14px 30px rgba(37,99,235,.22);
        }

        .st-btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .st-btn-accent {
            background: #f59e0b;
            color: #111827;
            box-shadow: 0 14px 30px rgba(245,158,11,.24);
        }

        .st-btn-accent:hover {
            background: #fbbf24;
            transform: translateY(-1px);
        }

        .st-btn-ghost {
            background: #ffffff;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .st-btn-ghost:hover {
            border-color: #bfdbfe;
            color: #1d4ed8;
            background: #eff6ff;
        }

        .st-list {
            display: grid;
            gap: .65rem;
            color: #475569;
            font-size: .92rem;
            line-height: 1.6;
        }

        .st-list li {
            display: flex;
            gap: .6rem;
        }

        .st-list li::before {
            content: '✓';
            color: #059669;
            font-weight: 900;
        }

        .st-list-danger li::before {
            content: '×';
            color: #dc2626;
        }

        .st-product-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 14px 35px rgba(15, 23, 42, .06);
            transition: .22s ease;
        }

        .st-product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 70px rgba(15, 23, 42, .12);
            border-color: #bfdbfe;
        }

        .st-product-card:focus-within {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12), 0 24px 70px rgba(15, 23, 42, .12);
        }

        .st-price {
            color: #0f172a;
            font-weight: 900;
            letter-spacing: -.03em;
        }

        .st-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: .35rem .7rem;
            font-size: .68rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .st-badge-stock {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .st-badge-category {
            background: rgba(255,255,255,.9);
            color: #334155;
            border: 1px solid #e2e8f0;
            backdrop-filter: blur(10px);
        }

        .st-line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .st-search-input {
            width: 100%;
            border: 0;
            background: transparent;
            font-size: .875rem;
            font-weight: 700;
            color: #0f172a;
        }

        .st-search-input::placeholder {
            color: #94a3b8;
        }

        .st-search-input:focus {
            outline: none;
        }

        .st-nav-search {
            display: flex;
            align-items: center;
            gap: .65rem;
            border: 1px solid #e2e8f0;
            background: rgba(255,255,255,.9);
            border-radius: 1.25rem;
            padding: .7rem .9rem;
            box-shadow: 0 12px 30px rgba(15,23,42,.05);
        }

        .st-nav-search:focus-within {
            border-color: #93c5fd;
            box-shadow: 0 0 0 4px rgba(37,99,235,.12);
        }

        .st-input {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            padding: .9rem 1rem;
            font-weight: 600;
            color: #0f172a;
            outline: none;
            transition: .2s ease;
        }

        .st-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }
    </style>

    @stack('after-styles')
</head>

<body class="text-slate-900 antialiased flex flex-col min-h-screen selection:bg-blue-100 selection:text-blue-900">

    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[999] focus:px-4 focus:py-3 focus:rounded-xl focus:bg-white focus:text-blue-700 focus:shadow-xl focus:font-bold">
        Skip to content
    </a>

    <!-- TOP TRUST BAR -->
    <div class="hidden sm:block bg-slate-950 text-white">
        <div class="st-container px-4 sm:px-6 lg:px-8 py-2 flex items-center justify-between gap-4 text-[11px] font-semibold tracking-wide">
            <div class="flex items-center gap-4 text-white/80">
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Original products
                </span>
                <span class="hidden md:inline">Secure checkout</span>
                <span class="hidden md:inline">Warranty support</span>
                {{-- <span class="hidden lg:inline">Invoice available</span> --}}
            </div>

            <a href="{{ route('front.contact') }}" class="text-amber-300 hover:text-amber-200 transition st-focus-ring">
                Butuh rekomendasi gadget? Hubungi support
            </a>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 border-b border-slate-200/80 st-glass">
        <div class="st-container px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">

            <!-- Brand -->
            <a href="{{ route('front.index') }}" class="flex items-center gap-3 group shrink-0 st-focus-ring" aria-label="SmartTech home">
                <div class="relative w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-600 to-slate-900 flex items-center justify-center st-soft-shadow overflow-hidden">
                    <div class="absolute -right-3 -top-3 w-7 h-7 rounded-full bg-amber-400/80"></div>
                    <span class="relative text-white font-black text-xl italic">S</span>
                </div>

                <div class="leading-tight">
                    <span class="block font-black text-xl md:text-2xl tracking-tight">SmartTech</span>
                    <span class="hidden sm:block text-[10px] uppercase tracking-[0.24em] text-slate-500 font-bold">
                        Gadget Store
                    </span>
                </div>
            </a>

            <!-- Desktop Search -->
            <form action="{{ route('front.catalog') }}"
                  method="GET"
                  class="hidden xl:flex flex-1 max-w-md st-nav-search"
                  role="search">
                <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m21 21-4.35-4.35M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z"/>
                </svg>

                <input type="search"
                       name="search"
                       value="{{ request('search') }}"
                       class="st-search-input"
                       placeholder="Cari iPhone, Samsung, laptop, iPad, MacBook..."
                       aria-label="Search products">

                <button type="submit"
                        class="rounded-xl bg-slate-950 px-4 py-2 text-xs font-black uppercase tracking-widest text-white transition hover:bg-blue-700 st-focus-ring">
                    Search
                </button>
            </form>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-1 font-bold text-sm text-slate-700">

                <a href="{{ route('front.catalog') }}" class="st-nav-link px-3 py-2 rounded-xl hover:text-blue-700 transition st-focus-ring">
                </a>

                <a href="{{ route('front.catalog') }}" class="st-nav-link px-3 py-2 rounded-xl hover:text-blue-700 transition st-focus-ring">
                    Catalog
                </a>

                <a href="{{ route('front.index') }}#categories" class="st-nav-link px-3 py-2 rounded-xl hover:text-blue-700 transition st-focus-ring">
                    Categories
                </a>

                {{-- <a href="{{ route('front.warranty') }}" class="st-nav-link px-3 py-2 rounded-xl hover:text-blue-700 transition st-focus-ring">
                    Warranty
                </a> --}}

                <a href="{{ route('front.contact') }}" class="st-nav-link px-3 py-2 rounded-xl hover:text-blue-700 transition st-focus-ring">
                    Support
                </a>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 md:gap-3">

                <!-- Cart -->
                <a href="{{ route('front.cart') }}"
                   class="relative inline-flex items-center justify-center gap-2 h-11 rounded-2xl bg-amber-400 px-3 md:px-4 text-slate-950 hover:bg-amber-300 hover:-translate-y-0.5 transition st-soft-shadow st-focus-ring"
                   aria-label="Open cart">

                    <svg class="w-[21px] h-[21px]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6.5 7.5H20L18.6 14.4C18.45 15.15 17.8 15.7 17.03 15.7H8.25C7.48 15.7 6.82 15.16 6.66 14.41L5.15 5.9H3.5"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <circle cx="9" cy="19" r="1.35" fill="currentColor"/>
                        <circle cx="17" cy="19" r="1.35" fill="currentColor"/>
                    </svg>

                    <span class="hidden md:inline text-sm font-black">
                        Cart
                    </span>

                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-1.5 -right-1.5 min-w-5 h-5 px-1 rounded-full bg-blue-600 text-white text-[10px] font-black flex items-center justify-center ring-2 ring-white">
                            {{ min(count(session('cart')), 99) }}{{ count(session('cart')) > 99 ? '+' : '' }}
                        </span>
                    @endif
                </a>

                @auth
                    <!-- Profile -->
                    <div class="relative group hidden md:block">
                        <button type="button"
                                class="inline-flex items-center gap-3 px-3 py-2 rounded-2xl border border-slate-200 bg-white text-sm font-bold text-slate-700 hover:border-blue-200 hover:bg-blue-50 transition st-focus-ring"
                                aria-label="Open account menu">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center font-black">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>

                            <div class="hidden lg:block text-left leading-tight">
                                <span class="block max-w-[120px] truncate">
                                    {{ auth()->user()->name ?? 'User' }}
                                </span>
                                <span class="block text-[11px] text-slate-400 font-semibold">
                                    Customer
                                </span>
                            </div>

                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m19 9-7 7-7-7"/>
                            </svg>
                        </button>

                        <div class="absolute right-0 mt-3 w-64 rounded-2xl border border-slate-200 bg-white shadow-xl p-2 hidden group-hover:block group-focus-within:block z-50">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="text-sm font-bold text-slate-900 truncate">
                                    {{ auth()->user()->name ?? 'User' }}
                                </p>
                                <p class="text-xs text-slate-500 truncate">
                                    {{ auth()->user()->email ?? '' }}
                                </p>
                            </div>

                            <a href="{{ route('order.my_orders') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition st-focus-ring">
                                <span aria-hidden="true">📦</span>
                                My Orders
                            </a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 text-left px-4 py-3 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition st-focus-ring">
                                    <span aria-hidden="true">↪</span>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden md:inline-flex px-4 py-2.5 rounded-2xl border border-slate-200 bg-white text-sm font-bold text-slate-700 hover:border-blue-200 hover:text-blue-700 hover:bg-blue-50 transition st-focus-ring">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="hidden md:inline-flex px-4 py-2.5 rounded-2xl bg-slate-950 text-white text-sm font-bold hover:bg-blue-700 transition st-focus-ring">
                        Register
                    </a>
                @endauth

                <!-- Mobile Toggle -->
                <button id="mobile-menu-btn"
                        class="lg:hidden inline-flex items-center justify-center w-11 h-11 rounded-2xl border border-slate-200 bg-white text-slate-800 hover:bg-slate-50 transition st-focus-ring"
                        aria-label="Open menu"
                        aria-controls="mobile-menu"
                        aria-expanded="false">
                    <svg id="menu-open-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                    <svg id="menu-close-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white/95 backdrop-blur-xl">
            <div class="st-container px-4 sm:px-6 py-5 grid gap-2 font-bold text-slate-700">

                <form action="{{ route('front.catalog') }}"
                      method="GET"
                      class="mb-3 st-nav-search"
                      role="search">
                    <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m21 21-4.35-4.35M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z"/>
                    </svg>

                    <input type="search"
                           name="search"
                           value="{{ request('search') }}"
                           class="st-search-input"
                           placeholder="Search products..."
                           aria-label="Search products">

                    <button type="submit"
                            class="rounded-xl bg-slate-950 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-white st-focus-ring">
                        Go
                    </button>
                </form>

                <a href="{{ route('front.catalog') }}" class="mobile-link px-4 py-3 rounded-2xl hover:bg-blue-50 hover:text-blue-700 transition st-focus-ring">
                    Catalog
                </a>

                <a href="{{ route('front.index') }}#categories" class="mobile-link px-4 py-3 rounded-2xl hover:bg-blue-50 hover:text-blue-700 transition st-focus-ring">
                    Categories
                </a>

                <a href="{{ route('front.warranty') }}" class="mobile-link px-4 py-3 rounded-2xl hover:bg-blue-50 hover:text-blue-700 transition st-focus-ring">
                    Warranty
                </a>

                <a href="{{ route('front.contact') }}" class="mobile-link px-4 py-3 rounded-2xl hover:bg-blue-50 hover:text-blue-700 transition st-focus-ring">
                    Support
                </a>

                <a href="{{ route('front.cart') }}" class="mobile-link px-4 py-3 rounded-2xl bg-amber-400 text-slate-950 hover:bg-amber-300 transition st-focus-ring">
                    Cart / Checkout
                </a>

                <div class="my-2 h-px bg-slate-200"></div>

                @auth
                    <div class="px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <p class="text-sm font-bold text-slate-900 truncate">
                            {{ auth()->user()->name ?? 'User' }}
                        </p>
                        <p class="text-xs text-slate-500 truncate">
                            {{ auth()->user()->email ?? '' }}
                        </p>
                    </div>

                    <a href="{{ route('order.my_orders') }}"
                       class="mobile-link px-4 py-3 rounded-2xl bg-slate-50 hover:bg-blue-50 hover:text-blue-700 transition st-focus-ring">
                        My Orders
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-3 rounded-2xl hover:bg-red-50 hover:text-red-600 transition st-focus-ring">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="mobile-link px-4 py-3 rounded-2xl bg-slate-50 hover:bg-blue-50 hover:text-blue-700 transition st-focus-ring">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="mobile-link px-4 py-3 rounded-2xl bg-slate-950 text-white hover:bg-blue-700 transition st-focus-ring">
                        Create Account
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main id="main-content" class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="mt-20 bg-slate-950 text-white relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-600 via-amber-400 to-indigo-600"></div>
        <div class="absolute -right-24 -top-24 w-72 h-72 rounded-full bg-blue-600/10 blur-3xl"></div>
        <div class="absolute -left-24 bottom-0 w-72 h-72 rounded-full bg-amber-400/10 blur-3xl"></div>

        <div class="relative st-container px-4 sm:px-6 lg:px-8 pt-14">
            <div class="mb-12 rounded-[2rem] border border-white/10 bg-white/[0.06] p-6 md:p-8">
                <div class="grid gap-6 md:grid-cols-[1fr_auto] md:items-center">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-amber-300">
                            Need help choosing a gadget?
                        </p>

                        <h3 class="mt-3 text-2xl md:text-4xl font-black tracking-tight text-white">
                            Bingung pilih gadget yang cocok?
                        </h3>

                        <p class="mt-3 max-w-2xl text-sm leading-7 text-white/60">
                            Tim SmartTech siap bantu cek kebutuhan produk, stok, garansi, dan alur pembelian supaya customer lebih yakin sebelum checkout.
                        </p>
                    </div>

                    <a href="{{ route('front.contact') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-amber-400 px-6 py-3 text-sm font-black text-slate-950 transition hover:-translate-y-0.5 hover:bg-amber-300 st-focus-ring">
                        Talk to Support
                    </a>
                </div>
            </div>
        </div>

        <div class="relative st-container px-4 sm:px-6 lg:px-8 pb-14 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="md:col-span-2">
                <a href="{{ route('front.index') }}" class="inline-flex items-center gap-3 mb-5 group st-focus-ring">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-950/40">
                        <span class="text-white font-black text-2xl italic">S</span>
                    </div>

                    <div>
                        <span class="block font-black text-2xl tracking-tight">SmartTech</span>
                        <span class="block text-[10px] uppercase tracking-[0.24em] text-white/40 font-bold">
                            Gadget & Tech Store
                        </span>
                    </div>
                </a>

                <p class="text-sm text-white/60 leading-relaxed max-w-md mb-6">
                    Toko gadget seperti smartphone, laptop, tablet, komputer, dan aksesori dengan fokus pada produk original, harga jelas, dan pengalaman belanja yang mudah.
                </p>

                <div class="grid sm:grid-cols-3 gap-3 max-w-2xl">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-amber-300 font-black text-lg">100%</p>
                        <p class="text-xs text-white/50 font-semibold">Original Product</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-blue-300 font-black text-lg">Secure</p>
                        <p class="text-xs text-white/50 font-semibold">Secure Checkout</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-emerald-300 font-black text-lg">Support</p>
                        <p class="text-xs text-white/50 font-semibold">After-sales Support</p>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="font-black uppercase tracking-widest text-sm mb-5 text-white">Shop</h4>

                <ul class="flex flex-col gap-3 text-sm text-white/60 font-semibold">
                    <li>
                        <a href="{{ route('front.catalog') }}" class="hover:text-amber-300 transition st-focus-ring">
                            Catalog
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('front.index') }}#categories" class="hover:text-amber-300 transition st-focus-ring">
                            Categories
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('front.cart') }}" class="hover:text-amber-300 transition st-focus-ring">
                            Cart / Checkout
                        </a>
                    </li>

                    @auth
                        <li>
                            <a href="{{ route('order.my_orders') }}" class="hover:text-amber-300 transition st-focus-ring">
                                My Orders
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="hover:text-amber-300 transition st-focus-ring">
                                Login
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('register') }}" class="hover:text-amber-300 transition st-focus-ring">
                                Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="font-black uppercase tracking-widest text-sm mb-5 text-white">Support</h4>

                <ul class="flex flex-col gap-3 text-sm text-white/60 font-semibold">
                    <li>
                        <a href="{{ route('front.warranty') }}" class="hover:text-amber-300 transition st-focus-ring">
                            Warranty Claim
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('front.privacy') }}" class="hover:text-amber-300 transition st-focus-ring">
                            Privacy Policy
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('front.terms') }}" class="hover:text-amber-300 transition st-focus-ring">
                            Terms of Service
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('front.contact') }}" class="hover:text-amber-300 transition st-focus-ring">
                            Contact Support
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="relative border-t border-white/10">
            <div class="st-container px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-white/40 font-semibold">
                <p>&copy; {{ date('Y') }} SmartTech Gadget Store</p>

                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>System online · Secure checkout · Warranty support</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('menu-open-icon');
            const closeIcon = document.getElementById('menu-close-icon');
            const links = document.querySelectorAll('.mobile-link');

            function closeMenu() {
                if (!menu || !btn) return;

                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');

                openIcon?.classList.remove('hidden');
                closeIcon?.classList.add('hidden');
            }

            function openMenu() {
                if (!menu || !btn) return;

                menu.classList.remove('hidden');
                btn.setAttribute('aria-expanded', 'true');

                openIcon?.classList.add('hidden');
                closeIcon?.classList.remove('hidden');
            }

            if (btn && menu) {
                btn.addEventListener('click', function() {
                    const isOpen = !menu.classList.contains('hidden');
                    isOpen ? closeMenu() : openMenu();
                });
            }

            links.forEach(function(link) {
                link.addEventListener('click', closeMenu);
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeMenu();
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeMenu();
                }
            });
        });
    </script>

    @stack('after-scripts')
</body>
</html>
