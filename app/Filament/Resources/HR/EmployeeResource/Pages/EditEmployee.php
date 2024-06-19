<?php

namespace App\Filament\Resources\HR\EmployeeResource\Pages;

use App\Filament\Resources\HR\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    use \App\Traits\Core\TranslatableForm;

    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
