<?php

namespace App\Filament\Resources\POS\SaleInvoiceResource\Pages;

use App\Filament\Resources\POS\SaleInvoiceResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseInvoice extends CreateRecord
{
    use TranslatableForm;

    protected static string $resource = SaleInvoiceResource::class;
}
