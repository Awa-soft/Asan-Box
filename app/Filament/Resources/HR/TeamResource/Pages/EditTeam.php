<?php

namespace App\Filament\Resources\HR\TeamResource\Pages;

use App\Filament\Resources\HR\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeam extends EditRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

        ];
    }
}
