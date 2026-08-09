@props([
    'current' => 'cart',
])

@php
    $steps = [
        'cart' => [
            'number' => '1',
            'title' => 'Cart',
            'desc' => 'Review item',
        ],
        'review' => [
            'number' => '2',
            'title' => 'Review',
            'desc' => 'Cek pesanan',
        ],
        'shipping' => [
            'number' => '3',
            'title' => 'Shipping',
            'desc' => 'Data pengiriman',
        ],
        'payment' => [
            'number' => '4',
            'title' => 'Payment',
            'desc' => 'Pembayaran',
        ],
        'finished' => [
            'number' => '5',
            'title' => 'Done',
            'desc' => 'Status pesanan',
        ],
    ];

    $keys = array_keys($steps);
    $currentIndex = array_search($current, $keys);
@endphp

<div class="mb-6 grid gap-3 md:grid-cols-5">
    @foreach($steps as $key => $step)
        @php
            $stepIndex = array_search($key, $keys);
            $isDone = $stepIndex < $currentIndex;
            $isActive = $stepIndex === $currentIndex;
        @endphp

        <div class="st-step {{ $isDone ? 'st-step-done' : '' }} {{ $isActive ? 'st-step-active' : '' }}">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $isDone ? 'bg-emerald-600 text-white' : ($isActive ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500') }} font-black">
                {!! $isDone ? '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>' : $step['number'] !!}
            </span>

            <div class="min-w-0">
                <p class="truncate text-sm font-black">
                    {{ $step['title'] }}
                </p>
                <p class="truncate text-xs {{ $isActive || $isDone ? 'opacity-80' : 'text-slate-500' }}">
                    {{ $step['desc'] }}
                </p>
            </div>
        </div>
    @endforeach
</div>
