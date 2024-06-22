<?php

namespace App\Filament\Resources\Logistic\WarehouseResource\Pages;

use App\Filament\Resources\Logistic\WarehouseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWarehouse extends CreateRecord
{
    use \App\Traits\Core\TranslatableForm;

    protected static string $resource = WarehouseResource::class;
}
