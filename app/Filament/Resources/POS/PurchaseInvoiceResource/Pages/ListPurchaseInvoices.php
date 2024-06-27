<?php

namespace App\Filament\Resources\POS\PurchaseInvoiceResource\Pages;

use App\Filament\Pages\POS\PurchasePage;
use App\Filament\Resources\POS\PurchaseInvoiceResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseInvoices extends ListRecords
{
    use TranslatableForm, TranslatableTable;

    protected static string $resource = PurchaseInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->url(PurchasePage::getUrl()),
        ];
    }
}
