<?php

namespace App\Filament\Resources\POS\PurchaseExpenseResource\Pages;

use App\Filament\Resources\POS\PurchaseExpenseResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseExpense extends CreateRecord
{
    use TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = PurchaseExpenseResource::class;
}
