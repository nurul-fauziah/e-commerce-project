<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTransactionResource\Pages;
use App\Models\ProductTransaction;
use App\Models\Product;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Product Selection')
                        ->icon('heroicon-o-device-phone-mobile')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                // 1. Ubah jadi st_product_id
                                Forms\Components\Select::make('st_product_id')
                                    ->relationship('product', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $product = Product::find($state);
                                        $price = $product ? $product->price : 0;

                                        // price_per_item ini cuma buat helper di form aja
                                        $set('price_per_item', $price);

                                        $qty = $get('quantity') ?? 1;
                                        $subtotal = $price * $qty;
                                        $set('sub_total_amount', $subtotal);

                                        $discount = $get('discount_amount') ?? 0;
                                        $set('grand_total_amount', $subtotal - $discount);
                                    }),

                                Forms\Components\TextInput::make('variant_details')
                                    ->placeholder('e.g. RAM 16GB, Midnight Black')
                                    ->required(),

                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $price = $get('price_per_item') ?? 0;
                                        $subtotal = $price * $state;
                                        $set('sub_total_amount', $subtotal);
                                        $set('grand_total_amount', $subtotal - ($get('discount_amount') ?? 0));
                                    }),

                                Forms\Components\Select::make('st_promo_code_id')
                                    ->relationship('promoCode', 'code')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $promo = PromoCode::find($state);
                                        $discount = $promo ? $promo->discount_amount : 0;
                                        $set('discount_amount', $discount);
                                        $set('grand_total_amount', $get('sub_total_amount') - $discount);
                                    }),
                            ]),
                        ]),

                    Forms\Components\Wizard\Step::make('Summary')
                        ->icon('heroicon-o-banknotes')
                        ->schema([
                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('sub_total_amount')->readOnly()->prefix('IDR'),
                                Forms\Components\TextInput::make('discount_amount')->readOnly()->prefix('IDR'),
                                Forms\Components\TextInput::make('grand_total_amount')->readOnly()->prefix('IDR')->extraAttributes(['class' => 'font-bold text-success-600']),
                            ]),
                        ]),

                    Forms\Components\Wizard\Step::make('Customer & Payment')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                // 2. Tambahin st_booking_trx_id biar kegenerate otomatis tapi nggak bisa diedit
                                Forms\Components\TextInput::make('st_booking_trx_id')
                                    ->label('Transaction ID')
                                    ->default(fn () => ProductTransaction::generateUniqueCode())
                                    ->readOnly()
                                    ->required(),

                                Forms\Components\TextInput::make('name')->required(),
                                Forms\Components\TextInput::make('phone')->tel()->required(),
                                Forms\Components\TextInput::make('email')->email()->required(),
                                Forms\Components\TextInput::make('city')->required(),
                                Forms\Components\Textarea::make('address')->required()->columnSpanFull(),
                                Forms\Components\FileUpload::make('proof')->image()->required(),
                                Forms\Components\Toggle::make('is_paid')->label('Payment Verified')->columnSpanFull(),
                            ]),
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 3. Ubah jadi st_booking_trx_id biar datanya muncul
                Tables\Columns\TextColumn::make('st_booking_trx_id')
                    ->label('TRX ID')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->description(fn ($record) => "Variant: {$record->variant_details}"),
                Tables\Columns\TextColumn::make('grand_total_amount')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success'),
                Tables\Columns\TextColumn::make('is_paid')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'PAID' : 'PENDING')
                    ->color(fn (bool $state): string => $state ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->since()->label('Time'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->color('success')
                    ->icon('heroicon-o-check-badge')
                    ->action(fn ($record) => $record->update(['is_paid' => true]))
                    ->visible(fn ($record) => !$record->is_paid),
                Tables\Actions\EditAction::make(),
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
