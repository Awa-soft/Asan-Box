<?php

namespace App\Filament\Resources\CRM\BourseResource\Pages;

use App\Filament\Resources\CRM\BourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBourse extends EditRecord
{

    protected static string $resource = BourseResource::class;
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
