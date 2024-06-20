<?php

namespace App\Filament\Resources\HR\EmployeeActivityResource\Pages;

use App\Filament\Resources\HR\EmployeeActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeActivity extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = EmployeeActivityResource::class;
}
