<?php

namespace App\Filament\Resources\CRM\PartnerResource\Pages;

use App\Filament\Resources\CRM\PartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartner extends EditRecord
{

    protected static string $resource = PartnerResource::class;
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
