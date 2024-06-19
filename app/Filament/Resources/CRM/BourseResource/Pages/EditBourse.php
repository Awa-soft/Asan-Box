<?php

namespace App\Filament\Resources\CRM\BourseResource\Pages;

use App\Filament\Resources\CRM\BourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBourse extends EditRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = BourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
