<!-- resources/views/order/payment.blade.php -->
@extends('layouts.front')

@section('title', 'Finalize Payment - SmartTech')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-24 text-center">
    <div class="bg-white border-8 border-black p-12 shadow-[20px_20px_0px_0px_#000]">
        <!-- PERBAIKAN: Gunakan booking_trx_id sesuai Model lo -->
        <span class="bg-black text-white px-4 py-1 font-bold uppercase text-[10px] tracking-widest mb-6 inline-block">
            Transaction_ID: #{{ $transaction->booking_trx_id }}
        </span>

        <h1 class="text-6xl font-black italic uppercase tracking-tighter mb-4 leading-none">Finalize <br> <span class="bg-[#C5F277] px-2">Payment</span></h1>

        <!-- PERBAIKAN: Gunakan grand_total_amount sesuai Model lo -->
        <p class="text-2xl font-bold mb-10 opacity-60 uppercase">
            Total Amount: Rp {{ number_format($transaction->grand_total_amount, 0, ',', '.') }}
        </p>

        <!-- Tombol Bayar -->
        <button id="pay-button" class="w-full bg-[#C5F277] text-black py-8 font-black italic uppercase text-3xl border-4 border-black shadow-[10px_10px_0px_0px_#000] hover:bg-black hover:text-white transition-all active:scale-95">
            Pay_Now_Via_Gateway
        </button>

        <p class="mt-8 text-xs font-bold opacity-40 uppercase tracking-[0.3em]">Secured_By_SmartTech_Encryption</p>
    </div>
</div>
@endsection

@push('after-scripts')
    <!-- Script Midtrans Snap (Sandbox) -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // snapToken dikirim dari Controller lewat compact()
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    /* Redirect ke halaman sukses setelah bayar */
                    window.location.href = "{{ route('front.order_finished', $transaction->id) }}";
                },
                onPending: function (result) {
                    /* Redirect ke halaman sukses/pending */
                    window.location.href = "{{ route('front.order_finished', $transaction->id) }}";
                },
                onError: function (result) {
                    alert("Payment failed! Please try again.");
                    console.log(result);
                },
                onClose: function () {
                    alert('You closed the popup without finishing the payment');
                }
            });
        });
    </script>
@endpush
