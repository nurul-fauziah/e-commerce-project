<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExecutiveStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $successfulStatuses = ['paid', 'shipped', 'completed'];

        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();

        $lastMonthStart = now()->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd = now()->subMonthNoOverflow()->endOfMonth();

        $totalRevenue = ProductTransaction::whereIn('status', $successfulStatuses)
            ->sum('grand_total_amount');

        $thisMonthRevenue = ProductTransaction::whereIn('status', $successfulStatuses)
            ->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])
            ->sum('grand_total_amount');

        $lastMonthRevenue = ProductTransaction::whereIn('status', $successfulStatuses)
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->sum('grand_total_amount');

        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
            : ($thisMonthRevenue > 0 ? 100 : 0);

        $totalOrders = ProductTransaction::count();

        $successfulOrders = ProductTransaction::whereIn('status', $successfulStatuses)->count();

        $pendingOrders = ProductTransaction::where('status', 'pending')->count();

        $cancelledOrders = ProductTransaction::where('status', 'cancelled')->count();

        $successRate = $totalOrders > 0
            ? round(($successfulOrders / $totalOrders) * 100)
            : 0;

        $averageOrderValue = $successfulOrders > 0
            ? round($totalRevenue / $successfulOrders)
            : 0;

        $last7DaysRevenue = collect(range(6, 0))
            ->map(function ($day) use ($successfulStatuses) {
                return ProductTransaction::whereIn('status', $successfulStatuses)
                    ->whereDate('created_at', now()->subDays($day)->toDateString())
                    ->sum('grand_total_amount');
            })
            ->toArray();

        $last7DaysOrders = collect(range(6, 0))
            ->map(function ($day) {
                return ProductTransaction::whereDate('created_at', now()->subDays($day)->toDateString())
                    ->count();
            })
            ->toArray();

        return [
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('All-time confirmed revenue')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart($last7DaysRevenue),

            Stat::make('Monthly Revenue', 'Rp ' . number_format($thisMonthRevenue, 0, ',', '.'))
                ->description(
                    $revenueGrowth >= 0
                        ? '+' . $revenueGrowth . '% vs last month'
                        : $revenueGrowth . '% vs last month'
                )
                ->descriptionIcon(
                    $revenueGrowth >= 0
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                )
                ->color($revenueGrowth >= 0 ? 'success' : 'danger')
                ->chart($last7DaysRevenue),

            Stat::make('Total Orders', number_format($totalOrders, 0, ',', '.'))
                ->description($successfulOrders . ' successful orders')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info')
                ->chart($last7DaysOrders),

            Stat::make('Average Order Value', 'Rp ' . number_format($averageOrderValue, 0, ',', '.'))
                ->description('Average value per successful order')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('gray'),

            Stat::make('Success Rate', $successRate . '%')
                ->description('Successful orders ratio')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($successRate >= 70 ? 'success' : ($successRate >= 40 ? 'warning' : 'danger')),

            Stat::make('Pending Orders', number_format($pendingOrders, 0, ',', '.'))
                ->description('Need payment confirmation')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Cancelled Orders', number_format($cancelledOrders, 0, ',', '.'))
                ->description('Failed or cancelled transactions')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
