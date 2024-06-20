<?php

namespace App\Filament\Resources\Inventory;

use App\Filament\Resources\Inventory\ItemResource\Pages;
use App\Filament\Resources\Inventory\ItemResource\RelationManagers;
use App\Models\Inventory\Item;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    use OwnerableTrait;
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-s-cube';
    public static function getModelLabel(): string
    {
        return trans('Inventory/lang.item.plural_label');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('Inventory/lang.item.singular_label');
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('Inventory/lang.group_label');
    }
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::Field(),
                Forms\Components\TextInput::make('name')
                    ->label(trans("lang.name"))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label(trans("lang.description"))
                    ->maxLength(255),
                Forms\Components\TextInput::make('barcode')
                    ->label(trans("lang.barcode"))
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->label(trans("lang.category"))
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionForm(fn (Form $form) => CategoryResource::form($form))

                    ->required(),
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->label(trans("lang.brand"))
                    ->required()
                    ->createOptionForm(fn (Form $form) => BrandResource::form($form))
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('single_unit_id')
                    ->label(trans("lang.single_unit"))
                    ->relationship('singleUnit', 'name')
                    ->required()
                    ->createOptionForm(fn (Form $form) => UnitResource::form($form))
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('multiple_unit_id')
                    ->relationship('multiUnit', 'name')
                    ->required()
                    ->createOptionForm(fn (Form $form) => UnitResource::form($form))
                    ->label(trans("lang.multiple_unit"))
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('single_price')
                    ->label(trans("lang.single_price"))
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('multiple_price')
                    ->label(trans("lang.multiple_price"))
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('benifit_ratio')
                    ->label(trans("lang.benifit_ratio"))
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('multi_quantity')
                    ->label(trans("lang.multi_quantity"))
                    ->required()
                    ->numeric()
                    ->default(1.00),
                Forms\Components\DatePicker::make('expire_date')
                    ->label(trans("lang.expire_date")),
                Forms\Components\FileUpload::make('image')
                    ->label(trans("lang.image"))
                    ->image()
                    ->directory("inventory/items"),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                static::Column(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->label(trans("lang.image"))
                    ->size(80)
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans("lang.name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(trans("lang.description"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->label(trans("lang.barcode"))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->label(trans("lang.category"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->label(trans("lang.brand"))
                    ->sortable(),

                ViewColumn::make('price')->view('tables.columns.price-column')
                    ->state(function ($record) {
                        return $record;
                    })
                    ->label(trans("lang.price")),

                Tables\Columns\TextColumn::make('multi_quantity')
                    ->label(trans("lang.multi_quantity"))
                    ->suffix(fn ($record) => " " . $record->singleUnit->name)
                    ->description(fn ($record) => $record->multiUnit->name)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('benifit_ratio')
                    ->numeric()
                    ->label(trans("lang.benifit_ratio"))
                    ->suffix("%")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('expire_date')
                    ->label(trans("lang.expire_date"))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\ReplicateAction::make(),
                Tables\Actions\EditAction::make()
                    ->modalWidth("lg"),
                Tables\Actions\DeleteAction::make(),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
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
