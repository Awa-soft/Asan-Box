<?php

namespace App\Filament\Resources\HR\IdentityTypeResource\Pages;

use App\Filament\Resources\HR\IdentityTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIdentityTypes extends ListRecords
{
    use \App\Traits\Core\TranslatableForm, \App\Traits\Core\TranslatableTable;
    protected static string $resource = IdentityTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
