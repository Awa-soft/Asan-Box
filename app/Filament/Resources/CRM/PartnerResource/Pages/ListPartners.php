<?php

namespace App\Filament\Resources\CRM\PartnerResource\Pages;

use App\Filament\Resources\CRM\PartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartners extends ListRecords
{
use \App\Traits\Core\TranslatableTable;
    protected static string $resource = PartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus'),
        ];
    }
}
