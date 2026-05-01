<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\ProductTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OperationalHealth extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $todayOrders = ProductTransaction::whereDate('created_at', today())->count();

        $todayRevenue = ProductTransaction::whereIn('status', ['paid', 'shipped', 'completed'])
            ->whereDate('created_at', today())
            ->sum('grand_total_amount');

        $pendingPayments = ProductTransaction::where('status', 'pending')->count();

        $readyToShip = ProductTransaction::where('status', 'paid')->count();

        $inDelivery = ProductTransaction::where('status', 'shipped')->count();

        $lowStockProducts = Product::where('stock', '<=', 5)->count();

        return [
            Stat::make('Today Revenue', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description($todayOrders . ' orders today')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('Pending Payment', number_format($pendingPayments, 0, ',', '.'))
                ->description('Customer belum menyelesaikan pembayaran')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($pendingPayments > 0 ? 'warning' : 'success'),

            Stat::make('Ready to Ship', number_format($readyToShip, 0, ',', '.'))
                ->description('Pesanan sudah dibayar dan siap diproses')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color($readyToShip > 0 ? 'info' : 'gray'),

            Stat::make('In Delivery', number_format($inDelivery, 0, ',', '.'))
                ->description('Pesanan sedang dikirim')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),

            Stat::make('Low Stock Products', number_format($lowStockProducts, 0, ',', '.'))
                ->description('Produk dengan stok 5 atau kurang')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockProducts > 0 ? 'danger' : 'success'),
        ];
    }
}
