<?php

namespace App\Filament\Resources\HR\EmployeeNoteResource\Pages;

use App\Filament\Resources\HR\EmployeeNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeNote extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = EmployeeNoteResource::class;
}
