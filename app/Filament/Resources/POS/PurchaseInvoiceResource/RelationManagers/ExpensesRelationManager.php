<?php

namespace App\Filament\Resources\POS\PurchaseInvoiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpensesRelationManager extends RelationManager
{
    protected static string $relationship = 'expenses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("title")
                ->label(trans("lang.title"))
                ->required(),
                Select::make("currency_id")
                ->label(trans("lang.currency"))
                ->relationship("currency", "symbol")
                ->searchable()
                ->preload()
                ->default(1)
                ->required(),
                TextInput::make("amount")
                ->label(trans("lang.amount"))
                ->numeric()
                ->columnSpanFull()
                ->required(),
               Textarea::make("note")
               ->label(trans("lang.note"))
                ->columnSpanFull(),
                FileUpload::make("attachement")
                ->label(trans("lang.attachement"))
                ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
            Tables\Columns\TextColumn::make('title')
                ->searchable(),
            Tables\Columns\TextColumn::make('amount')
            ->sortable()

            ->numeric(fn($record)=>$record->currency->decimal)
            ->suffix(fn($record)=>" ".$record->currency->symbol),


            Tables\Columns\TextColumn::make('note')
                ->searchable(),
            Tables\Columns\TextColumn::make('attachement')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('user.name')
                ->numeric()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalWidth("lg"),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalWidth("lg"),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
