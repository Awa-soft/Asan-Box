<?php

namespace App\Filament\Resources\Inventory\UnitResource\Pages;

use App\Filament\Resources\Inventory\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnits extends ListRecords
{
use \App\Traits\Core\TranslatableTable;
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus')
            ->modalWidth("lg"),
        ];
    }
}
