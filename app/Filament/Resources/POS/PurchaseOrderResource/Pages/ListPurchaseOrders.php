<?php

namespace App\Filament\Resources\POS\PurchaseOrderResource\Pages;

use App\Filament\Resources\POS\PurchaseOrderResource;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = PurchaseOrderResource::class;
    use TranslatableTable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
