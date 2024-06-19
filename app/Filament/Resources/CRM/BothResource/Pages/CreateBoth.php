<?php

namespace App\Filament\Resources\CRM\BothResource\Pages;

use App\Filament\Resources\CRM\BothResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBoth extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = BothResource::class;
}
