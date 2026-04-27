<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = ProductTransaction::where('status', 'paid')
            ->orWhere('status', 'completed')
            ->orWhere('status', 'shipped')
            ->sum('grand_total_amount');

        return [
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Total transaksi berhasil')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Total Orders', ProductTransaction::count())
                ->description('Semua transaksi')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),

            Stat::make('Pending Orders', ProductTransaction::where('status', 'pending')->count())
                ->description('Menunggu pembayaran')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Paid Orders', ProductTransaction::where('status', 'paid')->count())
                ->description('Pembayaran terverifikasi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
