<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\AttributeValuesRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Оборудование';

    protected static ?string $navigationGroup = 'Каталог';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
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
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
