<?php

namespace App\Filament\Resources\CRM\BourseResource\Pages;

use App\Filament\Resources\CRM\BourseResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\ListRecords;

class ListBourses extends ListRecords
{
use \App\Traits\Core\TranslatableTable;
    protected static string $resource = BourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus'),
        ];
    }
}
