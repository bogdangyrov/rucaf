<?php

namespace App\Filament\Resources\QuickFilterResource\Pages;

use App\Filament\Resources\QuickFilterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuickFilters extends ListRecords
{
    protected static string $resource = QuickFilterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
