<?php

namespace App\Filament\Resources\Logistic\BranchResource\Pages;

use App\Filament\Resources\Logistic\BranchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBranch extends EditRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            // Actions\ForceDeleteAction::make(),
            // Actions\RestoreAction::make(),
        ];
    }
}
