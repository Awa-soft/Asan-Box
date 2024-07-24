<?php

namespace App\Filament\Resources\CRM\PartnerAccountResource\Pages;

use App\Filament\Resources\CRM\PartnerAccountResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnerAccount extends EditRecord
{
    protected static string $resource = PartnerAccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
