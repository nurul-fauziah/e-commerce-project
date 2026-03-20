@extends('layouts.front')

@section('title', 'Finalize Payment - SmartTech')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-24 text-center">
    <div class="bg-white border-8 border-black p-12 shadow-[20px_20px_0px_0px_#000]">
        <span class="bg-black text-white px-4 py-1 font-bold uppercase text-[10px] tracking-widest mb-6 inline-block">
            Transaction_ID: #{{ $transaction->booking_trx_id }}
        </span>

        <h1 class="text-6xl font-black italic uppercase tracking-tighter mb-4 leading-none">
            Finalize <br> <span class="bg-[#C5F277] px-2">Payment</span>
        </h1>

        <p class="text-2xl font-bold mb-10 opacity-60 uppercase">
            Total Amount: Rp {{ number_format($transaction->grand_total_amount, 0, ',', '.') }}
        </p>

        <!-- Loading State Placeholder -->
        <div id="loading-gate" class="hidden mb-8">
            <p class="font-mono animate-pulse">Connecting_To_Gateway...</p>
        </div>

        <button id="pay-button" class="w-full bg-[#C5F277] text-black py-8 font-black italic uppercase text-3xl border-4 border-black shadow-[10px_10px_0px_0px_#000] hover:bg-black hover:text-white transition-all active:scale-95">
            Pay_Now_QRIS
        </button>

        <div class="mt-8 grid grid-cols-3 gap-4 opacity-30 grayscale">
             <!-- Visual branding QRIS/Gopay buat mempercantik UI Profesional -->
             <span class="text-[10px] font-bold border-2 border-black py-1">QRIS</span>
             <span class="text-[10px] font-bold border-2 border-black py-1">GOPAY</span>
             <span class="text-[10px] font-bold border-2 border-black py-1">V_ACCOUNT</span>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
    <!-- Pastikan URL script sesuai environment (sandbox/production) -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        const loadingGate = document.getElementById('loading-gate');

        payButton.addEventListener('click', function () {
            payButton.classList.add('hidden');
            loadingGate.classList.remove('hidden');

            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    window.location.href = "{{ route('order.order_finished', $transaction->id) }}";
                },
                onPending: function (result) {
                    window.location.href = "{{ route('order.order_finished', $transaction->id) }}";
                },
                onError: function (result) {
                    alert("Payment failed!");
                    payButton.classList.remove('hidden');
                    loadingGate.classList.add('hidden');
                },
                onClose: function () {
                    alert('You closed the popup without finishing the payment');
                    payButton.classList.remove('hidden');
                    loadingGate.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
