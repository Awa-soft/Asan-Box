<?php

namespace App\Traits\Core;

trait HasCreateAnother
{
  public static  function selectField($name,$createResource):\Filament\Forms\Components\Select{
        $select = \Filament\Forms\Components\Select::make($name)
            ->searchable()
            ->live()
            ->preload();
        if($createResource::canCreate()){
            return $select
                ->createOptionForm(fn(\Filament\Forms\Form $form)=>$createResource::form($form));
        }
        return $select;
    }
}
