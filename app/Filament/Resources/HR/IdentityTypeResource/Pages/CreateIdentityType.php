<?php

namespace App\Filament\Resources\HR\IdentityTypeResource\Pages;

use App\Filament\Resources\HR\IdentityTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIdentityType extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = IdentityTypeResource::class;
}
