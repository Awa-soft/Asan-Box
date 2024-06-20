<?php

namespace App\Filament\Resources\Settings\CurrencyResource\Pages;

use App\Filament\Resources\Settings\CurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrency extends EditRecord
{

    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->hidden(fn($record) => $record->id == 1 || $record->id == 2),
            // Actions\ForceDeleteAction::make(),
            // Actions\RestoreAction::make(),
        ];
    }
}
