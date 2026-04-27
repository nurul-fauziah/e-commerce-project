<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Shop Management';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Promo Codes'; // optional rename
    protected static ?string $modelLabel = 'Promo Code';
    protected static ?string $pluralModelLabel = 'Promo Codes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Promo Details')
                    ->description('Atur kode promo dan nominal diskon.')
                    ->icon('heroicon-o-ticket')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Promo Code')
                            ->placeholder('Contoh: SMARTTECH2026')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rule('alpha_dash')
                            ->helperText('Gunakan huruf, angka, dash, atau underscore.'),

                        Forms\Components\TextInput::make('discount_amount')
                            ->label('Discount Amount')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('IDR'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Promo Code')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->copyable()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('discount_amount')
                    ->label('Discount')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('product_transactions_count')
                    ->counts('productTransactions')
                    ->label('Usage')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
            ])
            ->defaultSort('code')
            ->emptyStateHeading('Belum ada promo')
            ->emptyStateDescription('Tambahkan kode promo untuk diskon checkout.')
            ->emptyStateIcon('heroicon-o-ticket')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }
}
