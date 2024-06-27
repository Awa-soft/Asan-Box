<?php

namespace App\Filament\Resources\Inventory\ItemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CodesRelationManager extends RelationManager
{
    protected static string $relationship = 'codes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->columns([
                Tables\Columns\TextColumn::make('detail.invoice.invoice_number')
                ->badge(),
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('price')
                ->numeric(fn ($record) => $record->detail->currency->decimal)
                    ->suffix(fn ($record) => " " . $record->detail->currency->symbol),
                Tables\Columns\TextColumn::make('expense')
                ->numeric(fn ($record) => $record->detail->currency->decimal)
                    ->suffix(fn ($record) => " " . $record->detail->currency->symbol),
                Tables\Columns\TextColumn::make('cost')
                ->numeric(fn ($record) => $record->detail->currency->decimal)
                    ->suffix(fn ($record) => " " . $record->detail->currency->symbol),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
