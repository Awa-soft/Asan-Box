<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\EmployeeResource\Pages;
use App\Filament\Resources\HR\EmployeeResource\RelationManagers;
use App\Models\HR\Employee;
use App\Models\Settings\Currency;
use App\Traits\Core\HasCreateAnother;
use App\Traits\Core\OwnerableTrait;
use App\Traits\HR\HasCountries;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    use OwnerableTrait;
    use HasCountries,HasCreateAnother;
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(trans('lang.personal_information'))
                    ->columnSpan(1)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('nationality')
                        ->options(static::getCountries())
                        ->searchable()
                        ->preload()
                        ->optionsLimit(100)
                        ->default(null),
                    Forms\Components\TextInput::make('address')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\Select::make('gender')
                        ->required()
                        ->options(static::$model::getGenders())
                        ->searchable()
                        ->preload()
                        ->default('male'),
                    static::selectField('identity_type_id',IdentityTypeResource::class)
                        ->relationship('identityType', 'name'),
                    Forms\Components\TextInput::make('identity_number')
                        ->maxLength(255)
                        ->default(null),

                ])->columns(1),
                Forms\Components\Section::make(trans('lang.company_information'))
                    ->columnSpan(1)
                    ->columns(2)
                    ->schema([
                        static::Field()->columnSpanFull(),
                        Forms\Components\DatePicker::make('hire_date')
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('termination_date'),
                        Forms\Components\TimePicker::make('start_time'),
                        Forms\Components\TimePicker::make('end_time'),
                        Forms\Components\Select::make('currency_id')
                            ->relationship('currency', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->default(1)
                            ->required(),
                        Forms\Components\Select::make('salary_type')
                            ->required()
                            ->options(static::$model::getSalaryTypes())->searchable()
                            ->default('monthly'),
                        Forms\Components\TextInput::make('salary')
                            ->suffix(fn(Forms\Get $get)=>getCurrencySymbol($get('currency_id')))
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('absence_amount')
                            ->suffix(fn(Forms\Get $get)=>getCurrencySymbol($get('currency_id')))
                            ->required()
                            ->numeric()
                            ->default(0.00),
                        Forms\Components\TextInput::make('overtime_amount')
                            ->suffix(fn(Forms\Get $get)=>getCurrencySymbol($get('currency_id')))
                            ->required()
                            ->numeric()
                            ->default(0.00),
                        Forms\Components\TextInput::make('annual_leave')
                            ->required()
                            ->numeric(),
                    ]),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('identity_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nationality')
                    
                    ->searchable(),
                Tables\Columns\TextColumn::make('salary')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hire_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('termination_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('start_time'),
                Tables\Columns\TextColumn::make('end_time'),
                Tables\Columns\TextColumn::make('annual_leave')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('absence_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('salary_type'),
                Tables\Columns\TextColumn::make('overtime_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('identityType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ownerable_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ownerable_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.name')
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
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
