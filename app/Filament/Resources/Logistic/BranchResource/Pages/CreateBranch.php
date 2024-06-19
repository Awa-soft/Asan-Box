<?php

namespace App\Filament\Resources\Logistic\BranchResource\Pages;

use App\Filament\Resources\Logistic\BranchResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBranch extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;
    protected static string $resource = BranchResource::class;
}
