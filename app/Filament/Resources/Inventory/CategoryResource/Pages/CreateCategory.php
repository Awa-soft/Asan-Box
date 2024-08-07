<?php

namespace App\Filament\Resources\Inventory\CategoryResource\Pages;

use App\Filament\Resources\Inventory\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = CategoryResource::class;
}
