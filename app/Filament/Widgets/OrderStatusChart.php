<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Order Status';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $pending = ProductTransaction::where('status', 'pending')->count();
        $paid = ProductTransaction::where('status', 'paid')->count();
        $shipped = ProductTransaction::where('status', 'shipped')->count();
        $completed = ProductTransaction::where('status', 'completed')->count();
        $cancelled = ProductTransaction::where('status', 'cancelled')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => [
                        $pending,
                        $paid,
                        $shipped,
                        $completed,
                        $cancelled,
                    ],
                ],
            ],
            'labels' => [
                'Pending',
                'Paid',
                'Shipped',
                'Completed',
                'Cancelled',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
