<?php

namespace App\Filament\Resources\CRM\CustomerResource\Pages;

use App\Filament\Resources\CRM\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
