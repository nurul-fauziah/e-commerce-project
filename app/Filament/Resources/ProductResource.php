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

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(3)
                    ->schema([

                        Section::make('Main Information')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Product Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('slug', Str::slug($state));
                                    }),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\RichEditor::make('about')
                                    ->label('Product Description')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(2),

                        Section::make('Pricing & Inventory')
                            ->description('Harga dan stok dasar jika produk tidak memiliki varian khusus.')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Base Price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR'),

                                Forms\Components\TextInput::make('stock')
                                    ->label('Base Stock')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('Qty'),

                                Forms\Components\Toggle::make('is_popular')
                                    ->label('Featured Product')
                                    ->onIcon('heroicon-m-bolt')
                                    ->offIcon('heroicon-m-x-mark'),
                            ])
                            ->columnSpan(1),
                    ]),

                Section::make('Technical Specifications')
                    ->description('Spesifikasi umum yang berlaku untuk semua varian produk ini.')
                    ->schema([
                        Forms\Components\KeyValue::make('specifications')
                            ->label('Tech Specs')
                            ->keyLabel('Spesifikasi')
                            ->valueLabel('Nilai')
                            ->addActionLabel('Add New Spec')
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Media & Categorization')
                    ->schema([

                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('st_category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('st_brand_id')
                                    ->label('Brand')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Product Thumbnail')
                            ->image()
                            ->disk('public')
                            ->directory('products/thumbnails')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->imagePreviewHeight('200')
                            ->loadingIndicatorPosition('left')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->required(),
                    ]),

                Section::make('Product Variants & Gallery')
                    ->schema([

                        Forms\Components\Repeater::make('variants')
                            ->relationship('variants')
                            ->schema([

                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('sku')
                                            ->label('SKU')
                                            ->placeholder('Contoh: IPHONE-16-128-BLACK')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('price')
                                            ->label('Variant Price')
                                            ->numeric()
                                            ->prefix('IDR')
                                            ->required(),

                                        Forms\Components\TextInput::make('stock')
                                            ->label('Variant Stock')
                                            ->numeric()
                                            ->minValue(0)
                                            ->required(),
                                    ]),

                                Forms\Components\KeyValue::make('attributes')
                                    ->label('Variant Attributes')
                                    ->keyLabel('Jenis')
                                    ->valueLabel('Nilai')
                                    ->addActionLabel('Tambah Atribut Varian')
                                    ->reorderable()
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['sku'] ?? 'New Variant')
                            ->collapsible()
                            ->defaultItems(1)
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('photos')
                            ->relationship('photos')
                            ->label('Product Gallery')
                            ->schema([
                                Forms\Components\FileUpload::make('photo')
                                    ->label('Gallery Photo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('products/gallery')
                                    ->visibility('public')
                                    ->maxSize(2048)
                                    ->imagePreviewHeight('150')
                                    ->loadingIndicatorPosition('left')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->required(),
                            ])
                            ->grid(3)
                            ->collapsible()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Image')
                    ->disk('public')
                    ->rounded()
                    ->size(55),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(function (Product $record): string {
                        return $record->brand
                            ? 'Brand: ' . $record->brand->name
                            : 'Brand: -';
                    }),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Base Price')
                    ->money('IDR')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->badge()
                    ->sortable()
                    ->color(function ($state) {
                        if ($state < 5) {
                            return 'danger';
                        }

                        if ($state < 10) {
                            return 'warning';
                        }

                        return 'success';
                    }),

                Tables\Columns\IconColumn::make('is_popular')
                    ->label('Popular')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('st_category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('st_brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
