<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTransactionResource\Pages;
use App\Models\ProductTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductTransactionResource extends Resource
{
    protected static ?string $model = ProductTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Sales Management';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Product Transactions';
    protected static ?string $modelLabel = 'Product Transaction';
    protected static ?string $pluralModelLabel = 'Product Transactions';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $pendingCount = static::getModel()::query()
            ->where('status', 'pending')
            ->count();

        return $pendingCount > 0 ? (string) $pendingCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Transaction Summary')
                    ->description('Ringkasan utama transaksi customer.')
                    ->icon('heroicon-o-receipt-percent')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('booking_trx_id')
                                    ->label('Transaction ID')
                                    ->readOnly()
                                    ->required(),

                                Forms\Components\TextInput::make('grand_total_amount')
                                    ->label('Grand Total')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->readOnly(),

                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Transaction Time')
                                    ->content(fn (?ProductTransaction $record) => $record?->created_at
                                        ? $record->created_at->format('d M Y, H:i')
                                        : '-'),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('sub_total_amount')
                                    ->label('Subtotal')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->readOnly(),

                                Forms\Components\TextInput::make('discount_amount')
                                    ->label('Discount')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->readOnly(),

                                Forms\Components\TextInput::make('promoCode.code')
                                    ->label('Promo Code')
                                    ->readOnly()
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Section::make('Order Items')
                    ->description('Produk yang dibeli customer.')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        Forms\Components\Repeater::make('transactionDetails')
                            ->relationship('transactionDetails')
                            ->label('Purchased Products')
                            ->schema([
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\Select::make('st_product_id')
                                            ->relationship('product', 'name')
                                            ->label('Product')
                                            ->disabled()
                                            ->dehydrated(false),

                                        Forms\Components\TextInput::make('variant_details')
                                            ->label('Variant')
                                            ->readOnly(),

                                        Forms\Components\TextInput::make('quantity')
                                            ->label('Qty')
                                            ->numeric()
                                            ->readOnly(),

                                        Forms\Components\TextInput::make('price')
                                            ->label('Price')
                                            ->prefix('Rp')
                                            ->numeric()
                                            ->readOnly(),

                                        Forms\Components\TextInput::make('subtotal')
                                            ->label('Subtotal')
                                            ->prefix('Rp')
                                            ->numeric()
                                            ->readOnly()
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['variant_details'] ?? 'Order Item'),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Section::make('Customer Details')
                    ->description('Data customer dan alamat pengiriman.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->label('Customer Account')
                                    ->disabled()
                                    ->dehydrated(false),

                                Forms\Components\TextInput::make('name')
                                    ->label('Customer Name')
                                    ->readOnly(),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->readOnly(),

                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone')
                                    ->readOnly(),

                                Forms\Components\TextInput::make('city')
                                    ->label('City')
                                    ->readOnly(),

                                Forms\Components\TextInput::make('post_code')
                                    ->label('Post Code')
                                    ->readOnly(),

                                Forms\Components\Textarea::make('address')
                                    ->label('Full Address')
                                    ->rows(4)
                                    ->readOnly()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Section::make('Payment & Order Status')
                    ->description('Area kerja admin untuk verifikasi pembayaran dan update status pesanan.')
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        Forms\Components\FileUpload::make('proof')
                            ->label('Payment Proof')
                            ->image()
                            ->imageEditor()
                            ->directory('payment_proofs')
                            ->visibility('public')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_paid')
                                    ->label('Payment Verified')
                                    ->helperText('Aktifkan jika pembayaran customer sudah valid.')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $set('status', 'paid');
                                        }
                                    }),

                                Forms\Components\Select::make('status')
                                    ->label('Order Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'paid' => 'Paid',
                                        'shipped' => 'Shipped',
                                        'completed' => 'Completed',
                                        'canceled' => 'Cancelled',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if (in_array($state, ['paid', 'shipped', 'completed'])) {
                                            $set('is_paid', true);
                                        }
                                    })
                                    ->helperText('Alur normal: Pending → Paid → Shipped → Completed.'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Transaction Overview')
                    ->icon('heroicon-o-receipt-percent')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('booking_trx_id')
                            ->label('Transaction ID')
                            ->copyable()
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('grand_total_amount')
                            ->label('Grand Total')
                            ->money('IDR')
                            ->weight('bold')
                            ->color('success'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Transaction Time')
                            ->dateTime('d M Y, H:i'),
                    ]),

                Infolists\Components\Section::make('Payment Status')
                    ->icon('heroicon-o-credit-card')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->label('Order Status')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): string => strtoupper($state ?? 'pending'))
                            ->color(fn (?string $state): string => match ($state) {
                                'paid' => 'success',
                                'shipped' => 'info',
                                'completed' => 'success',
                                'canceled' => 'danger',
                                default => 'warning',
                            }),

                        Infolists\Components\IconEntry::make('is_paid')
                            ->label('Payment Verified')
                            ->boolean(),

                        Infolists\Components\TextEntry::make('promoCode.code')
                            ->label('Promo Code')
                            ->placeholder('-'),
                    ]),

                Infolists\Components\Section::make('Customer Information')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Customer Name'),

                        Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('phone')
                            ->label('Phone')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('city')
                            ->label('City'),

                        Infolists\Components\TextEntry::make('post_code')
                            ->label('Post Code'),

                        Infolists\Components\TextEntry::make('address')
                            ->label('Full Address')
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Purchased Products')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('transactionDetails')
                            ->label('Order Items')
                            ->schema([
                                Infolists\Components\TextEntry::make('product.name')
                                    ->label('Product')
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('variant_details')
                                    ->label('Variant'),

                                Infolists\Components\TextEntry::make('quantity')
                                    ->label('Qty'),

                                Infolists\Components\TextEntry::make('price')
                                    ->label('Price')
                                    ->money('IDR'),

                                Infolists\Components\TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->money('IDR')
                                    ->weight('bold'),
                            ])
                            ->columns(5),
                    ]),

                Infolists\Components\Section::make('Payment Proof')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Infolists\Components\ImageEntry::make('proof')
                            ->label('Proof Image')
                            ->disk('public')
                            ->height(300)
                            ->placeholder('No payment proof uploaded.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->columns([
                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->label('TRX ID')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Customer')
                    ->description(fn (ProductTransaction $record): ?string => $record->email)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('transactionDetails.product.name')
                    ->label('Products')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('grand_total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('promoCode.code')
                    ->label('Promo')
                    ->badge()
                    ->placeholder('-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Order Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => strtoupper($state ?? 'pending'))
                    ->color(fn (?string $state): string => match ($state) {
                        'paid' => 'success',
                        'shipped' => 'info',
                        'completed' => 'success',
                        'canceled' => 'danger',
                        default => 'warning',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_paid')
                    ->label('Paid')
                    ->boolean(),

                Tables\Columns\ImageColumn::make('proof')
                    ->label('Proof')
                    ->disk('public')
                    ->height(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Time')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Order Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                        'canceled' => 'Cancelled',
                    ]),

                Tables\Filters\TernaryFilter::make('is_paid')
                    ->label('Payment Verified')
                    ->trueLabel('Paid')
                    ->falseLabel('Unpaid'),

                Tables\Filters\Filter::make('created_at')
                    ->label('Order Date')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From'),

                        Forms\Components\DatePicker::make('created_until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-badge')
                    ->requiresConfirmation()
                    ->modalHeading('Approve payment?')
                    ->modalDescription('Transaksi ini akan ditandai sebagai PAID.')
                    ->modalSubmitActionLabel('Yes, approve')
                    ->action(fn (ProductTransaction $record) => $record->update([
                        'is_paid' => true,
                        'status' => 'paid',
                    ]))
                    ->visible(fn (ProductTransaction $record) => ! $record->is_paid && $record->status !== 'canceled'),

                Tables\Actions\Action::make('ship')
                    ->label('Ship')
                    ->color('info')
                    ->icon('heroicon-o-truck')
                    ->requiresConfirmation()
                    ->modalHeading('Mark order as shipped?')
                    ->modalDescription('Status transaksi akan berubah menjadi SHIPPED.')
                    ->modalSubmitActionLabel('Yes, ship order')
                    ->action(fn (ProductTransaction $record) => $record->update([
                        'status' => 'shipped',
                        'is_paid' => true,
                    ]))
                    ->visible(fn (ProductTransaction $record) => $record->status === 'paid'),

                Tables\Actions\Action::make('complete')
                    ->label('Complete')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Complete this order?')
                    ->modalDescription('Status transaksi akan berubah menjadi COMPLETED.')
                    ->modalSubmitActionLabel('Yes, complete')
                    ->action(fn (ProductTransaction $record) => $record->update([
                        'status' => 'completed',
                        'is_paid' => true,
                    ]))
                    ->visible(fn (ProductTransaction $record) => $record->status === 'shipped'),

                Tables\Actions\Action::make('cancel')
                    ->label('Cancel')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Cancel this order?')
                    ->modalDescription('Transaksi yang dibatalkan tidak dapat diproses ke tahap berikutnya.')
                    ->modalSubmitActionLabel('Yes, cancel')
                    ->action(fn (ProductTransaction $record) => $record->update([
                        'status' => 'canceled',
                    ]))
                    ->visible(fn (ProductTransaction $record) => ! in_array($record->status, ['completed', 'canceled'])),

                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make()
                    ->label('Manage'),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'user',
                'promoCode',
                'transactionDetails.product',
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductTransactions::route('/'),
            'view' => Pages\ViewProductTransaction::route('/{record}'),
            'edit' => Pages\EditProductTransaction::route('/{record}/edit'),
        ];
    }
}
