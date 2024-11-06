<?php

namespace App\Filament\Resources\QuickFilterResource\Pages;

use App\Filament\Resources\QuickFilterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuickFilter extends EditRecord
{
    protected static string $resource = QuickFilterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
