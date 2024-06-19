<?php

namespace App\Filament\Resources\CRM\BothResource\Pages;

use App\Filament\Resources\CRM\BothResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBoth extends EditRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = BothResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
