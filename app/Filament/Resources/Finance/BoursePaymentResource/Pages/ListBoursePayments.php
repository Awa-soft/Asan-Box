<?php

namespace App\Filament\Resources\Finance\BoursePaymentResource\Pages;

use App\Filament\Resources\Finance\BoursePaymentResource;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBoursePayments extends ListRecords
{
    use TranslatableTable;
    protected static string $resource = BoursePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
