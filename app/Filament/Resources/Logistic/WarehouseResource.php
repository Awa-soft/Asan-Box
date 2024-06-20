<?php

namespace App\Filament\Resources\Logistic;

use App\Filament\Resources\Logistic\WarehouseResource\Pages;
use App\Filament\Resources\Logistic\WarehouseResource\RelationManagers;
use App\Models\Logistic\Warehouse;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;
    use HasTranslatableResource;


    protected static ?string $navigationIcon = 'fas-warehouse';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans('lang.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label(trans('lang.address'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(trans('lang.phone'))
                    ->tel()
                    ->unique(ignoreRecord:true)
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(trans('lang.email'))
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('longitude')
                    ->label(trans('lang.longitude'))
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('latitude')
                    ->label(trans('lang.latitude'))
                    ->maxLength(255)
                    ->default(null),
                    Forms\Components\Toggle::make('status')
->visible(fn($operation)=>$operation == "edit")
->default(1)
                    ->label(trans('lang.status'))
                    ->visible(fn($operation)=>$operation == "edit"),
                // Forms\Components\Select::make('branches')
                //     ->relationship('branches', 'name')
                //     ->label(trans('lang.branches'))
                //     ->searchable()
                //     ->multiple()
                //     ->preload(),
                Forms\Components\FileUpload::make('image')
                    ->label(trans('lang.image'))
                    ->avatar()
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
->circular()
                    ->label(trans('lang.image'))
                    ->size(100),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('lang.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(trans('lang.address'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans('lang.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('branches.name')
                    ->label(trans('Logistic/lang.branch.plural_label'))
                    ->listWithLineBreaks()
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(trans('lang.email'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->label(trans('lang.longitude'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->label(trans('lang.latitude'))
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label(trans('lang.status'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(trans('lang.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('lang.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('lang.updated_at'))
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
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     // Tables\Actions\ForceDeleteBulkAction::make(),
                //     // Tables\Actions\RestoreBulkAction::make(),
                // ]),
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
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
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
