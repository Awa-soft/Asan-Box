<?php

namespace App\Traits\Core;

use Filament\Tables\Table;
use Filament\Tables;


trait TranslatableTable
{

    public function table(Table $table): Table
    {
        $columns = [];
        foreach (parent::table($table)->getColumns() as $key =>$column){
            // split $key by .
            $keys = explode('.', $key);
            $column = $column->label(trans('lang.'.$keys[0]));
            if (count($keys) > 1){
                $column = $column->label(trans('lang.'.$keys[0]));
            }
            else{
                $column = $column->label(trans('lang.'.$key));
            }
            $columns[] = $column;
        }
        $actions =[
            Tables\Actions\EditAction::make()
                    ->modalWidth("lg"),
                Tables\Actions\DeleteAction::make(),
        ] ;
       $actions = array_merge($actions, parent::table($table)->getActions());

        return parent::table($table)->columns($columns)->actions($actions); // TODO: Change the autogenerated stub
    }
}
