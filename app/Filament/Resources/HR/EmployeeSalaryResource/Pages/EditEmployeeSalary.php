<?php

namespace App\Filament\Resources\HR\EmployeeSalaryResource\Pages;

use App\Filament\Resources\HR\EmployeeSalaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeSalary extends EditRecord
{
    protected static string $resource = EmployeeSalaryResource::class;
    use \App\Traits\Core\TranslatableForm;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
