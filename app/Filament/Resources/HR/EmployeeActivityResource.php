<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\EmployeeActivityResource\Pages;
use App\Filament\Resources\HR\EmployeeActivityResource\RelationManagers;
use App\Models\HR\EmployeeActivity;
use App\Traits\Core\HasTranslatableResource;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeActivityResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use OwnerableTrait;
    use HasTranslatableResource;

    protected static ?string $model = EmployeeActivity::class;

    protected static ?string $navigationIcon = 'carbon-user-activity';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::Field()
                    ->columns(2),
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->native(0)
                    ->required()
                    ->options(EmployeeActivity::getTypes())
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                static::Column(),
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn ($state) => static::$model::getTypes()[$state])
                    ->badge()
                    ->color(
                        function ($state) {
                            switch (static::$model::getTypes()[$state]) {
                                case 'Punishment':
                                    return 'danger';
                                case 'Advance':
                                    return 'warning';
                                case 'Bonus':
                                    return 'primary';
                                default:
                                    return 'success';
                            }
                        }
                    ),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric(fn($record) => $record->currency->decimal, locale:"en")
                    ->suffix(fn($record) => " ".$record->currency->symbol)
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date('Y-m-d')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeActivities::route('/'),
            // 'create' => Pages\CreateEmployeeActivity::route('/create'),
            'edit' => Pages\EditEmployeeActivity::route('/{record}/edit'),
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
