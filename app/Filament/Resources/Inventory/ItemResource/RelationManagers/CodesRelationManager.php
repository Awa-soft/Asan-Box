<?php

namespace App\Filament\Resources\Inventory\ItemResource\RelationManagers;

use App\Models\POS\PurchaseDetailCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CodesRelationManager extends RelationManager
{
    protected static string $relationship = 'codes';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('lang.codes');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->modelLabel(trans('lang.codes'))
            ->columns([
                Tables\Columns\TextColumn::make('detail.invoice.invoice_number')
                    ->label(trans('lang.invoice_number'))
                ->badge(),
                Tables\Columns\TextColumn::make('code')->label(trans('lang.code')),
                Tables\Columns\BooleanColumn::make('is_sold')->label(trans('lang.is_sold')),
                Tables\Columns\TextColumn::make('price')
                    ->label(trans('lang.price'))
                ->numeric(fn ($record) => $record->detail->currency->decimal,locale:'en')
                    ->suffix(fn ($record) => " " . $record->detail->currency->symbol),
                Tables\Columns\TextColumn::make('expense')
                    ->label(trans('lang.expense'))
                ->numeric(fn ($record) => $record->detail->currency->decimal,locale:'en')
                    ->suffix(fn ($record) => " " . $record->detail->currency->symbol),
                Tables\Columns\TextColumn::make('cost')
                    ->label(trans('lang.cost'))
                ->numeric(fn ($record) => $record->detail->currency->decimal,locale:'en')
                    ->suffix(fn ($record) => " " . $record->detail->currency->symbol),
            ]);
    }
}
