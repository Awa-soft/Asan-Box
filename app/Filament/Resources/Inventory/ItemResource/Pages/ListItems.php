<?php

namespace App\Filament\Resources\Inventory\ItemResource\Pages;

use App\Filament\Resources\Inventory\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
use \App\Traits\Core\TranslatableTable;

    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus'),
        ];
    }
}
