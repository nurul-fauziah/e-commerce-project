<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionStats extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $successfulStatuses = ['paid', 'shipped', 'completed'];

        $totalRevenue = ProductTransaction::whereIn('status', $successfulStatuses)
            ->sum('grand_total_amount');

        $monthlyRevenue = ProductTransaction::whereIn('status', $successfulStatuses)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('grand_total_amount');

        $totalOrders = ProductTransaction::count();

        $pendingOrders = ProductTransaction::where('status', 'pending')->count();

        $completedOrders = ProductTransaction::where('status', 'completed')->count();

        $paidOrders = ProductTransaction::where('status', 'paid')->count();

        $successRate = $totalOrders > 0
            ? round(($completedOrders / $totalOrders) * 100)
            : 0;

        return [
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Akumulasi transaksi berhasil')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([7, 12, 9, 16, 20, 18, 24]),

            Stat::make('Revenue Bulan Ini', 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'))
                ->description('Pendapatan pada bulan ' . now()->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info')
                ->chart([4, 8, 10, 14, 13, 18, 22]),

            Stat::make('Total Orders', number_format($totalOrders, 0, ',', '.'))
                ->description('Seluruh pesanan yang masuk')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('gray'),

            Stat::make('Pending Orders', number_format($pendingOrders, 0, ',', '.'))
                ->description('Menunggu pembayaran')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Paid Orders', number_format($paidOrders, 0, ',', '.'))
                ->description('Pembayaran terverifikasi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Success Rate', $successRate . '%')
                ->description('Pesanan yang selesai')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($successRate >= 50 ? 'success' : 'warning'),
        ];
    }
}
