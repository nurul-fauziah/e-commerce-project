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
use Illuminate\Database\Eloquent\Builder;

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

                    // STEP 1: KERANJANG BELANJA (MULTI-ITEM REPEATER)
                    Forms\Components\Wizard\Step::make('Order Items')
                        ->icon('heroicon-o-shopping-bag')
                        ->schema([
                            Forms\Components\Repeater::make('transactionDetails')
                                ->relationship('transactionDetails') // Terhubung ke fungsi relasi di Model
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
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
                                            ->placeholder('e.g. RAM 16GB, 512GB SSD')
                                            ->required(),

                                        Forms\Components\TextInput::make('quantity')
                                            ->numeric()
                                            ->default(1)
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                                $set('subtotal', ($get('price') ?? 0) * $state);
                                            }),

                                        Forms\Components\TextInput::make('price')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('Rp'),

                                        Forms\Components\TextInput::make('subtotal')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('Rp'),
                                    ])
                                ])
                                ->live() // Bikin Repeater Live agar kita bisa ngitung Grand Total di Step selanjutnya
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    // Hitung total semua item di keranjang
                                    $subTotalAmount = 0;
                                    foreach ((array) $state as $item) {
                                        $subTotalAmount += $item['subtotal'] ?? 0;
                                    }
                                    $set('sub_total_amount', $subTotalAmount);

                                    // Hitung Grand Total dikurangi diskon
                                    $discount = $get('discount_amount') ?? 0;
                                    $set('grand_total_amount', $subTotalAmount - $discount);
                                })
                                ->columns(1),
                        ]),

                    // STEP 2: SUMMARY & DISKON
                    Forms\Components\Wizard\Step::make('Summary & Promo')
                        ->icon('heroicon-o-banknotes')
                        ->schema([
                            Forms\Components\Select::make('st_promo_code_id')
                                ->relationship('promoCode', 'code')
                                ->label('Apply Promo Code')
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $promo = PromoCode::find($state);
                                    $discount = $promo ? $promo->discount_amount : 0;
                                    $set('discount_amount', $discount);

                                    $subTotal = $get('sub_total_amount') ?? 0;
                                    $set('grand_total_amount', $subTotal - $discount);
                                }),

                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('sub_total_amount')
                                    ->readOnly()
                                    ->prefix('Rp')
                                    ->numeric(),

                                Forms\Components\TextInput::make('discount_amount')
                                    ->readOnly()
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->default(0),

                                Forms\Components\TextInput::make('grand_total_amount')
                                    ->readOnly()
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->extraAttributes(['class' => 'font-black text-success-600']),
                            ]),
                        ]),

                    // STEP 3: DATA PELANGGAN & BUKTI BAYAR
                    Forms\Components\Wizard\Step::make('Customer Details')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('booking_trx_id')
                                    ->label('Transaction ID')
                                    ->default(fn () => ProductTransaction::generateUniqueCode())
                                    ->readOnly()
                                    ->required(),

                                // INI TAMBAHANNYA: Agar tidak error 1364 user_id
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->label('Customer Account')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\TextInput::make('name')->required(),
                                Forms\Components\TextInput::make('phone')->tel()->required(),
                                Forms\Components\TextInput::make('email')->email()->required(),
                                Forms\Components\TextInput::make('city')->required(),
                                Forms\Components\TextInput::make('post_code')->required(),
                                Forms\Components\Textarea::make('address')->required()->columnSpanFull(),
                                Forms\Components\FileUpload::make('proof')
                                    ->image()
                                    ->directory('payment_proofs'),
                                Forms\Components\Toggle::make('is_paid')
                                    ->label('Payment Verified')
                                    ->columnSpanFull(),
                            ]),
                        ]),
                ])->columnSpanFull()
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
                    ->searchable(),

                // MENAMPILKAN DAFTAR PRODUK YANG DIBELI (KARENA BISA LEBIH DARI 1)
                Tables\Columns\TextColumn::make('transactionDetails.product.name')
                    ->label('Hardware Purchased')
                    ->listWithLineBreaks() // Bikin itemnya baris berbaris (misal ada 3 barang)
                    ->limitList(2) // Kalo beli banyak, cuma tampilin 2, sisanya "... and 2 more"
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('grand_total_amount')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success'),

                Tables\Columns\TextColumn::make('is_paid')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'PAID' : 'PENDING')
                    ->color(fn (bool $state): string => $state ? 'success' : 'warning'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->label('Time'),
            ])
            ->defaultSort('created_at', 'desc') // Otomatis urutkan dari yang paling baru
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->color('success')
                    ->icon('heroicon-o-check-badge')
                    ->action(fn ($record) => $record->update(['is_paid' => true]))
                    ->visible(fn ($record) => !$record->is_paid),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(), // Tambahkan opsi View biar admin bisa lihat detail lengkapnya
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
