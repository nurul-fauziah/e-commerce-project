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
            <h2 class="st-title text-2xl mb-6">
                Bayar via Midtrans
            </h2>

            <div id="loading-gate" class="mb-6 hidden rounded-2xl border border-blue-100 bg-blue-50 p-5 text-center">
                <div class="mx-auto mb-3 h-8 w-8 animate-spin rounded-full border-4 border-blue-200 border-t-blue-600"></div>
                <p class="text-sm font-bold text-blue-800">
                    Menghubungkan ke payment gateway...
                </p>
            </div>

            <button type="button" id="pay-button" class="st-btn-accent w-full text-lg">
                Bayar Sekarang →
            </button>
        </div>

        <aside class="lg:sticky lg:top-28 h-fit">
            <div class="st-card p-6">

                <h3 class="st-title text-xl mb-5">
                    Ringkasan Transaksi
                </h3>

                <div class="space-y-4">

                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                                Invoice
                            </p>

                            <button type="button"
                                onclick="copyInvoiceNumber()"
                                class="rounded-full bg-white px-3 py-1 text-[11px] font-bold text-blue-600 ring-1 ring-blue-100 hover:bg-blue-50">
                                Copy
                            </button>
                        </div>

                        <p class="mt-2 font-mono text-sm font-black tracking-wide text-slate-950 break-words leading-relaxed">
                            #{{ $transaction->invoice_number }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-5">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            Total
                        </p>
                        <p class="mt-2 text-3xl font-black text-slate-950">
                            Rp {{ number_format($transaction->grand_total_amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-4 text-sm">
                        Status:
                        <strong class="
                            @if($transaction->status == 'paid') text-green-600
                            @elseif($transaction->status == 'pending') text-yellow-600
                            @else text-red-600
                            @endif
                        ">
                            {{ strtoupper($transaction->status) }}
                        </strong>
                    </div>

                </div>
            </div>
        </aside>

    </section>

</main>
@endsection

@push('after-scripts')
<script src="{{ config('midtrans.is_production')
    ? 'https://app.midtrans.com/snap/snap.js'
    : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const payButton = document.getElementById('pay-button');
    const loadingGate = document.getElementById('loading-gate');

    function resetButton() {
        payButton.classList.remove('hidden');
        loadingGate.classList.add('hidden');
    }

    payButton.addEventListener('click', function () {
        payButton.classList.add('hidden');
        loadingGate.classList.remove('hidden');

        if (!window.snap) {
            alert('Midtrans gagal dimuat');
            resetButton();
            return;
        }

        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('order.order_finished', $transaction->id) }}";
            },

            onPending: function(result) {
                window.location.href = "{{ route('order.order_finished', $transaction->id) }}";
            },

            onError: function(result) {
                alert('Pembayaran gagal');
                resetButton();
            },

            onClose: function() {
                alert('Kamu menutup pembayaran');
                resetButton();
            }
        });
    });
});

function copyInvoiceNumber() {
    navigator.clipboard.writeText('{{ $transaction->invoice_number }}');
    alert('Invoice berhasil disalin');
}
</script>
@endpush
