<?php

namespace App\Filament\Resources\HR\TeamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\HR\Employee;
use App\Traits\Core\OwnerableTrait;
use Illuminate\Database\Eloquent\Model;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';
    use OwnerableTrait;
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('HR/lang.employee.plural_label');
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
           ->modelLabel(trans('HR/lang.employee.plural_label'))
            ->defaultSort('id','desc')
            ->recordTitleAttribute('name')
           ->columns([
               static::Column(),
               Tables\Columns\TextColumn::make('name')
                   ->label(trans('lang.name'))
                   ->searchable(),
               Tables\Columns\TextColumn::make('email')
                   ->label(trans('lang.email'))
                   ->copyable()
                   ->searchable(),
               Tables\Columns\TextColumn::make('phone')
                   ->copyable()
                   ->label(trans('lang.phone'))
                   ->searchable(),
               Tables\Columns\TextColumn::make('nationality')
                   ->formatStateUsing(fn ($state) => static::getCountries()[$state])
                   ->description(fn ($record) => $record->address)
                   ->label(trans('lang.address'))
                   ->searchable(),
               Tables\Columns\TextColumn::make('gender')
                   ->label(trans('lang.gender'))
                   ->formatStateUsing(fn ($state) => Employee::getGenders()[$state])
                   ->toggleable(isToggledHiddenByDefault: true),
               Tables\Columns\TextColumn::make('identityType.name')
                   ->label(trans('lang.identity_type'))
                   ->description(fn ($record) => $record->identity_number)
                   ->numeric(2,locale:'en')
                   ->toggleable(isToggledHiddenByDefault: true)
                   ->sortable(),
               Tables\Columns\TextColumn::make('salary')
                   ->label(trans('lang.salary'))
                   ->suffix(fn ($record) => getCurrencySymbol($record->currency_id))
                   ->numeric(2,locale:'en')
                   ->sortable(),
               Tables\Columns\TextColumn::make('hire_date')
                   ->date()
                   ->label(trans('lang.hire_date'))
                   ->toggleable(isToggledHiddenByDefault: true)
                   ->sortable(),
               Tables\Columns\TextColumn::make('termination_date')
                   ->date()
                   ->label(trans('lang.termination_date'))
                   ->toggleable(isToggledHiddenByDefault: true)
                   ->sortable(),
               Tables\Columns\TextColumn::make('start_time')
                   ->label(trans('lang.start_time'))
                   ->toggleable(isToggledHiddenByDefault: true),
               Tables\Columns\TextColumn::make('end_time')
                   ->label(trans('lang.end_time'))
                   ->toggleable(isToggledHiddenByDefault: true),
               Tables\Columns\TextColumn::make('annual_leave')
                   ->label(trans('lang.annual_leave'))
                   ->numeric(2,locale:'en')
                   ->toggleable(isToggledHiddenByDefault: true)
                   ->sortable(),
               Tables\Columns\TextColumn::make('absence_amount')
                   ->label(trans('lang.absence_amount'))
                   ->suffix(fn ($record) => getCurrencySymbol($record->currency_id))
                   ->numeric(2,locale:'en')
                   ->toggleable(isToggledHiddenByDefault: true)
                   ->sortable(),
               Tables\Columns\TextColumn::make('salary_type')
                   ->label(trans('lang.salary_type'))
                   ->formatStateUsing(fn ($state) => Employee::getSalaryTypes()[$state])
                   ->toggleable(isToggledHiddenByDefault: true),
               Tables\Columns\TextColumn::make('overtime_amount')
                   ->label(trans('lang.overtime_amount'))
                   ->suffix(fn ($record) => getCurrencySymbol($record->currency_id))
                   ->numeric(2,locale:'en')
                   ->toggleable(isToggledHiddenByDefault: true)
                   ->sortable(),
               Tables\Columns\TextColumn::make('user.name')
                   ->label(trans('lang.user'))
                   ->numeric(2,locale:'en')
                   ->sortable(),
               Tables\Columns\TextColumn::make('deleted_at')
                   ->label(trans('lang.deleted_at'))
                   ->dateTime()
                   ->sortable()
                   ->toggleable(isToggledHiddenByDefault: true),
               Tables\Columns\TextColumn::make('created_at')
                   ->dateTime()
                   ->label(trans('lang.created_at'))
                   ->sortable()
                   ->toggleable(isToggledHiddenByDefault: true),
               Tables\Columns\TextColumn::make('updated_at')
                   ->dateTime()
                   ->label(trans('lang.updated_at'))
                   ->sortable()
                   ->toggleable(isToggledHiddenByDefault: true),
           ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
