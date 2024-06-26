<?php

namespace App\Filament\Resources\CRM\VendorResource\Pages;

use App\Filament\Resources\CRM\VendorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVendor extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;

    protected static string $resource = VendorResource::class;
}
