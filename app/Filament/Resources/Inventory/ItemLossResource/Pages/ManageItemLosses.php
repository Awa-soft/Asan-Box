<?php

namespace App\Filament\Resources\Inventory\ItemLossResource\Pages;

use App\Filament\Resources\Inventory\ItemLossResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageItemLosses extends ManageRecords
{
    protected static string $resource = ItemLossResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
