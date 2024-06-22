<?php

namespace App\Filament\Resources\HR\TeamResource\Pages;

use App\Filament\Resources\HR\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeam extends EditRecord
{

    protected static string $resource = TeamResource::class;
    use \App\Traits\Core\TranslatableForm;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

        ];
    }
}
