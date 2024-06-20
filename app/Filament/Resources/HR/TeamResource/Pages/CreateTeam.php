<?php

namespace App\Filament\Resources\HR\TeamResource\Pages;

use App\Filament\Resources\HR\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTeam extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = TeamResource::class;
}
