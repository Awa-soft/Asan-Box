<?php

namespace App\Filament\Resources\Inventory\BrandResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('items.name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('items.name')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->label(trans("lang.image"))
                    ->size(80)
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans("lang.name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(trans("lang.description"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->label(trans("lang.barcode"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->label(trans("lang.category"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->label(trans("lang.brand"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('singleUnit.name')
                    ->numeric()
                    ->label(trans("lang.single_unit"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('multiple_unit_id')
                    ->numeric()
                    ->label(trans("lang.multiple_unit"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->money()
                    ->label(trans("lang.cost"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('single_price')
                    ->numeric()
                    ->label(trans("lang.single_price"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('multiple_price')
                    ->numeric()
                    ->label(trans("lang.multiple_price"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('benifit_ratio')
                    ->numeric()
                    ->label(trans("lang.benifit_ratio"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('multi_quantity')
                    ->label(trans("lang.multi_quantity"))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expire_date')
                    ->label(trans("lang.expire_date"))
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(trans('lang.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('lang.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('lang.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make()
                // ->modalWidth("lg"),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
