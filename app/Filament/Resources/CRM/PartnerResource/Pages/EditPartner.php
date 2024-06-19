<?php

namespace App\Filament\Resources\CRM\PartnerResource\Pages;

use App\Filament\Resources\CRM\PartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartner extends EditRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = PartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
