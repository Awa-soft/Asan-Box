<?php

namespace App\Filament\Resources\HR\PositionResource\Pages;

use App\Filament\Resources\HR\PositionResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPositions extends ListRecords
{


        use \App\Traits\Core\TranslatableForm, \App\Traits\Core\TranslatableTable;
    protected static string $resource = PositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
