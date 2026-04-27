<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue This Month';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $days = collect(range(1, now()->daysInMonth));

        $revenue = $days->map(function ($day) {
            return ProductTransaction::whereIn('status', ['paid', 'shipped', 'completed'])
                ->whereDate('created_at', Carbon::create(now()->year, now()->month, $day))
                ->sum('grand_total_amount');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $revenue->toArray(),
                ],
            ],
            'labels' => $days->map(fn ($day) => (string) $day)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
