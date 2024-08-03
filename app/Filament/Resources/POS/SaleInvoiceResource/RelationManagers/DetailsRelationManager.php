<?php

namespace App\Filament\Resources\POS\SaleInvoiceResource\RelationManagers;

use App\Models\POS\PurchaseInvoiceDetail;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('item_id')
                    ->relationship('item', 'name_'.App::getLocale())
                    ->preload()
                    ->label(trans('lang.item'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'symbol')
                    ->label(trans('lang.currency'))
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label(trans('lang.price'))
                    ->numeric()
                    ->required(),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('invoice.name')
                    ->label(trans('lang.invoice')),
                Tables\Columns\TextColumn::make('item.name_'.\Illuminate\Support\Facades\App::getLocale())
                    ->label(trans('Inventory/lang.item.singular_label')),
                Tables\Columns\TextColumn::make('quantity')
                    ->state(function ($record) {
                        return $record->codes()->where("gift", 0)->count();
                    })
                    ->label(trans('lang.quantity')),
                Tables\Columns\TextColumn::make('gift')
                    ->state(function ($record) {
                        return $record->codes()->where("gift", 1)->count();
                    })
                    ->label(trans('lang.gift')),
                Tables\Columns\TextColumn::make('price')
                    ->label(trans('lang.price'))
                    ->numeric(fn ($record) => $record->currency->decimal)
                    ->suffix(fn ($record) => " " . $record->currency->symbol),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalWidth('lg'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('lg'),
                Tables\Actions\DeleteAction::make(),
                Action::make("codes")
                    ->form(function ($record) {
                        return [
                            TableRepeater::make('codes')
                            ->relationship()
                                ->columns(3)
                                ->default($record->codes->toArray())
                                ->headers([
                                    Header::make(trans('lang.code')),
                                    Header::make(trans('lang.gift')),
                                ])
                                ->schema([
                                    Hidden::make('item_id')
                                    ->default($record->item_id),
                                    TextInput::make("code")
                                        ->required(),
                                    Select::make("gift")
                                        ->options([
                                            0 => trans("lang.no"),
                                            1 => trans("lang.yes"),
                                        ])
                                        ->default(0)
                                        ->required(),
                                ])
                        ];
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
