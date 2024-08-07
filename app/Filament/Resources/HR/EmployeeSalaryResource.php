<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\EmployeeSalaryResource\Pages;
use App\Filament\Resources\HR\EmployeeSalaryResource\RelationManagers;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeActivity;
use App\Models\HR\EmployeeSalary;
use App\Traits\Core\HasTranslatableResource;
use App\Traits\Core\OwnerableTrait;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class EmployeeSalaryResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use HasTranslatableResource,OwnerableTrait;
    protected static ?string $model = EmployeeSalary::class;

    protected static ?string $navigationIcon = 'fas-hand-holding-dollar';
    protected static ?int $navigationSort = 34;

    protected static function calculateSalary(Forms\Get $get, Forms\Set $set): void{
        $date = $get('salary_date')??now();
        $work_average = $get('work_average');
        $employee_id = $get('employee_id');
        $employee = Employee::find($employee_id);
        $lastSalaryDate = $get('lastSalaryDate');
        if(!$lastSalaryDate){
            $lastSalaryDate = Employee::find($employee_id)?->last_salary_date??now();
            $set('lastSalaryDate',$lastSalaryDate);
        }
        $set('salary', number_format($employee?->salary??0, $employee?->currency?->decimal??2));
//                            $absences = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
//                                ->where('date','<',$date)
//                                ->where('type', 'absence')
//                                ->sum('amount');
        $punish = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
            ->where('date','<',$date)
            ->where('type', 'punish')
            ->sum('amount');
        $bonus  = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
            ->where('date','<',$date)
            ->where('type', 'bonus')
            ->sum('amount');
        $advance  = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
            ->where('date','<',$date)
            ->where('type', 'advance')
            ->sum('amount');
        $overtime  = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
            ->where('date','<',$date)
            ->where('type', 'overtime')
            ->sum('amount');
//                            $set('absences', number_format($absences,$employee?->currency?->decimal??2));
        $set('punish', number_format($punish,$employee?->currency?->decimal??2));
        $set('bonus', number_format($bonus,$employee?->currency?->decimal??2));
        $set('advance', number_format($advance,$employee?->currency?->decimal??2));
        $set('overtime', number_format($overtime,$employee?->currency?->decimal??2));
        $perHourSalary = $employee?->hour_salary??0;
        $salary_amount = $employee?->work_days*$work_average*$perHourSalary;
        $amount = ($bonus+$overtime+$salary_amount) - ($punish+$advance);
        $set('amount', number_format($amount,$employee?->currency?->decimal??2,'.',''));
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(trans('lang.details'))
                ->schema([
                    static::Field(),
                    Forms\Components\Select::make('employee_id')
                        ->relationship('employee', 'name')
                        ->searchable()
                        ->live()
                        ->disabled(fn($operation)=>$operation == 'edit')
                        ->afterStateUpdated(function(Forms\Get $get,Forms\Set $set){
                          static::calculateSalary($get, $set);
                        })
                        ->preload()
                        ->required(),
                    Forms\Components\DatePicker::make('lastSalaryDate')
                        ->live()
                        ->afterStateUpdated(function(Forms\Get $get,Forms\Set $set){
                            static::calculateSalary($get, $set);
                        })
                        ->hidden(fn($operation)=>$operation == 'edit')
                        ->required(),
                    Forms\Components\DatePicker::make('salary_date')
                        ->live()
                        ->disabled(fn($operation)=>$operation == 'edit')
                        ->afterStateUpdated(function(Forms\Get $get,Forms\Set $set){
                            $date = $get('salary_date')??now();
                            $employee_id = $get('employee_id');
                            $employee = Employee::find($employee_id);
                            $lastSalaryDate = $get('lastSalaryDate');
                            $set('lastSalaryDate',$lastSalaryDate);
                            $set('salary', number_format($employee?->salary??0, $employee?->currency?->decimal??2));
                            $absences = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
                                ->where('date','<',$date)
                                ->where('type', 'absence')
                                ->sum('amount');
                            $punish = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
                                ->where('date','<',$date)
                                ->where('type', 'punish')
                                ->sum('amount');
                            $bonus  = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
                                ->where('date','<',$date)
                                ->where('type', 'bonus')
                                ->sum('amount');
                            $advance  = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
                                ->where('date','<',$date)
                                ->where('type', 'advance')
                                ->sum('amount');
                            $overtime  = EmployeeActivity::where('employee_id', $employee_id)->where('date', '>=', $lastSalaryDate)
                                ->where('date','<',$date)
                                ->where('type', 'overtime')
                                ->sum('amount');
                            $set('absences', number_format($absences,$employee?->currency?->decimal??2));
                            $set('punish', number_format($punish,$employee?->currency?->decimal??2));
                            $set('bonus', number_format($bonus,$employee?->currency?->decimal??2));
                            $set('advance', number_format($advance,$employee?->currency?->decimal??2));
                            $set('overtime', number_format($overtime,$employee?->currency?->decimal??2));
                            $amount = ($bonus+$overtime+($employee?->salary??0)) - ($absences+$punish+$advance);
                            $set('amount', number_format($amount,$employee?->currency?->decimal??2,'.',''));
                        })
                        ->default(now())
                        ->required(),
                    Forms\Components\DatePicker::make('payment_date')
                        ->default(now())
                        ->required(),
                ])->columnSpan(fn($operation) => $operation == 'edit'? 2 : 1)->columns(2),
                Forms\Components\Section::make(trans('lang.activities'))
                    ->schema([
                        Forms\Components\TextInput::make('salary')
                            ->hidden(fn($operation)=>$operation == 'edit')
                            ->suffix(fn(Forms\Get $get)=>(Employee::find($get('employee_id'))?->currency?->symbol)??'$')
                            ->disabled(),
                        Forms\Components\TextInput::make('punish')
                            ->hidden(fn($operation)=>$operation == 'edit')
                            ->suffix(fn(Forms\Get $get)=>(Employee::find($get('employee_id'))?->currency?->symbol)??'$')
                            ->disabled(),
                        Forms\Components\TextInput::make('bonus')
                            ->hidden(fn($operation)=>$operation == 'edit')
                            ->suffix(fn(Forms\Get $get)=>(Employee::find($get('employee_id'))?->currency?->symbol)??'$')
                            ->disabled(),
                        Forms\Components\TextInput::make('advance')
                            ->hidden(fn($operation)=>$operation == 'edit')
                            ->suffix(fn(Forms\Get $get)=>(Employee::find($get('employee_id'))?->currency?->symbol)??'$')
                            ->disabled(),
                        Forms\Components\TextInput::make('overtime')
                            ->hidden(fn($operation)=>$operation == 'edit')
                            ->suffix(fn(Forms\Get $get)=>(Employee::find($get('employee_id'))?->currency?->symbol)??'$')
                            ->disabled(),
                    ])->columnSpan(fn($operation) => $operation == 'edit'? 2 : 1)->columns(2),
                Forms\Components\TextInput::make('work_average')
                    ->required()
                    ->afterStateUpdated(function(Forms\Get $get,Forms\Set $set){
                        static::calculateSalary($get, $set);
                    })
                    ->live(onBlur: true)
                    ->default(8),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('payment_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('note')
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->default(null),

            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric(locale:'en')
                    ->suffix(fn($record)=>$record->currency?->symbol??'$')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_amount')
                    ->suffix(fn($record)=>$record->currency?->symbol??'$')
                    ->numeric(locale:'en')
                    ->sortable(),
                Tables\Columns\TextColumn::make('salary_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                static::Column(),
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
                DateRangeFilter::make('created_at')
                ->label(trans('lang.created_at')),
                DateRangeFilter::make('payment_date')
                ->label(trans('lang.payment_date')),
                DateRangeFilter::make('salary_date')
                ->label(trans('lang.salary_date')),
                Tables\Filters\SelectFilter::make('employee_id')
                    ->label(trans('lang.employee'))
                    ->relationship('employee', 'name')
                    ->searchable()
                ->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListEmployeeSalaries::route('/'),
            'create' => Pages\CreateEmployeeSalary::route('/create'),
            'edit' => Pages\EditEmployeeSalary::route('/{record}/edit'),
        ];
    }
}
