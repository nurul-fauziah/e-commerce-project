<?php

namespace App\Filament\Resources\ProductTransactionResource\Pages;

use App\Filament\Resources\ProductTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductTransaction extends EditRecord
{
    protected static string $resource = ProductTransactionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (in_array($data['status'] ?? null, ['paid', 'shipped', 'completed'])) {
            $data['is_paid'] = true;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('View Detail'),

            Actions\Action::make('cancel')
                ->label('Cancel Order')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->requiresConfirmation()
                ->modalHeading('Cancel this order?')
                ->modalDescription('Transaksi yang dibatalkan tidak dapat diproses ke tahap berikutnya.')
                ->modalSubmitActionLabel('Yes, cancel')
                ->action(function () {
                    $this->record->update([
                        'status' => 'cancelled',
                    ]);

                    $this->redirect($this->getResource()::getUrl('index'));
                })
                ->visible(fn () => ! in_array($this->record->status, ['completed', 'cancelled'])),
        ];
    }
}
