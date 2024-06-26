<?php

namespace App\Filament\Resources\HR\EmployeeLeaveResource\Pages;

use App\Filament\Resources\HR\EmployeeLeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeLeave extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;

    protected static string $resource = EmployeeLeaveResource::class;
}
