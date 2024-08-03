<?php

namespace App\Filament\Resources\Inventory\ItemLossResource\Pages;

use App\Filament\Resources\Inventory\ItemLossResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageItemLosses extends ManageRecords
{
    protected static string $resource = ItemLossResource::class;
    use TranslatableForm;
    use TranslatableTable;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
