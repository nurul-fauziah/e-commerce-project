<?php

namespace App\Filament\Resources\ProductTransactionResource\Pages;

use App\Filament\Resources\ProductTransactionResource;
use App\Filament\Resources\ProductTransactionResource\Widgets\ProductTransactionStats;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductTransactions extends ListRecords
{
    protected static string $resource = ProductTransactionResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            ProductTransactionStats::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->url(ProductTransactionResource::getUrl('index')),
        ];
    }
}
