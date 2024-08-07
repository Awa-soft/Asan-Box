<?php

namespace App\Filament\Resources\CRM\PartnerResource\Pages;

use App\Filament\Resources\CRM\PartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartner extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = PartnerResource::class;
}
