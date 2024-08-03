<?php

namespace App\Filament\Resources\HR\EmployeeResource\RelationManagers;

use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeavesRelationManager extends RelationManager
{
    use OwnerableTrait;
    protected static string $relationship = 'leaves';
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('lang.leaves');
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee.name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
           ->modelLabel( trans('lang.leaves'))
            ->defaultSort('id','desc')
            ->recordTitleAttribute('employee.name')
            ->columns([
                static::Column(),
                Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(function($state){
                    if($state == 'pending'){
                        return 'warning';
                    }
                    if($state == 'approved'){
                        return 'success';
                    }
                    if($state == 'rejected'){
                        return 'danger';
                    }
                }),
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->label(trans('lang.employee'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('from')
                    ->dateTime()
                    ->label(trans('lang.from'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('to')
                    ->dateTime()
                    ->label(trans('lang.to'))
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
