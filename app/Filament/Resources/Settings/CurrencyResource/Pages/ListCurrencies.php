<?php

namespace App\Filament\Resources\Settings\CurrencyResource\Pages;

use App\Filament\Resources\Settings\CurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCurrencies extends ListRecords
{
    use \App\Traits\Core\TranslatableTable, \App\Traits\Core\TranslatableForm;
    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus'),
        ];
    }
}
