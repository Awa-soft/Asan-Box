<?php

namespace App\Filament\Resources\Finance\ExpenseTypeResource\Pages;

use App\Filament\Resources\Finance\ExpenseTypeResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageExpenseTypes extends ManageRecords
{
    protected static string $resource = ExpenseTypeResource::class;
    use TranslatableForm;
    use TranslatableTable;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
