<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhoneNumberResource\Pages;
use App\Filament\Resources\PhoneNumberResource\RelationManagers;
use App\Models\PhoneNumber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Propaganistas\LaravelPhone\PhoneNumber as PhoneNumberFormatter;
use Propaganistas\LaravelPhone\Rules\Phone;

class PhoneNumberResource extends Resource
{
    protected static ?string $model = PhoneNumber::class;

    protected static ?string $navigationIcon = 'heroicon-m-phone';

    protected static ?string $navigationLabel = 'Номера';

    protected static ?string $navigationGroup = 'Сайт';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')
                    ->label('Номер телефона')
                    ->required()
                    ->maxLength(255)
                    ->formatStateUsing(function (string $state) {
                        $phone = new PhoneNumberFormatter($state, "RU");
                        return $phone->formatNational();
                    })
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('data')
                    ->label('Информация')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'redo',
                        'undo',
                    ])
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('Номер телефона')
                    ->formatStateUsing(function (string $state) {
                        $phone = new PhoneNumberFormatter($state, "RU");
                        return $phone->formatNational();
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('data')
                    ->label('Информация')
                    ->html()
                    ->searchable(),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePhoneNumbers::route('/'),
        ];
    }
}
