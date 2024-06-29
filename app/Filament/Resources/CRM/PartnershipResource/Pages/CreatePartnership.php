<?php

namespace App\Filament\Resources\CRM\PartnershipResource\Pages;

use App\Filament\Resources\CRM\PartnershipResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartnership extends CreateRecord
{
    protected static string $resource = PartnershipResource::class;
    use TranslatableForm;

}
