<?php

namespace App\Filament\Resources\POS\PurchaseExpenseResource\Pages;

use App\Filament\Resources\POS\PurchaseExpenseResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseExpense extends EditRecord
{
    protected static string $resource = PurchaseExpenseResource::class;
    use TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
