<?php

namespace App\Filament\Resources\Inventory\CategoryResource\Pages;

use App\Filament\Resources\Inventory\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    use \App\Traits\Core\TranslatableTable, \App\Traits\Core\TranslatableForm;
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus')
            ->modalWidth("lg"),
        ];
    }
}
