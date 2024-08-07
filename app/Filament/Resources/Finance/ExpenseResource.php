<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\ExpenseResource\Pages;
use App\Filament\Resources\Finance\ExpenseResource\RelationManagers;
use App\Models\Finance\Expense;
use App\Models\Settings\Currency;
use App\Traits\Core\HasCreateAnother;
use App\Traits\Core\HasTranslatableResource;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;
    use HasTranslatableResource;
    use OwnerableTrait;
    use HasCreateAnother;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 38;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               static::Field()->columnSpanFull(),
                static::selectField('expense_type_id',ExpenseTypeResource::class)
                    ->relationship('expenseType', 'type')
                    ->required(),
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'name')
                    ->default(1)
                    ->native(0)
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->suffix(fn(Forms\Get $get)=>Currency::find($get('currency_id'))?->symbol??'$')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('date')
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('note')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
            ->columns([
                static::Column(),
                Tables\Columns\TextColumn::make('expenseType.type')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->suffix(fn($record)=>$record->currency->symbol)
                    ->numeric(fn($record)=>$record->currency->decmal,locale: 'en')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageExpenses::route('/'),
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
