<?php

namespace App\Filament\Resources\Inventory\BrandResource\Pages;

use App\Filament\Resources\Inventory\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBrand extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;

    protected static string $resource = BrandResource::class;
}
