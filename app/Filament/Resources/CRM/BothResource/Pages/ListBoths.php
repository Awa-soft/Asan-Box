<?php

namespace App\Filament\Resources\CRM\BothResource\Pages;

use App\Filament\Resources\CRM\BothResource;
use App\Traits\Core\TranslatableTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBoths extends ListRecords
{
use \App\Traits\Core\TranslatableTable;
    protected static string $resource = BothResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus'),
        ];
    }
}
