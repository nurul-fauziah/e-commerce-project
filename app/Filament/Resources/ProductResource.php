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

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip'; // Icon Tech

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
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),

                                Forms\Components\RichEditor::make('about')
                                    ->required()
                                    ->columnSpanFull(),
                            ])->columnSpan(2),

                        Section::make('Pricing & Inventory')
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

                Section::make('Media & Categorization')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\Select::make('category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Forms\Components\Select::make('brand_id')
                                ->relationship('brand', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->directory('products')
                            ->required(),
                    ]),

                Section::make('Product Variants & Gallery')
                    ->schema([
                        Forms\Components\Repeater::make('variants')
                            ->relationship('variants')
                            ->schema([
                                Forms\Components\TextInput::make('variant_name')
                                    ->placeholder('e.g. RAM, Storage')
                                    ->required(),
                                Forms\Components\TextInput::make('variant_value')
                                    ->placeholder('e.g. 16GB, 512GB SSD')
                                    ->required(),
                            ])->columns(2),

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
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->rounded(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->description(fn (Product $record): string => $record->brand->name),
                Tables\Columns\TextColumn::make('category.name')
                    ->badge(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_popular')
                    ->boolean()
                    ->label('Popular'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}