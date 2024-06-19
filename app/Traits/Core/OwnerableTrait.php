<?php

namespace App\Traits\Core;

use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
use Filament\Forms\Components\MorphToSelect;

trait OwnerableTrait
{
 
    public static function Field(){
        return   MorphToSelect::make('ownerable')
        ->label(trans("lang.ownerable"))
        ->native(0)
        ->types([
            MorphToSelect\Type::make(Branch::class)
                ->titleAttribute('name')
                ->label(trans('Logistic/lang.branch.singular_label')),
            MorphToSelect\Type::make(Warehouse::class)
                ->titleAttribute('name')
                ->label(trans('Logistic/lang.warehouse.singular_label')),
        ])
        ->visible(fn()=>auth()->user()->hasRole('super_admin'))
        ->searchable()
        ->preload();
    }
}
