<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\IdentityTypeResource\Pages;
use App\Filament\Resources\HR\IdentityTypeResource\RelationManagers;
use App\Models\HR\IdentityType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IdentityTypeResource extends Resource
{
    protected static ?string $model = IdentityType::class;

    protected static ?string $navigationIcon = 'polaris-identity-card-icon';
    public static function getModelLabel(): string
    {
        return trans('HR/lang.identity.singular_label');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('HR/lang.identity.plural_label');
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('HR/lang.group_label');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ownerable_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ownerable_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ownerable_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ownerable_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListIdentityTypes::route('/'),
            'create' => Pages\CreateIdentityType::route('/create'),
            'edit' => Pages\EditIdentityType::route('/{record}/edit'),
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
