<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\TeamResource\Pages;
use App\Filament\Resources\HR\TeamResource\RelationManagers;
use App\Filament\Resources\HR\TeamResource\RelationManagers\MembersRelationManager;
use App\Models\HR\Team;
use App\Traits\Core\HasTranslatableResource;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    use OwnerableTrait;
    use HasTranslatableResource;

    protected static ?string $model = Team::class;
    protected static ?string $navigationIcon = 'lineawesome-teamspeak';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::Field()
                ->columns(2),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('leader_id')
                    ->required()
                    ->relationship("leader", "name")
                    ->preload()
                    ->searchable(),
                Select::make("members")
                    ->relationship("members", "name")
                    ->preload()
                    ->searchable()
                    ->multiple()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                static::Column(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee_id')
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
                Tables\Filters\TrashedFilter::make()
                ->native(0),
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            // 'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
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
