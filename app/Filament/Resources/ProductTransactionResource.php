<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTransactionResource\Pages;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductTransactionResource extends Resource
{
    protected static ?string $model = ProductTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Sales Management';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Product Transactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Order Items')
                        ->icon('heroicon-o-shopping-bag')
                        ->schema([
                            Forms\Components\Repeater::make('transactionDetails')
                                ->relationship('transactionDetails')
                                ->schema([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\Select::make('st_product_id')
                                                ->relationship('product', 'name')
                                                ->label('Hardware Product')
                                                ->required()
                                                ->searchable()
                                                ->preload()
                                                ->live()
                                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                                    $product = Product::find($state);
                                                    $price = $product ? $product->price : 0;

                                                    $set('price', $price);
                                                    $set('subtotal', $price * ($get('quantity') ?? 1));
                                                }),

                                            Forms\Components\TextInput::make('variant_details')
                                                ->label('Variant Details')
                                                ->placeholder('Contoh: RAM 16GB, SSD 512GB')
                                                ->required(),

                                            Forms\Components\TextInput::make('quantity')
                                                ->label('Quantity')
                                                ->numeric()
                                                ->default(1)
                                                ->minValue(1)
                                                ->required()
                                                ->live()
                                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                                    $set('subtotal', ($get('price') ?? 0) * ($state ?? 1));
                                                }),

                                            Forms\Components\TextInput::make('price')
                                                ->label('Price')
                                                ->numeric()
                                                ->readOnly()
                                                ->prefix('Rp'),

                                            Forms\Components\TextInput::make('subtotal')
                                                ->label('Subtotal')
                                                ->numeric()
                                                ->readOnly()
                                                ->prefix('Rp'),
                                        ]),
                                ])
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $subTotalAmount = 0;

                                    foreach ((array) $state as $item) {
                                        $subTotalAmount += $item['subtotal'] ?? 0;
                                    }

                                    $discount = $get('discount_amount') ?? 0;

                                    $set('sub_total_amount', $subTotalAmount);
                                    $set('grand_total_amount', max($subTotalAmount - $discount, 0));
                                })
                                ->columns(1)
                                ->defaultItems(1)
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string => $state['variant_details'] ?? 'Order Item'),
                        ]),

                    Forms\Components\Wizard\Step::make('Summary & Promo')
                        ->icon('heroicon-o-banknotes')
                        ->schema([
                            Forms\Components\Select::make('st_promo_code_id')
                                ->relationship('promoCode', 'code')
                                ->label('Apply Promo Code')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $promo = PromoCode::find($state);
                                    $discount = $promo ? $promo->discount_amount : 0;
                                    $subTotal = $get('sub_total_amount') ?? 0;

                                    $set('discount_amount', $discount);
                                    $set('grand_total_amount', max($subTotal - $discount, 0));
                                }),

                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('sub_total_amount')
                                        ->label('Subtotal')
                                        ->readOnly()
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->default(0),

                                    Forms\Components\TextInput::make('discount_amount')
                                        ->label('Discount')
                                        ->readOnly()
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->default(0),

                                    Forms\Components\TextInput::make('grand_total_amount')
                                        ->label('Grand Total')
                                        ->readOnly()
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->default(0)
                                        ->extraAttributes([
                                            'class' => 'font-black text-success-600',
                                        ]),
                                ]),
                        ]),

                    Forms\Components\Wizard\Step::make('Customer Details')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('booking_trx_id')
                                        ->label('Transaction ID')
                                        ->default(fn () => ProductTransaction::generateUniqueCode())
                                        ->readOnly()
                                        ->required(),

                                    Forms\Components\Select::make('user_id')
                                        ->relationship('user', 'name')
                                        ->label('Customer Account')
                                        ->searchable()
                                        ->preload()
                                        ->required(),

                                    Forms\Components\TextInput::make('name')
                                        ->label('Customer Name')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('phone')
                                        ->label('Phone Number')
                                        ->tel()
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('email')
                                        ->label('Email Address')
                                        ->email()
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('city')
                                        ->label('City')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('post_code')
                                        ->label('Post Code')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\Textarea::make('address')
                                        ->label('Full Address')
                                        ->required()
                                        ->rows(4)
                                        ->columnSpanFull(),

                                    Forms\Components\FileUpload::make('proof')
                                        ->label('Payment Proof')
                                        ->image()
                                        ->imageEditor()
                                        ->directory('payment_proofs')
                                        ->visibility('public')
                                        ->columnSpanFull(),

                                    Forms\Components\Select::make('status')
                                        ->label('Order Status')
                                        ->options([
                                            'pending' => 'Pending',
                                            'paid' => 'Paid',
                                            'shipped' => 'Shipped',
                                            'completed' => 'Completed',
                                            'cancelled' => 'Cancelled',
                                        ])
                                        ->default('pending')
                                        ->required()
                                        ->native(false),

                                    Forms\Components\Toggle::make('is_paid')
                                        ->label('Payment Verified')
                                        ->helperText('Aktifkan jika pembayaran sudah diverifikasi.')
                                        ->columnSpanFull(),
                                ]),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->label('TRX ID')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('transactionDetails.product.name')
                    ->label('Hardware Purchased')
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

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => strtoupper($state ?? 'pending'))
                    ->color(fn (?string $state): string => match ($state) {
                        'paid' => 'success',
                        'shipped' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'warning',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_paid')
                    ->label('Paid')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->since()
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve Payment')
                    ->color('success')
                    ->icon('heroicon-o-check-badge')
                    ->requiresConfirmation()
                    ->modalHeading('Approve payment?')
                    ->modalDescription('Transaksi ini akan ditandai sebagai PAID.')
                    ->modalSubmitActionLabel('Yes, approve')
                    ->action(fn ($record) => $record->update([
                        'is_paid' => true,
                        'status' => 'paid',
                    ]))
                    ->visible(fn ($record) => !$record->is_paid),

                Tables\Actions\Action::make('ship')
                    ->label('Mark as Shipped')
                    ->color('info')
                    ->icon('heroicon-o-truck')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update([
                        'status' => 'shipped',
                    ]))
                    ->visible(fn ($record) => $record->status === 'paid'),

                Tables\Actions\Action::make('complete')
                    ->label('Complete Order')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update([
                        'status' => 'completed',
                    ]))
                    ->visible(fn ($record) => $record->status === 'shipped'),

                Tables\Actions\Action::make('cancel')
                    ->label('Cancel Order')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update([
                        'status' => 'cancelled',
                    ]))
                    ->visible(fn ($record) => ! in_array($record->status, ['completed', 'cancelled'])),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductTransactions::route('/'),
            'create' => Pages\CreateProductTransaction::route('/create'),
            'edit' => Pages\EditProductTransaction::route('/{record}/edit'),
        ];
    }
}
