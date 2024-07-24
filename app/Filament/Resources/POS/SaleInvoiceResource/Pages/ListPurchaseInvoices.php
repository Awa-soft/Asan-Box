<?php

namespace App\Filament\Resources\POS\SaleInvoiceResource\Pages;

use App\Filament\Pages\POS\SalePage;
use App\Filament\Resources\POS\SaleInvoiceResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseInvoices extends ListRecords
{
    use TranslatableForm, TranslatableTable;

    protected static string $resource = SaleInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->url(SalePage::getUrl()),
        ];
    }
}
