<?php

namespace App\Filament\Resources\HR\EmployeeNoteResource\Pages;

use App\Filament\Resources\HR\EmployeeNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeNote extends EditRecord
{
   protected static string $resource = EmployeeNoteResource::class;
   use \App\Traits\Core\TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

        ];
    }
}
