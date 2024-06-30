<?php

namespace App\Filament\Resources\POS;

use App\Filament\Resources\POS\PurchaseOrderResource\Pages;
use App\Filament\Resources\POS\PurchaseOrderResource\RelationManagers;
use App\Models\POS\PurchaseOrder;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseOrderResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use HasTranslatableResource;
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $navigationIcon = 'iconpark-order';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->hidden(auth()->user()->ownerable_type == 'App\Models\Logistic\Branch')
                    ->live()
                    ->afterStateUpdated(function ($state,Forms\Set $set){
                        $set('invoice_number',static::$model::getInvoiceNumber($state));
                    })
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('invoice_number')
                    ->default(function (){
                        if(auth()->user()->ownerable_type == 'App\Models\Logistic\Branch'){
                            return static::$model::getInvoiceNumber(auth()->user()->ownerable_id);
                        }
                        return null;
                    })
                    ->disabled()
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
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->searchable()
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch.name')
                    ->searchable()
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
            RelationManagers\DetailRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
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
