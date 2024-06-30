<?php

namespace App\Filament\Resources\CRM\PartnerAccountResource\Pages;

use App\Filament\Resources\CRM\PartnerAccountResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartnerAccounts extends ListRecords
{
    protected static string $resource = PartnerAccountResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
