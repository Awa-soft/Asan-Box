<?php

namespace App\Filament\Resources\HR\EmployeeLeaveResource\Pages;

use App\Filament\Resources\HR\EmployeeLeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeLeave extends EditRecord
{
    protected static string $resource = EmployeeLeaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
