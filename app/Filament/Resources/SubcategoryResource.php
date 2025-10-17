<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Subcategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\SubcategoryResource\Pages;
use App\Filament\Resources\SubcategoryResource\RelationManagers\ProductsRelationManager;

class SubcategoryResource extends Resource
{
    protected static ?string $model = Subcategory::class;

    protected static ?string $navigationIcon = 'heroicon-s-tag';

    protected static ?string $navigationLabel = 'Оборудование';

    protected static ?string $navigationGroup = 'Каталог';

    public static function getModelLabel(): string
    {
        return 'Оборудование';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Оборудование';
    }

    public static function form(Form $form): Form
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
                        Tab::make('Описание')->schema([
                            TiptapEditor::make('description')
                                ->label('Описание')
                                ->columnSpanFull()
                                ->profile('default'),
                            RichEditor::make('short_text')
                                ->label('Короткое описание')
                                ->columnSpanFull()
                                ->toolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'codeBlock',
                                    'h1',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                ]),
                            RichEditor::make('long_text')
                                ->label('Длинное описание')
                                ->columnSpanFull()
                                ->toolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'codeBlock',
                                    'h1',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                ]),
                        ])
                    ])->persistTabInQueryString()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('name')
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
                Tables\Columns\TextColumn::make('category.productType.name')
                    ->label('Тип оборудования')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
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
            ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubcategories::route('/'),
            'create' => Pages\CreateSubcategory::route('/create'),
            'edit' => Pages\EditSubcategory::route('/{record}/edit'),
        ];
    }
}
