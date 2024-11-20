<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\AttributeValuesRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use PHPUnit\Framework\TestStatus\Risky;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-s-shopping-cart';

    protected static ?string $navigationLabel = 'Оборудование';

    protected static ?string $navigationGroup = 'Каталог';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('product_type_id')
                    ->label('Тип оборудования')
                    ->relationship('productType', 'name')
                    ->required()
                    ->createOptionForm(function (Form $form) {
                        return $form->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Название типа оборудования')
                                ->required(),
                        ]);
                    })
                    ->editOptionForm(function (Form $form) {
                        return $form->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Название типа оборудования')
                                ->required(),
                        ]);
                    }),
                Select::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->required()
                    ->createOptionForm(function (Form $form) {
                        return $form->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Название категории')
                                ->required(),
                            Select::make('product_type_id')
                                ->label('Тип оборудования')
                                ->relationship('productType', 'name')
                                ->required()
                        ]);
                    })
                    ->editOptionForm(function (Form $form) {
                        return $form->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Название категории')
                                ->required(),
                            Select::make('product_type_id')
                                ->label('Тип оборудования')
                                ->relationship('productType', 'name')
                                ->required()
                        ]);
                    }),
                TextInput::make('price')
                    ->label('Цена')
                    ->numeric(),
                TextInput::make('discount_price')
                    ->label('Скидочная цена')
                    ->numeric(),
                Toggle::make('is_new')
                    ->label('Новинка'),
                Toggle::make('is_hit_of_sales')
                    ->label('Хит продаж'),
                Toggle::make('is_active')
                    ->label('Активен'),
                FileUpload::make('images')
                    ->label('Изображения')
                    ->multiple()
                    ->image()
                    ->imageCropAspectRatio('1:1')
                    ->reorderable()
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->label('Описание')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'underline',
                        'redo',
                        'undo',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images')
                    ->label('Изображение')
                    ->limit(2),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('productType.name')
                    ->label('Тип оборудования')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->dateTime()
                    ->sortable()
                    ->numeric()
                    ->default('По запросу')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('discount_price')
                    ->label('Скидочная цена')
                    ->dateTime()
                    ->sortable()
                    ->numeric()
                    ->default('Отсутствует')
                    ->toggleable(isToggledHiddenByDefault: false),
                ToggleColumn::make('is_new')
                    ->label('Новинка')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                ToggleColumn::make('is_hit_of_sales')
                    ->label('Хит продаж')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                ToggleColumn::make('is_active')
                    ->label('Активен')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('productType')
                    ->label('Тип оборудования')
                    ->relationship('productType', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('category')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AttributeValuesRelationManager::class
        ];
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
