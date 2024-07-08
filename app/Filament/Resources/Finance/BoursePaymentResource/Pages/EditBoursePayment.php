<?php

namespace App\Filament\Resources\Finance\BoursePaymentResource\Pages;

use App\Filament\Resources\Finance\BoursePaymentResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBoursePayment extends EditRecord
{
    use TranslatableForm;
    protected static string $resource = BoursePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
