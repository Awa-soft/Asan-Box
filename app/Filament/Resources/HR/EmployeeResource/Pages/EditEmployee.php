<?php

namespace App\Filament\Resources\HR\EmployeeResource\Pages;

use App\Filament\Resources\HR\EmployeeResource;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;


class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;
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
