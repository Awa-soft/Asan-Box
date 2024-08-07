<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\EmployeeResource\Pages;
use App\Filament\Resources\HR\EmployeeResource\RelationManagers;
use App\Filament\Resources\HR\EmployeeResource\RelationManagers\ActivitiesRelationManager;
use App\Filament\Resources\HR\EmployeeResource\RelationManagers\LeavesRelationManager;
use App\Filament\Resources\HR\EmployeeResource\RelationManagers\NotesRelationManager;
use App\Models\HR\Employee;
use App\Models\Settings\Currency;
use App\Traits\Core\HasCreateAnother;
use App\Traits\Core\HasTranslatableResource;
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
    use \App\Traits\Core\HasSoftDeletes;
    use OwnerableTrait;
    use HasCountries, HasCreateAnother;
    use HasTranslatableResource;
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'clarity-employee-group-line';

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
                        static::selectField('identity_type_id', IdentityTypeResource::class)
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
                            ->relationship('currency', 'symbol')
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
                            ->suffix(fn (Forms\Get $get) => getCurrencySymbol($get('currency_id')))
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('absence_amount')
                            ->suffix(fn (Forms\Get $get) => getCurrencySymbol($get('currency_id')))
                            ->required()
                            ->numeric()
                            ->default(0.00),
                        Forms\Components\TextInput::make('overtime_amount')
                            ->suffix(fn (Forms\Get $get) => getCurrencySymbol($get('currency_id')))
                            ->required()
                            ->numeric()
                            ->default(0.00),
                        Forms\Components\TextInput::make('annual_leave')
                            ->required()
                            ->numeric(),
                        static::selectField('team',TeamResource::class)
                             ->relationship('team', 'name')
                            ->maxItems(1)
                            ->multiple(),
                        static::selectField('positions',PositionResource::class)
                            ->relationship('positions', 'name')
                            ->multiple(),
                        Forms\Components\TextInput::make('work_days')
                        ->required()
                            ->numeric()
                            ->minValue(0)
                        ->default(30),
                        Forms\Components\TextInput::make('work_hours')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(8),
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
                        ->copyable()
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('phone')
                        ->copyable()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('nationality')
                        ->formatStateUsing(fn($state)=>static::getCountries()[$state])
                        ->description(fn($record)=>$record->address)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('gender')
                        ->formatStateUsing(fn($state)=>static::$model::getGenders()[$state])
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('identityType.name')
                        ->description(fn($record)=>$record->identity_number)
                        ->numeric()
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->sortable(),

                Tables\Columns\TextColumn::make('salary')
                    ->suffix(fn ($record) => " ".getCurrencySymbol($record->currency_id))
                    ->numeric(fn($record)=>getCurrencyDecimal( $record->currency_id))
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_salary_date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('hire_date')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('termination_date')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('end_time')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('annual_leave')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('remaining_leave')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('absence_amount')
                    ->suffix(fn ($record) => getCurrencySymbol($record->currency_id))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('salary_type')
                    ->formatStateUsing(fn ($state) => static::$model::getSalaryTypes()[$state])
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('overtime_amount')
                    ->suffix(fn ($record) => getCurrencySymbol($record->currency_id))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('work_days')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('work_hours')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
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
            ->actions([
                Tables\Actions\Action::make('statement')
                ->label(trans('lang.statement_action'))
                ->form([
                    Forms\Components\DatePicker::make('from')
                        ->label(trans('lang.from')),
                    Forms\Components\DatePicker::make('to')
                        ->label(trans('lang.to')),
                    Forms\Components\Select::make('activity')
                        ->label(trans('lang.activities'))
                        ->options([
                            'bonus'=>trans('lang.bonus'),
                            'punish'=>trans('lang.punish'),
                            'salary'=>trans('lang.salary'),
                            'leaves'=>trans('lang.leaves'),
                            'advance'=>trans('lang.advance'),
                            'absence'=>trans('lang.absence'),
                            'overtime'=>trans('lang.overtime'),
                            'notes'=>trans('lang.notes'),
                        ])->multiple()
                    ->native(0)
                ])->action(function(array $data,$record){
                    if(!$data['from']){
                        $data['from'] = 'all';
                    }
                    if(!$data['to']){
                        $data['to'] = 'all';
                    }
                    if(!$data['activity']){
                        $data['activity'] = ['all'];
                    }
                        redirect(static::getUrl('statement',['record' => $record->id, 'from' => $data['from'], 'to' => $data['to'],'activity'=>json_encode($data['activity'])]));
                    })->icon('tabler-report')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ActivitiesRelationManager::class,
            NotesRelationManager::class,
            LeavesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
            'statement'=>Pages\Statement::route('{record}/{from}/{to}/{activity}/statement'),
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
