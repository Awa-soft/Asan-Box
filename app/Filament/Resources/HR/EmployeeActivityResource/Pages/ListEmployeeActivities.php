<?php

namespace App\Filament\Resources\HR\EmployeeActivityResource\Pages;

use App\Filament\Resources\HR\EmployeeActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeActivities extends ListRecords
{
        use \App\Traits\Core\TranslatableForm, \App\Traits\Core\TranslatableTable;
protected static string $resource = EmployeeActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
