@extends('layouts.front')

@section('title', 'Syarat & Ketentuan - SmartTech')

@section('content')
<main class="st-page-wrap">

    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">Store Policy</span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4">
            Syarat & Ketentuan
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Dengan menggunakan layanan kami, Anda menyetujui aturan pembelian, pembayaran, pengiriman, dan penggunaan website ini.
        </p>
    </section>

    <section class="grid md:grid-cols-[1fr_320px] gap-6">

        <div class="st-card p-6 md:p-8 space-y-6">

            <div>
                <h2 class="st-title text-xl mb-2">1. Ketentuan Pembelian</h2>
                <p class="st-body text-sm">
                    Pastikan produk, jumlah, varian, dan alamat pengiriman sudah benar sebelum melakukan pembayaran.
                    Pesanan yang telah diproses tidak dapat dibatalkan secara sepihak.
                </p>
            </div>

            <div>
                <h2 class="st-title text-xl mb-2">2. Harga & Ketersediaan Produk</h2>
                <p class="st-body text-sm">
                    Harga dan stok produk dapat berubah sewaktu-waktu. Jika terjadi kendala stok setelah pembayaran,
                    kami akan menghubungi Anda untuk opsi penggantian produk atau pengembalian dana.
                </p>
            </div>

            <div>
                <h2 class="st-title text-xl mb-2">3. Pembayaran</h2>
                <p class="st-body text-sm">
                    Pembayaran wajib dilakukan melalui metode yang tersedia di website. Pesanan akan diproses setelah
                    pembayaran berhasil diverifikasi oleh sistem.
                </p>
            </div>

            <div>
                <h2 class="st-title text-xl mb-2">4. Pengiriman</h2>
                <p class="st-body text-sm">
                    Estimasi pengiriman mengikuti lokasi tujuan dan layanan kurir. Keterlambatan akibat pihak ekspedisi,
                    cuaca, atau kondisi di luar kendali toko bukan menjadi tanggung jawab langsung kami.
                </p>
            </div>

            <div>
                <h2 class="st-title text-xl mb-2">5. Garansi & Pengembalian</h2>
                <p class="st-body text-sm">
                    Produk tertentu memiliki garansi sesuai ketentuan masing-masing. Pengembalian hanya berlaku jika produk
                    rusak saat diterima, salah kirim, atau tidak sesuai pesanan, dengan bukti yang valid.
                </p>
            </div>

            <div>
                <h2 class="st-title text-xl mb-2">6. Akun Pengguna</h2>
                <p class="st-body text-sm">
                    Pengguna bertanggung jawab menjaga keamanan akun masing-masing. Aktivitas yang terjadi melalui akun Anda
                    dianggap sebagai tanggung jawab pemilik akun.
                </p>
            </div>

        </div>

        <aside class="space-y-4">
            <div class="st-card-soft p-5">
                <h3 class="st-title text-lg mb-2">Belanja Lebih Aman</h3>
                <p class="st-body text-sm">
                    Pastikan Anda membaca ketentuan sebelum checkout agar proses transaksi lebih lancar.
                </p>
            </div>

            <div class="st-card p-5 space-y-4">
                <div class="flex gap-3">
                    <div class="st-icon-blue shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                    <div>
                        <p class="st-subtitle text-sm">Pembayaran Aman</p>
                        <p class="st-muted text-xs mt-1">Diproses melalui sistem pembayaran.</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="st-icon-orange shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg></div>
                    <div>
                        <p class="st-subtitle text-sm">Cek Pesanan</p>
                        <p class="st-muted text-xs mt-1">Pastikan data benar sebelum bayar.</p>
                    </div>
                </div>
            </div>
        </aside>

    </section>

</main>
@endsection
