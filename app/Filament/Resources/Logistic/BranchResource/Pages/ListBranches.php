<?php

namespace App\Filament\Resources\Logistic\BranchResource\Pages;

use App\Filament\Resources\Logistic\BranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBranches extends ListRecords
{
use \App\Traits\Core\TranslatableTable;
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus'),
        ];
    }
}
