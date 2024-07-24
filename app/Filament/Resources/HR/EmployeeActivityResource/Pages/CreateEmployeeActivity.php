<?php

namespace App\Filament\Resources\HR\EmployeeActivityResource\Pages;

use App\Filament\Resources\HR\EmployeeActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeActivity extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = EmployeeActivityResource::class;
}
