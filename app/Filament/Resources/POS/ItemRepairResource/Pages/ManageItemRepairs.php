<?php

namespace App\Filament\Resources\POS\ItemRepairResource\Pages;

use App\Filament\Resources\POS\ItemRepairResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageItemRepairs extends ManageRecords
{
    protected static string $resource = ItemRepairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
