<?php

namespace App\Filament\Resources\Finance\ExpenseResource\Pages;

use App\Filament\Resources\Finance\ExpenseResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageExpenses extends ManageRecords
{
    protected static string $resource = ExpenseResource::class;
    use TranslatableForm;
    use TranslatableTable;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
