<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'Shop Management';

    protected static ?int $navigationSort = 3; // atur urutan
    protected static ?string $navigationLabel = 'Products'; // optional rename

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Main Information')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),

                                Forms\Components\RichEditor::make('about')
                                    ->required()
                                    ->columnSpanFull(),
                            ])->columnSpan(2),

                        Section::make('Pricing & Inventory (Base)')
                            ->description('Harga dan stok dasar jika produk tidak memiliki varian khusus.')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR'),

                                Forms\Components\TextInput::make('stock')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Qty'),

                                Forms\Components\Toggle::make('is_popular')
                                    ->label('Featured Product')
                                    ->onIcon('heroicon-m-bolt')
                                    ->offIcon('heroicon-m-x-mark'),
                            ])->columnSpan(1),
                    ]),

                // TABEL SPESIFIKASI UMUM (JSON)
                Section::make('Technical Specifications')
                    ->description('Spesifikasi umum yang berlaku untuk semua varian produk ini.')
                    ->schema([
                        Forms\Components\KeyValue::make('specifications')
                            ->label('Tech Specs')
                            ->keyLabel('Spesifikasi (cth: Chipset, Garansi)')
                            ->valueLabel('Nilai (cth: Snapdragon 8 Gen 3, 2 Tahun)')
                            ->addActionLabel('Add New Spec')
                            ->reorderable(),
                    ]),

                Section::make('Media & Categorization')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\Select::make('st_category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Forms\Components\Select::make('st_brand_id')
                                ->relationship('brand', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->imageEditor()
                            ->directory('products')
                            ->required(),
                    ]),

                Section::make('Product Variants & Gallery')
                    ->schema([
                        Forms\Components\Repeater::make('variants')
                            ->relationship('variants')
                            ->schema([
                                Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('sku')
                                        ->label('SKU (Kode Barang)')
                                        ->required()
                                        ->unique(ignoreRecord: true),

                                    Forms\Components\TextInput::make('price')
                                        ->label('Harga Varian')
                                        ->numeric()
                                        ->prefix('IDR')
                                        ->required(),

                                    Forms\Components\TextInput::make('stock')
                                        ->label('Stok Varian')
                                        ->numeric()
                                        ->required(),
                                ]),

                                Forms\Components\KeyValue::make('attributes')
                                    ->label('Spesifikasi Varian (Pembeda Harga)')
                                    ->keyLabel('Jenis (cth: RAM)')
                                    ->valueLabel('Nilai (cth: 16GB DDR5)')
                                    ->addActionLabel('Tambah Atribut Varian')
                                    ->reorderable()
                                    ->required(),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['sku'] ?? 'New Variant')
                            ->collapsible()
                            ->defaultItems(1)
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('photos')
                            ->relationship('photos')
                            ->schema([
                                Forms\Components\FileUpload::make('photo')
                                    ->image()
                                    ->required(),
                            ])->grid(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->rounded(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Product $record): string => "Brand: {$record->brand->name}"),
                Tables\Columns\TextColumn::make('category.name')->badge()->color('info'),

                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('stock')
                    ->badge()
                    ->color(fn ($state) =>
                        $state < 5 ? 'danger' : ($state < 10 ? 'warning' : 'success')
                    ),
                Tables\Columns\IconColumn::make('is_popular')->boolean()->label('Popular'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('st_category_id')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduct::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
