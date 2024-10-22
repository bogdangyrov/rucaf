<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Attribute;
use Filament\Tables\Table;
use App\Models\AttributeValue;
use App\Models\Value;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AttributeValuesRelationManager extends RelationManager
{
    protected static string $relationship = 'attributeValues';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('attribute_id')
                    ->label('Характеристика')
                    ->relationship('attribute', 'name')
                    ->required()
                    ->reactive()
                    ->createOptionForm(function (Form $form) {
                        return $form->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Новая характеристика')
                                ->required(),
                            Hidden::make('product_type_id')
                                ->default($this->getProductTypeId())
                                ->required()
                        ]);
                    }),
                Select::make('value_id')
                    ->label('Значение')
                    ->options(function ($get) {
                        $attributeId = $get('attribute_id');
                        if ($attributeId) {
                            $values = Attribute::find($attributeId)->values()->get()->pluck('value', 'id');
                            return $values;
                        } else {
                            return [];
                        }
                    })
                    ->required()
                    ->reactive()
                    ->createOptionForm(function (Form $form, Get $get) {
                        return $form->schema([
                            Forms\Components\TextInput::make('value')
                                ->label('Значение')
                                ->required(),
                            Hidden::make('attribute_id')
                                ->default($get('attribute_id'))
                                ->required()
                        ]);
                    })
                    ->createOptionUsing(function (array $data): int {
                        return Value::create($data)->getKey();
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('attribute.name')
                    ->label('Характеристика'),
                Tables\Columns\TextColumn::make('value.value')
                    ->label('Значение'),
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

    protected function getProductTypeId()
    {
        return $this->ownerRecord->product_type_id;
    }
}
