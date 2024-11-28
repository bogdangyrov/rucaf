<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Attribute;
use Filament\Tables\Table;
use App\Models\ProductType;
use App\Models\QuickFilter;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\QuickFilterResource\Pages;

class QuickFilterResource extends Resource
{
    protected static ?string $model = QuickFilter::class;

    protected static ?string $navigationIcon = 'heroicon-c-arrow-top-right-on-square';

    protected static ?string $navigationLabel = 'Быстрые фильтры';

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
                    ->reactive()
                    ->required(),
                Select::make('attribute_id')
                    ->label('Характеристика')
                    ->options(function ($get) {
                        $productTypeId = $get('product_type_id');
                        if ($productTypeId) {
                            $values = ProductType::find($productTypeId)->attributes()->get()->pluck('name', 'id');
                            return $values;
                        } else {
                            return [];
                        }
                    })
                    ->reactive()
                    ->required(),
                Select::make('value_id')
                    ->label('Значение')
                    ->reactive()
                    ->options(function ($get) {
                        $attributeId = $get('attribute_id');
                        if ($attributeId) {
                            $values = Attribute::find($attributeId)->values()->get()->pluck('value', 'id');
                            return $values;
                        } else {
                            return [];
                        }
                    })
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название фильтра')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productType.name')
                    ->label("Тип оборудования")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attribute.name')
                    ->label('Характеристика')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value.value')
                    ->label('Значение')
                    ->numeric()
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuickFilters::route('/'),
            'create' => Pages\CreateQuickFilter::route('/create'),
            'edit' => Pages\EditQuickFilter::route('/{record}/edit'),
        ];
    }
}
