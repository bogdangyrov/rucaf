<?php

namespace App\Filament\Resources\SubcategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Value;
use Filament\Forms\Form;
use App\Models\Attribute;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Информация')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Название')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TiptapEditor::make('description')
                                    ->label('Описание')
                                    ->required()
                                    ->columnSpanFull()
                                    ->profile('default'),
                                Forms\Components\TextInput::make('dimensions')
                                    ->label('Габариты ШхВхГ, мм')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('mass')
                                    ->label('Масса, кг')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Select::make('subcategory_id')
                                    ->label('Подкатегория')
                                    ->relationship('subcategory', 'name')
                                    ->required()
                                    ->createOptionForm(function (Form $form) {
                                        return $form->schema([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Название категории')
                                                ->required(),
                                            Select::make('category')
                                                ->label('Категория')
                                                ->relationship('category', 'name')
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
                            ]),
                        Tab::make('Файлы')
                            ->schema([
                                FileUpload::make('images')
                                    ->label('Изображения')
                                    ->multiple()
                                    ->image()
                                    ->reorderable()
                                    ->directory('products')
                                    ->columnSpanFull(),
                                FileUpload::make('docs')
                                    ->label('Документы')
                                    ->multiple()
                                    ->reorderable()
                                    ->directory('products')
                                    ->storeFileNamesIn('docs_file_names')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Цена')
                            ->schema([
                                TextInput::make('price')
                                    ->label('Цена')
                                    ->numeric(),
                                TextInput::make('discount_price')
                                    ->label('Скидочная цена')
                                    ->numeric(),

                            ]),
                        Tab::make('Статус')
                            ->schema([
                                Toggle::make('is_new')
                                    ->label('Новинка'),
                                Toggle::make('is_hit_of_sales')
                                    ->label('Хит продаж'),
                                Toggle::make('is_active')
                                    ->label('Активен'),
                            ]),
                        Tab::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('h1')
                                    ->label('H1')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('SEO title')
                                    ->maxLength(255),
                                Textarea::make('seo_description')
                                    ->label('SEO description')
                                    ->rows(3),
                                Forms\Components\TextInput::make('og_title')
                                    ->label('OG title')
                                    ->maxLength(255),
                                Textarea::make('og_description')
                                    ->label('OG description')
                                    ->rows(3),
                            ]),
                        Tab::make('Характеристики')
                            ->schema([
                                Repeater::make('attributeValues')
                                    ->label('Характеристики')
                                    ->relationship('attributeValues')
                                    ->schema([
                                        Select::make('attribute_id')
                                            ->label('Атрибут')
                                            ->options(function ($get, $record) {
                                                $subcategoryId = $record?->subcategory_id ?? $get('../../subcategory_id');
                                                if ($subcategoryId) {
                                                    return Attribute::where('subcategory_id', $subcategoryId)
                                                        ->orderBy('name')
                                                        ->pluck('name', 'id');
                                                }
                                                return [];
                                            })
                                            ->reactive()
                                            ->required(),
                                        Select::make('value_id')
                                            ->label('Значение')
                                            ->options(function ($get) {
                                                $attributeId = $get('attribute_id');
                                                if ($attributeId) {
                                                    return Value::where('attribute_id', $attributeId)
                                                        ->orderBy('value')
                                                        ->pluck('value', 'id');
                                                }
                                                return [];
                                            })
                                            ->reactive()
                                            ->required()
                                    ])
                                    ->columns(2),
                            ]),
                    ])->persistTabInQueryString()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
