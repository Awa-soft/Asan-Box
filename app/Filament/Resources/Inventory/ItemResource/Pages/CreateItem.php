<?php

namespace App\Filament\Resources\Inventory\ItemResource\Pages;

use App\Filament\Resources\Inventory\ItemResource;
use App\Traits\Core\OwnerableTrait;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateItem extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = ItemResource::class;
}
