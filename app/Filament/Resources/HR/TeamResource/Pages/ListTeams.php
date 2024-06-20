<?php

namespace App\Filament\Resources\HR\TeamResource\Pages;

use App\Filament\Resources\HR\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeams extends ListRecords
{
        use \App\Traits\Core\TranslatableForm, \App\Traits\Core\TranslatableTable;
protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
