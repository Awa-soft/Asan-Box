<?php

namespace App\Filament\Resources\CRM\PartnerAccountResource\Pages;

use App\Filament\Resources\CRM\PartnerAccountResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartnerAccount extends CreateRecord
{
    protected static string $resource = PartnerAccountResource::class;

}
