<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue Overview';

    protected static ?string $description = 'Pendapatan harian dari transaksi berhasil bulan ini.';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $successfulStatuses = ['paid', 'shipped', 'completed'];

        $days = collect(range(1, now()->daysInMonth));

        $revenue = $days->map(function ($day) use ($successfulStatuses) {
            $date = Carbon::create(now()->year, now()->month, $day)->toDateString();

            return ProductTransaction::whereIn('status', $successfulStatuses)
                ->whereDate('created_at', $date)
                ->sum('grand_total_amount');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $revenue->toArray(),
                    'borderWidth' => 3,
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => $days->map(fn ($day) => (string) $day)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
