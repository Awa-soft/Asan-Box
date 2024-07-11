<?php

namespace App\Filament\Resources\CRM\VendorResource\Pages;

use App\Filament\Resources\CRM\VendorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendors extends ListRecords
{
    use \App\Traits\Core\TranslatableTable;
    protected static string $resource = VendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),
        ];
    }
}
