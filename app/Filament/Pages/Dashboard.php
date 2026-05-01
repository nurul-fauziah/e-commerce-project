<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestTransactions;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\TransactionStats;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    public function getHeading(): string
    {
        return 'SmartTech Dashboard';
    }

    public function getSubheading(): ?string
    {
        return 'Overview performa revenue, transaksi, dan order terbaru SmartTech Shop.';
    }

    public function getWidgets(): array
    {
        return [
            TransactionStats::class,
            RevenueChart::class,
            LatestTransactions::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return [
            'default' => 1,
            'md' => 2,
            'xl' => 3,
        ];
    }
}
