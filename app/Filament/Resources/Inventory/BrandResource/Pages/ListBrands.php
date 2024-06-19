<?php

namespace App\Filament\Resources\Inventory\BrandResource\Pages;

use App\Filament\Resources\Inventory\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
use \App\Traits\Core\TranslatableTable;
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus')
            ->modalWidth("lg"),
        ];
    }
}
