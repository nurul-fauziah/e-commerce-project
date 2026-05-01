<?php

namespace App\Filament\Resources\ProductTransactionResource\Widgets;

use App\Models\ProductTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductTransactionStats extends BaseWidget
{
    protected function getStats(): array
    {
        $pendingOrders = ProductTransaction::query()
            ->where('status', 'pending')
            ->count();

        $paidOrders = ProductTransaction::query()
            ->where('status', 'paid')
            ->count();

        $shippedOrders = ProductTransaction::query()
            ->where('status', 'shipped')
            ->count();

        $completedOrders = ProductTransaction::query()
            ->where('status', 'completed')
            ->count();

        $cancelledOrders = ProductTransaction::query()
            ->where('status', 'canceled')
            ->count();

        $totalRevenue = ProductTransaction::query()
            ->whereIn('status', ['paid', 'shipped', 'completed'])
            ->sum('grand_total_amount');

        return [
            Stat::make('Pending Orders', $pendingOrders)
                ->description('Menunggu verifikasi pembayaran')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Paid Orders', $paidOrders)
                ->description('Pembayaran sudah diverifikasi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Shipped Orders', $shippedOrders)
                ->description('Pesanan sedang dikirim')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),

            Stat::make('Completed Orders', $completedOrders)
                ->description('Pesanan sudah selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Cancelled Orders', $cancelledOrders)
                ->description('Transaksi dibatalkan')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Dari transaksi aktif')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
