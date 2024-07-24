<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\CurrencyResource\Pages;
use App\Filament\Resources\Settings\CurrencyResource\RelationManagers;
use App\Models\Settings\Currency;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurrencyResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use HasTranslatableResource;

    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'far-money-bill-alt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans("lang.name"))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('symbol')
                    ->label(trans("lang.symbol"))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('decimal')
                    ->label(trans("lang.decimal"))
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('rate')
                    ->label(trans("lang.rate"))
                    ->required()
                    ->numeric()
                    ->helperText(trans("settings/lang.currency.rate_hint")),


            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans("lang.name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('symbol')
                    ->label(trans("lang.symbol"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('decimal')
                    ->label(trans("lang.decimal"))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('rate')
                    ->label(trans("lang.rate"))
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('base')
                    ->label(trans("lang.base"))
                    ->beforeStateUpdated(
                        function ($record) {
                            Currency::query()->update([
                                "base" => false
                            ]);
                        }
                    ),
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
                // Tables\Filters\TrashedFilter::make()
            ])
            ->actions([
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     // Tables\Actions\ForceDeleteBulkAction::make(),
                //     // Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCurrencies::route('/'),
            // 'create' => Pages\CreateCurrency::route('/create'),
            // 'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
