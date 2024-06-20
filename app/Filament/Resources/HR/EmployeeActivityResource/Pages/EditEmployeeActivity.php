<?php

namespace App\Filament\Resources\HR\EmployeeActivityResource\Pages;

use App\Filament\Resources\HR\EmployeeActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeActivity extends EditRecord
{
    protected static string $resource = EmployeeActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
