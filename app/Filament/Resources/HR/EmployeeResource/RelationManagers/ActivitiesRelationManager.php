<?php

namespace App\Filament\Resources\HR\EmployeeResource\RelationManagers;

use App\Models\HR\EmployeeActivity;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivitiesRelationManager extends RelationManager
{
    use OwnerableTrait;
    protected static string $relationship = 'activities';
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('lang.activities');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
           ->modelLabel(trans('lang.activities'))
            ->defaultSort('id','desc')
            ->recordTitleAttribute('employee.name')
            ->columns([
                static::Column(),
                Tables\Columns\TextColumn::make('type')->label(trans('lang.type'))
                    ->color(
                        function ($state) {
                            switch ($state) {
                                case 'punishment':
                                    return 'danger';
                                case 'advance':
                                    return 'warning';
                                case 'bonus':
                                    return 'primary';
                                default:
                                    return 'success';
                            }
                        }
                    )
                ->formatStateUsing(fn($state)=>EmployeeActivity::getTypes()[$state])->badge(),
                Tables\Columns\TextColumn::make('amount')
                    ->label(trans('lang.amount'))
                    ->numeric(fn($record)=>$record->currency->decimal,locale:'en')
                    ->suffix(fn($record)=>$record->currency->symbol)
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(trans('lang.date'))
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(trans('lang.user'))
                    ->numeric()
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
