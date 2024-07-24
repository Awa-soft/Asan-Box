<?php

namespace App\Filament\Resources\POS\PurchaseInvoiceResource\Pages;

use App\Filament\Resources\POS\PurchaseInvoiceResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseInvoice extends CreateRecord
{
    use TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = PurchaseInvoiceResource::class;
}
