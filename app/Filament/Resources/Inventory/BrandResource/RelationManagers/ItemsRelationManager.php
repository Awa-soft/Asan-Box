<?php

namespace App\Filament\Resources\Inventory\BrandResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

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

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
    return trans('Inventory/lang.item.plural_label');
    }

    public function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
            ->modelLabel(trans('Inventory/lang.item.plural_label'))
            ->recordTitleAttribute('items.name_'.App::getLocale())
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                ->circular()
                ->label(trans("lang.image"))
                ->size(80)
                ->circular(),
            Tables\Columns\TextColumn::make('name_'.App::getLocale())
                ->label(trans("lang.name"))
                ->description(fn($record)=>$record->description)
                ->searchable(),
            Tables\Columns\TextColumn::make('description')
                ->label(trans("lang.description"))
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('cost')
                ->label(trans("lang.cost"))
                ->searchable()
                ->numeric(getBaseCurrency()->decimal)
                ->suffix(
                    " ".getBaseCurrency()->symbol
                ),
            Tables\Columns\TextColumn::make('barcode')
                ->label(trans("lang.barcode"))
                ->searchable()
                ->hidden()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('category.name')
                ->numeric()
                ->label(trans("lang.category"))
                ->sortable(),
            Tables\Columns\TextColumn::make('brand.name')
                ->numeric()
                ->label(trans("lang.brand"))
                ->sortable(),
            ViewColumn::make('price')->view('tables.columns.price-column')
                ->state(function ($record) {
                    return $record;
                })
                ->label(trans("lang.price")),
            Tables\Columns\TextColumn::make('benifit_ratio')
                ->numeric()
                ->label(trans("lang.benifit_ratio"))
                ->suffix("%")
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
            Tables\Columns\TextColumn::make('expire_date')
                ->label(trans("lang.expire_date"))
                ->date()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
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
