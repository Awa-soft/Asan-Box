<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\PositionResource\Pages;
use App\Filament\Resources\HR\PositionResource\RelationManagers;
use App\Filament\Resources\HR\PositionResource\RelationManagers\EmployeesRelationManager;
use App\Models\HR\Position;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;
    use OwnerableTrait;
    protected static ?string $navigationIcon = 'eos-job';

    public static function getModelLabel(): string
    {
        return trans('HR/lang.position.singular_label');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('HR/lang.position.plural_label');
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('HR/lang.group_label');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    static::Field()->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                ])
                ->columnSpanFull()
                ->visible(fn($operation)=>$operation=="create"),

                Group::make([
                    static::Field()
                    ->columns(2)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                ])
                ->visible(fn($operation)=>$operation=="edit")
                ->columnSpanFull()
                ->columns(3),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                static::Column(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

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
            EmployeesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPositions::route('/'),
            // 'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
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
