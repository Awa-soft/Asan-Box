<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\EmployeeLeaveResource\Pages;
use App\Filament\Resources\HR\EmployeeLeaveResource\RelationManagers;
use App\Models\HR\EmployeeLeave;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeLeaveResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('from')
                    ->required(),
                Forms\Components\DateTimePicker::make('to')
                    ->required(),
                Forms\Components\TextInput::make('note')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
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
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('from')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('to')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
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
            'index' => Pages\ListEmployeeLeaves::route('/'),
            'create' => Pages\CreateEmployeeLeave::route('/create'),
            'edit' => Pages\EditEmployeeLeave::route('/{record}/edit'),
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
