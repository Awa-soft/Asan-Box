<?php

namespace App\Filament\Resources\Finance\PaymentResource\Pages;

use App\Filament\Resources\Finance\PaymentResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    use TranslatableForm;
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
