<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestTransactions extends BaseWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Latest Transactions';

    protected static ?string $description = 'Monitoring transaksi terbaru customer secara real-time.';

    protected static ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ProductTransaction::query()->latest()
            )
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(10)
            ->paginated([10, 25, 50])
            ->columns([
                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Transaction ID copied')
                    ->copyMessageDuration(1500)
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->limit(24),

                Tables\Columns\TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->weight('medium')
                    ->limit(28)
                    ->description(fn (ProductTransaction $record): string => $record->created_at
                        ? 'Created ' . $record->created_at->diffForHumans()
                        : 'Date unavailable'
                    ),

                Tables\Columns\TextColumn::make('grand_total_amount')
                    ->label('Order Value')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->color(fn (?string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'shipped' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (?string $state): string => match ($state) {
                        'pending' => 'heroicon-m-clock',
                        'paid' => 'heroicon-m-check-circle',
                        'shipped' => 'heroicon-m-truck',
                        'completed' => 'heroicon-m-check-badge',
                        'cancelled' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'pending' => 'Pending Payment',
                        'paid' => 'Paid',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        default => ucfirst($state ?? 'Unknown'),
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Transaction Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Age')
                    ->since()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending Payment',
                        'paid' => 'Paid',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\Filter::make('today')
                    ->label('Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),

                Tables\Filters\Filter::make('this_week')
                    ->label('This Week')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereBetween('created_at', [
                            now()->startOfWeek(),
                            now()->endOfWeek(),
                        ])),

                Tables\Filters\Filter::make('this_month')
                    ->label('This Month')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)),
            ])
            ->emptyStateHeading('No transactions yet')
            ->emptyStateDescription('Transaksi customer akan muncul di sini setelah checkout.')
            ->emptyStateIcon('heroicon-o-shopping-cart');
    }
}
