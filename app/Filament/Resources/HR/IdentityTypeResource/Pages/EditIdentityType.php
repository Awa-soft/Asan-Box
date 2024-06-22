<?php

namespace App\Filament\Resources\HR\IdentityTypeResource\Pages;

use App\Filament\Resources\HR\IdentityTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIdentityType extends EditRecord
{
   protected static string $resource = IdentityTypeResource::class;
   use \App\Traits\Core\TranslatableForm;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

        ];
    }
}
