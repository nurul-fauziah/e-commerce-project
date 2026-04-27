<?php

namespace App\Filament\Widgets;

use App\Models\ProductTransaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTransactions extends BaseWidget
{
    protected static ?string $heading = 'Latest Transactions';

    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ProductTransaction::query()->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->label('TRX ID')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Customer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('grand_total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'paid' => 'success',
                        'shipped' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (?string $state): string => strtoupper($state ?? 'pending')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->since(),
            ]);
    }
}
