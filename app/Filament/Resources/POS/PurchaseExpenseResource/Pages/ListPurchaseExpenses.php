<?php

namespace App\Filament\Resources\POS\PurchaseExpenseResource\Pages;

use App\Filament\Resources\POS\PurchaseExpenseResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseExpenses extends ListRecords
{
    protected static string $resource = PurchaseExpenseResource::class;
    use TranslatableForm, TranslatableTable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
