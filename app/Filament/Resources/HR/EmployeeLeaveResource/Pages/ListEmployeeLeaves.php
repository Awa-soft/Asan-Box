<?php

namespace App\Filament\Resources\HR\EmployeeLeaveResource\Pages;

use App\Filament\Resources\HR\EmployeeLeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeLeaves extends ListRecords
{
    protected static string $resource = EmployeeLeaveResource::class;
    use \App\Traits\Core\TranslatableForm, \App\Traits\Core\TranslatableTable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
