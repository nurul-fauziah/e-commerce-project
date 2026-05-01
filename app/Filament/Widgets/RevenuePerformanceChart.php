<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenuePerformanceChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Revenue Performance';

    protected static ?string $description = 'Revenue dan jumlah order berdasarkan transaksi berhasil.';

    protected static ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'xl' => 3,
    ];

    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            '7_days' => 'Last 7 Days',
            '30_days' => 'Last 30 Days',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }

    protected function getData(): array
    {
        $successfulStatuses = ['paid', 'shipped', 'completed'];

        $dates = match ($this->filter) {
            '7_days' => collect(range(6, 0))->map(fn ($day) => now()->subDays($day)),
            '30_days' => collect(range(29, 0))->map(fn ($day) => now()->subDays($day)),
            'year' => collect(range(1, 12))->map(fn ($month) => Carbon::create(now()->year, $month, 1)),
            default => collect(range(1, now()->daysInMonth))
                ->map(fn ($day) => Carbon::create(now()->year, now()->month, $day)),
        };

        if ($this->filter === 'year') {
            $revenue = $dates->map(function ($date) use ($successfulStatuses) {
                return ProductTransaction::whereIn('status', $successfulStatuses)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('grand_total_amount');
            });

            $orders = $dates->map(function ($date) use ($successfulStatuses) {
                return ProductTransaction::whereIn('status', $successfulStatuses)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            });

            $labels = $dates->map(fn ($date) => $date->format('M'));
        } else {
            $revenue = $dates->map(function ($date) use ($successfulStatuses) {
                return ProductTransaction::whereIn('status', $successfulStatuses)
                    ->whereDate('created_at', $date->toDateString())
                    ->sum('grand_total_amount');
            });

            $orders = $dates->map(function ($date) use ($successfulStatuses) {
                return ProductTransaction::whereIn('status', $successfulStatuses)
                    ->whereDate('created_at', $date->toDateString())
                    ->count();
            });

            $labels = $dates->map(fn ($date) => $date->format('d M'));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $revenue->toArray(),
                    'borderWidth' => 3,
                    'tension' => 0.35,
                    'fill' => true,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Orders',
                    'data' => $orders->toArray(),
                    'borderWidth' => 2,
                    'tension' => 0.35,
                    'fill' => false,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $labels->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,

            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],

            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],

            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'beginAtZero' => true,
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'beginAtZero' => true,
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
}
