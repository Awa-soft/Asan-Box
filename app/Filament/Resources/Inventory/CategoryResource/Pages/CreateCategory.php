<?php

namespace App\Filament\Resources\Inventory\CategoryResource\Pages;

use App\Filament\Resources\Inventory\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;

    protected static string $resource = CategoryResource::class;
}
