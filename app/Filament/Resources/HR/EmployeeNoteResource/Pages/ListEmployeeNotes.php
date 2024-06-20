<?php

namespace App\Filament\Resources\HR\EmployeeNoteResource\Pages;

use App\Filament\Resources\HR\EmployeeNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeNotes extends ListRecords
{
        use \App\Traits\Core\TranslatableForm, \App\Traits\Core\TranslatableTable;
protected static string $resource = EmployeeNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
