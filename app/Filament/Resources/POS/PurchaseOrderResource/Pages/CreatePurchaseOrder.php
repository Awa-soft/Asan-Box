<?php

namespace App\Filament\Resources\POS\PurchaseOrderResource\Pages;

use App\Filament\Resources\POS\PurchaseOrderResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseOrder extends CreateRecord
{
    use TranslatableForm;

    protected static string $resource = PurchaseOrderResource::class;
}
