@extends('layouts.front')

@section('title', 'Login - SmartTech')

@section('content')
<main class="st-page-wrap">

    <section class="grid gap-6 lg:grid-cols-[1fr_420px] items-center">

        <div class="st-hero p-6 md:p-10">
            <span class="st-eyebrow st-eyebrow-blue">
                Customer Login
            </span>

            <h1 class="st-hero-title text-3xl md:text-6xl mt-4">
                Masuk dan lanjutkan belanja.
            </h1>

            <p class="st-hero-text mt-4 max-w-2xl">
                Cek pesanan, lanjut checkout, dan pantau status transaksi SmartTech dari satu akun customer.
            </p>

            <div class="mt-8 grid gap-3 sm:grid-cols-3">
                <div class="st-card-soft p-5">
                    <div class="st-icon-blue mb-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                    <h3 class="st-subtitle text-sm">Original</h3>
                    <p class="st-muted text-xs mt-1">Produk resmi & jelas.</p>
                </div>

                <div class="st-card-soft p-5">
                    <div class="st-icon-green mb-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg></div>
                    <h3 class="st-subtitle text-sm">Secure</h3>
                    <p class="st-muted text-xs mt-1">Checkout lebih aman.</p>
                </div>

                <div class="st-card-soft p-5">
                    <div class="st-icon-orange mb-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg></div>
                    <h3 class="st-subtitle text-sm">Fast</h3>
                    <p class="st-muted text-xs mt-1">Belanja lebih cepat.</p>
                </div>
            </div>
        </div>

        <section class="st-card p-6 md:p-8">
            <div class="mb-7">
                <span class="st-eyebrow">
                    Welcome Back
                </span>

                <h2 class="st-title text-3xl mt-4">
                    Login Akun
                </h2>

                <p class="st-muted mt-2 text-sm">
                    Masuk untuk lanjut checkout dan pantau pesanan kamu.
                </p>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-100 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-bold">Login gagal</p>
                    <p class="mt-1">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Email Address
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="nama@email.com"
                           class="st-input @error('email') border-red-400 @enderror">

                    @error('email')
                        <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Password
                    </label>
                    <input type="password"
                           name="password"
                           required
                           placeholder="Masukkan password"
                           class="st-input">
                </div>

                <button type="submit" class="st-btn-accent w-full">
                    Login to Account →
                </button>
            </form>

            <div class="mt-7 rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-800">
                <p class="font-bold">Belum punya akun?</p>
                <p class="mt-1">
                    Buat akun biar checkout lebih cepat dan riwayat pesanan tersimpan.
                </p>

                <a href="{{ route('register') }}" class="mt-3 inline-flex font-bold text-blue-700 hover:text-blue-900">
                    Create new account →
                </a>
            </div>
        </section>

    </section>

</main>
@endsection
