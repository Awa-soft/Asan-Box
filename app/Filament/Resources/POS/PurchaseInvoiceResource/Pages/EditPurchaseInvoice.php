<?php

namespace App\Filament\Resources\POS\PurchaseInvoiceResource\Pages;

use App\Filament\Resources\POS\PurchaseInvoiceResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseInvoice extends EditRecord
{
    use TranslatableForm;

    protected static string $resource = PurchaseInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

        ];
    }
}
