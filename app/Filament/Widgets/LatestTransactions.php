<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTransactions extends BaseWidget
{
    protected static ?string $heading = 'Latest Transactions';

    protected static ?string $description = 'Daftar transaksi terbaru dari customer.';

    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ProductTransaction::query()
                    ->latest()
            )
            ->defaultPaginationPageOption(5)
            ->paginated([5, 10, 25])
            ->columns([
                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->label('TRX ID')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Transaction ID copied')
                    ->copyMessageDuration(1500)
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->limit(18),

                Tables\Columns\TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->weight('medium')
                    ->limit(22),

                Tables\Columns\TextColumn::make('grand_total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'paid' => 'success',
                        'shipped' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn (?string $state): string => match ($state) {
                        'paid' => 'heroicon-m-check-circle',
                        'shipped' => 'heroicon-m-truck',
                        'completed' => 'heroicon-m-check-badge',
                        'cancelled' => 'heroicon-m-x-circle',
                        'pending' => 'heroicon-m-clock',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'paid' => 'Paid',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'pending' => 'Pending',
                        default => ucfirst($state ?? 'Unknown'),
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->since()
                    ->color('gray'),
            ])
            ->emptyStateHeading('Belum ada transaksi')
            ->emptyStateDescription('Transaksi customer akan muncul di sini setelah checkout.')
            ->emptyStateIcon('heroicon-o-shopping-cart');
    }
}
