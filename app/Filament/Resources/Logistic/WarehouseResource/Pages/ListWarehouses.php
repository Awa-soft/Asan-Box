<?php

namespace App\Filament\Resources\Logistic\WarehouseResource\Pages;

use App\Filament\Resources\Logistic\WarehouseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWarehouses extends ListRecords
{
use \App\Traits\Core\TranslatableTable;
    protected static string $resource = WarehouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus'),
        ];
    }
}
