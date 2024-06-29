<?php

namespace App\Filament\Resources\CRM\PartnershipResource\Pages;

use App\Filament\Resources\CRM\PartnershipResource;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnership extends EditRecord
{
    protected static string $resource = PartnershipResource::class;
    use TranslatableForm;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
