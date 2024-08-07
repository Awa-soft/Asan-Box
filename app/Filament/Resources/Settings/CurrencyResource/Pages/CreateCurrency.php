<?php

namespace App\Filament\Resources\Settings\CurrencyResource\Pages;

use App\Filament\Resources\Settings\CurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCurrency extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = CurrencyResource::class;
}
