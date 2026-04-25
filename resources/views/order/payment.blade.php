@extends('layouts.front')

@section('title', 'Payment - SmartTech')

@section('content')
<main class="st-page-wrap">

    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">
            Secure Payment
        </span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4">
            Selesaikan Pembayaran
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Transaksi sudah dibuat. Klik tombol bayar untuk membuka Midtrans Sandbox dan pilih metode pembayaran.
        </p>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1fr_360px]">

        <div class="st-card p-6 md:p-8">
            <div class="mb-6">
                <h2 class="st-title text-2xl mb-2">
                    Bayar via Midtrans
                </h2>

                <p class="st-muted text-sm">
                    Untuk lokal/demo, pembayaran berjalan lewat Sandbox. Setelah sukses atau pending, kamu akan diarahkan ke halaman status pesanan.
                </p>
            </div>

            <div class="grid gap-3 md:grid-cols-3 mb-6">
                <div class="st-card-soft p-4">
                    <div class="st-icon-blue mb-3">QR</div>
                    <h3 class="st-subtitle text-sm">QRIS</h3>
                    <p class="st-muted text-xs mt-1">Scan dari mobile banking/e-wallet.</p>
                </div>

                <div class="st-card-soft p-4">
                    <div class="st-icon-orange mb-3">EW</div>
                    <h3 class="st-subtitle text-sm">E-Wallet</h3>
                    <p class="st-muted text-xs mt-1">Bayar cepat lewat saldo digital.</p>
                </div>

                <div class="st-card-soft p-4">
                    <div class="st-icon-green mb-3">VA</div>
                    <h3 class="st-subtitle text-sm">Virtual Account</h3>
                    <p class="st-muted text-xs mt-1">Transfer bank via virtual account.</p>
                </div>
            </div>

            <div id="loading-gate" class="mb-6 hidden rounded-2xl border border-blue-100 bg-blue-50 p-5 text-center">
                <div class="mx-auto mb-3 h-8 w-8 animate-spin rounded-full border-4 border-blue-200 border-t-blue-600"></div>
                <p class="text-sm font-bold text-blue-800">
                    Menghubungkan ke payment gateway...
                </p>
                <p class="mt-1 text-xs text-blue-700/70">
                    Jangan tutup halaman ini sampai popup pembayaran muncul.
                </p>
            </div>

            <button type="button" id="pay-button" class="st-btn-accent w-full text-base md:text-lg">
                Bayar Sekarang →
            </button>

            <p class="mt-4 text-center text-xs leading-5 text-slate-500">
                Untuk demo lokal, halaman success akan tetap terbuka dari response popup Midtrans.
            </p>
        </div>

        <aside class="lg:sticky lg:top-28 h-fit">
            <div class="st-card p-6">
                <span class="st-eyebrow">
                    Order Summary
                </span>

                <h3 class="st-title text-xl mt-4 mb-5">
                    Ringkasan Transaksi
                </h3>

                <div class="space-y-4">
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            Transaction ID
                        </p>
                        <p class="mt-1 font-black text-slate-950 break-all">
                            #{{ $transaction->booking_trx_id }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-5">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            Total Pembayaran
                        </p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-slate-950">
                            Rp {{ number_format($transaction->grand_total_amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm leading-6 text-emerald-800">
                        <strong class="block">Mode Sandbox</strong>
                        Aman untuk demo lokal. Tidak ada uang asli yang terpotong.
                    </div>

                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-xs leading-5 text-blue-800">
                        Pastikan nominal dan ID transaksi sesuai sebelum menyelesaikan pembayaran.
                    </div>
                </div>
            </div>
        </aside>

    </section>

</main>
@endsection

@push('after-scripts')
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const payButton = document.getElementById('pay-button');
            const loadingGate = document.getElementById('loading-gate');

            function resetButton() {
                payButton?.classList.remove('hidden');
                loadingGate?.classList.add('hidden');
            }

            if (!payButton) return;

            payButton.addEventListener('click', function () {
                payButton.classList.add('hidden');
                loadingGate.classList.remove('hidden');

                if (!window.snap) {
                    alert('Midtrans Snap gagal dimuat. Cek koneksi internet atau client key.');
                    resetButton();
                    return;
                }

                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function (result) {
                        window.location.href = "{{ route('order.order_finished', $transaction->id) }}";
                    },
                    onPending: function (result) {
                        window.location.href = "{{ route('order.order_finished', $transaction->id) }}";
                    },
                    onError: function (result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        resetButton();
                    },
                    onClose: function () {
                        alert('Popup pembayaran ditutup sebelum selesai.');
                        resetButton();
                    }
                });
            });
        });
    </script>
@endpush
