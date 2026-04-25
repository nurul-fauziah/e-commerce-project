@extends('layouts.front')

@section('title', 'Kebijakan Privasi - SmartTech')

@section('content')
<main class="st-page-wrap">

    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">Privacy Policy</span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4">
            Kebijakan Privasi
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Kami menjaga data pribadi Anda dengan aman, transparan, dan hanya digunakan untuk kebutuhan transaksi SmartTech.
        </p>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1fr_320px]">

        <div class="st-card p-6 md:p-8 space-y-6">
            <div>
                <h2 class="st-title text-xl mb-2">1. Informasi yang Kami Kumpulkan</h2>
                <p class="st-body text-sm">
                    Kami mengumpulkan informasi seperti nama, email, alamat, dan nomor telepon untuk memproses pesanan Anda.
                </p>
            </div>

            <div>
                <h2 class="st-title text-xl mb-2">2. Penggunaan Data</h2>
                <p class="st-body text-sm">
                    Data digunakan untuk pemrosesan pesanan, pengiriman, verifikasi pembayaran, dan peningkatan layanan.
                </p>
            </div>

            <div>
                <h2 class="st-title text-xl mb-2">3. Keamanan Data</h2>
                <p class="st-body text-sm">
                    Kami menggunakan sistem keamanan untuk melindungi data Anda dari akses tidak sah.
                </p>
            </div>

            <div>
                <h2 class="st-title text-xl mb-2">4. Hak Pengguna</h2>
                <p class="st-body text-sm">
                    Anda berhak mengakses, memperbarui, atau meminta penghapusan data pribadi sesuai kebutuhan layanan.
                </p>
            </div>
        </div>

        <aside class="space-y-4">
            <div class="st-card-soft p-5">
                <h3 class="st-title text-lg mb-2">Data Aman</h3>
                <p class="st-body text-sm">
                    Kami tidak menjual data pelanggan ke pihak lain.
                </p>
            </div>

            <div class="st-card p-5">
                <h3 class="st-title text-lg mb-3">Komitmen SmartTech</h3>
                <ul class="st-list">
                    <li>Data hanya untuk transaksi</li>
                    <li>Checkout diproses aman</li>
                    <li>Support hanya menghubungi bila diperlukan</li>
                </ul>
            </div>
        </aside>

    </section>

</main>
@endsection
