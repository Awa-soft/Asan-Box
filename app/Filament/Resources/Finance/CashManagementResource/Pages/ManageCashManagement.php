<?php

namespace App\Filament\Resources\Finance\CashManagementResource\Pages;

use App\Filament\Resources\Finance\CashManagementResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCashManagement extends ManageRecords
{
    protected static string $resource = CashManagementResource::class;
    use TranslatableForm;
    use TranslatableTable;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
