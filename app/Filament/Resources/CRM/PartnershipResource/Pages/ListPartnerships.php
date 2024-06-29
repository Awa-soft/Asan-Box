<?php

namespace App\Filament\Resources\CRM\PartnershipResource\Pages;

use App\Filament\Resources\CRM\PartnershipResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartnerships extends ListRecords
{
    protected static string $resource = PartnershipResource::class;
    use TranslatableTable,TranslatableForm;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
