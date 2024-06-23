<?php

namespace App\Filament\Resources\HR\EmployeeSalaryResource\Pages;

use App\Filament\Resources\HR\EmployeeSalaryResource;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeSalaries extends ListRecords
{
    protected static string $resource = EmployeeSalaryResource::class;
    use TranslatableTable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
