<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\CashManagementResource\Pages;
use App\Filament\Resources\Finance\CashManagementResource\RelationManagers;
use App\Models\Finance\CashManagement;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CashManagementResource extends Resource
{
    use HasTranslatableResource;
    protected static ?string $model = CashManagement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 37;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('partner_account_id')
                    ->relationship('partnerAccount.partner', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('type')
                    ->native(0)
                    ->options(self::$model::getTypes())
                    ->required(),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('partnerAccountAll.partner.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('partnership')
                        ->state(function ($record){
                            return $record->partnerAccountAll->partnership->name;
                        })
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric(fn($record)=>$record->currency->decimal,locale:'en')
                    ->suffix(fn($record)=>$record->currency->symbol)
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                ->formatStateUsing(fn($state)=>static::$model::getTypes()[$state]),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
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
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCashManagement::route('/'),
        ];
    }
}
