<?php

namespace App\Filament\Resources\HR\EmployeeSalaryResource\Pages;

use App\Filament\Resources\HR\EmployeeSalaryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeSalary extends CreateRecord
{
    protected static string $resource = EmployeeSalaryResource::class;
    use \App\Traits\Core\TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
