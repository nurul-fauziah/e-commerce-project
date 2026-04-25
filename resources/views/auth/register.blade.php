@extends('layouts.front')

@section('title', 'Register - SmartTech')

@section('content')
<main class="st-page-wrap">

    <section class="grid gap-6 lg:grid-cols-[1fr_460px] items-center">

        <div class="st-hero p-6 md:p-10">
            <span class="st-eyebrow st-eyebrow-blue">
                Customer Account
            </span>

            <h1 class="st-hero-title text-3xl md:text-6xl mt-4">
                Daftar sekali, belanja lebih cepat.
            </h1>

            <p class="st-hero-text mt-4 max-w-2xl">
                Simpan data customer, pantau pesanan, dan lanjut checkout produk favorit tanpa isi data berulang-ulang.
            </p>

            <div class="mt-8 grid gap-3 sm:grid-cols-3">
                <div class="st-card-soft p-5">
                    <div class="st-icon-green mb-3">🛡️</div>
                    <h3 class="st-subtitle text-sm">Secure Account</h3>
                    <p class="st-muted text-xs mt-1">Data checkout lebih rapi.</p>
                </div>

                <div class="st-card-soft p-5">
                    <div class="st-icon-blue mb-3">📦</div>
                    <h3 class="st-subtitle text-sm">Order Tracking</h3>
                    <p class="st-muted text-xs mt-1">Cek status pesanan.</p>
                </div>

                <div class="st-card-soft p-5">
                    <div class="st-icon-orange mb-3">⚡</div>
                    <h3 class="st-subtitle text-sm">Fast Checkout</h3>
                    <p class="st-muted text-xs mt-1">Belanja lebih cepat.</p>
                </div>
            </div>
        </div>

        <section class="st-card p-6 md:p-8">
            <div class="mb-7">
                <span class="st-eyebrow">
                    Create Account
                </span>

                <h2 class="st-title text-3xl mt-4">
                    Buat Akun Baru
                </h2>

                <p class="st-muted mt-2 text-sm">
                    Isi data di bawah untuk mulai belanja dan tracking pesanan.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-100 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-bold mb-2">Ada data yang perlu dicek lagi:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input id="name"
                           type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autocomplete="name"
                           class="st-input @error('name') border-red-400 @enderror"
                           placeholder="Masukkan nama lengkap">

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                        Email
                    </label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           class="st-input @error('email') border-red-400 @enderror"
                           placeholder="nama@email.com">

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                            Password
                        </label>
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="new-password"
                               class="st-input @error('password') border-red-400 @enderror"
                               placeholder="Minimal 8 karakter">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <input id="password_confirmation"
                               type="password"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               class="st-input"
                               placeholder="Ulangi password">
                    </div>
                </div>

                @error('password')
                    <p class="-mt-3 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-800">
                    <p class="font-bold mb-1">Benefit akun customer</p>
                    <p>Checkout lebih cepat, data pesanan tersimpan, dan status order lebih mudah dipantau.</p>
                </div>

                <button type="submit" class="st-btn-accent w-full">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-7 border-t border-slate-100 pt-6 text-center">
                <p class="text-sm text-slate-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-bold text-blue-700 hover:text-blue-900">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </section>

    </section>

</main>
@endsection
