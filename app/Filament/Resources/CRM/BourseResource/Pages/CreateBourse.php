<?php

namespace App\Filament\Resources\CRM\BourseResource\Pages;

use App\Filament\Resources\CRM\BourseResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateBourse extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = BourseResource::class;

}
