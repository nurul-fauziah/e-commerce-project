@extends('layouts.front')

@section('content')
<div class="st-page-wrap max-w-5xl">

    <section class="st-hero p-6 md:p-8 mb-6">
        <span class="st-eyebrow mb-4">Warranty Support</span>

        <h1 class="st-hero-title text-3xl md:text-5xl mb-4">
            Garansi Produk
        </h1>

        <p class="st-hero-text text-sm md:text-base max-w-2xl">
            Kami menyediakan dukungan garansi untuk produk tertentu sesuai ketentuan toko, brand, dan kondisi produk saat diterima.
        </p>
    </section>

    <section class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="st-card p-5">
            <div class="st-icon-blue mb-3">1</div>
            <h3 class="st-title text-lg mb-1">Cek Produk</h3>
            <p class="st-body text-sm">Pastikan kondisi produk, dus, dan kelengkapan saat diterima.</p>
        </div>

        <div class="st-card p-5">
            <div class="st-icon-orange mb-3">2</div>
            <h3 class="st-title text-lg mb-1">Simpan Bukti</h3>
            <p class="st-body text-sm">Simpan invoice, foto/video unboxing, dan kartu garansi bila tersedia.</p>
        </div>

        <div class="st-card p-5">
            <div class="st-icon-green mb-3">3</div>
            <h3 class="st-title text-lg mb-1">Ajukan Klaim</h3>
            <p class="st-body text-sm">Hubungi kami dengan nomor pesanan dan bukti pendukung.</p>
        </div>
    </section>

    <section class="grid md:grid-cols-[1fr_320px] gap-6">
        <div class="st-card p-6 space-y-6">
            <div>
                <h2 class="st-title text-xl mb-2">Produk yang Mendapat Garansi</h2>
                <p class="st-body text-sm">
                    Garansi berlaku untuk produk yang memiliki keterangan garansi pada halaman produk atau invoice pembelian.
                    Durasi garansi mengikuti ketentuan brand, distributor, atau toko.
                </p>
            </div>

            <div>
                <h2 class="st-title text-xl mb-3">Syarat Klaim Garansi</h2>
                <ul class="st-list">
                    <li>Memiliki nomor pesanan atau invoice pembelian.</li>
                    <li>Produk masih dalam masa garansi.</li>
                    <li>Kerusakan bukan akibat kesalahan penggunaan.</li>
                    <li>Kelengkapan produk masih tersedia jika diminta.</li>
                </ul>
            </div>

            <div>
                <h2 class="st-title text-xl mb-3">Garansi Tidak Berlaku Jika</h2>
                <ul class="st-list st-list-danger">
                    <li>Produk rusak karena jatuh, terkena air, terbakar, atau modifikasi pribadi.</li>
                    <li>Segel produk rusak tanpa arahan pihak toko/brand.</li>
                    <li>Nomor seri produk tidak sesuai dengan invoice.</li>
                    <li>Masa garansi sudah berakhir.</li>
                </ul>
            </div>

            <div>
                <h2 class="st-title text-xl mb-2">Proses Klaim</h2>
                <p class="st-body text-sm">
                    Setelah klaim diajukan, tim kami akan melakukan pengecekan awal. Jika memenuhi syarat,
                    produk akan diproses untuk perbaikan, penggantian, atau solusi lain sesuai ketentuan garansi.
                </p>
            </div>
        </div>

        <aside class="space-y-4">
            <div class="st-card-soft p-5">
                <h3 class="st-title text-lg mb-2">Butuh Bantuan Klaim?</h3>
                <p class="st-body text-sm mb-4">
                    Siapkan nomor pesanan, foto produk, dan penjelasan kendala agar proses pengecekan lebih cepat.
                </p>

                <a href="{{ route('front.contact') }}" class="st-btn-accent w-full">
                    Hubungi Support
                </a>
            </div>

            <div class="st-card p-5">
                <h3 class="st-title text-lg mb-3">Dokumen yang Disiapkan</h3>
                <ul class="st-list">
                    <li>Invoice pembelian</li>
                    <li>Foto/video kondisi produk</li>
                    <li>Nomor seri produk</li>
                    <li>Kartu garansi jika ada</li>
                </ul>
            </div>
        </aside>
    </section>
</div>
@endsection
