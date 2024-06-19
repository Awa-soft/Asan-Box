<?php

namespace App\Filament\Resources\Inventory\UnitResource\Pages;

use App\Filament\Resources\Inventory\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUnit extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = UnitResource::class;
}
