<?php

namespace App\Filament\Resources\Inventory;

use App\Filament\Resources\Inventory\ItemResource\Pages;
use App\Filament\Resources\Inventory\ItemResource\RelationManagers;
use App\Filament\Resources\Inventory\ItemResource\RelationManagers\CodesRelationManager;
use App\Models\Inventory\Item;
use App\Traits\Core\HasTranslatableResource;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

class ItemResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use OwnerableTrait;
    use HasTranslatableResource;

    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-s-cube';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_en')
                    ->label(trans("lang.name_en"))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_ar')
                    ->label(trans("lang.name_ar"))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_ckb')
                    ->label(trans("lang.name_ckb"))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label(trans("lang.description"))
                    ->maxLength(255),
                Forms\Components\TextInput::make('barcode')
                    ->label(trans("lang.barcode"))
                    ->maxLength(255)
                    ->hidden(),
                Forms\Components\Select::make('category_id')
                    ->label(trans("lang.category"))
                    ->relationship('category', 'name',modifyQueryUsing: function($query){
                        return $query->where('status','0');
                })
                    ->preload()
                    ->searchable()
                    ->createOptionForm(fn (Form $form) => CategoryResource::form($form))
                    ->required(),
                Forms\Components\Select::make('unit_id')
                    ->label(trans("lang.unit"))
                    ->relationship('unit', 'name',modifyQueryUsing: function($query){
                        return $query->where('status','0');
                    })
                    ->preload()
                    ->searchable()
                    ->createOptionForm(fn (Form $form) => CategoryResource::form($form))
                    ->required(),
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name',modifyQueryUsing: function($query){
                        return $query->where('status','0');
                    })
                    ->label(trans("lang.brand"))
                    ->required()
                    ->createOptionForm(fn (Form $form) => BrandResource::form($form))
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('min_price')
                    ->suffix(getBaseCurrency()->symbol)
                    ->label(trans("lang.min_price"))
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('max_price')
                    ->label(trans("lang.max_price"))
                    ->suffix(getBaseCurrency()->symbol)
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('installment_min')
                    ->required()
                    ->suffix(getBaseCurrency()->symbol)
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('installment_max')
                    ->required()
                    ->suffix(getBaseCurrency()->symbol)
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('discount')
                    ->label(trans("lang.benifit_ratio"))
                    ->required()
                    ->prefix("%")
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('benifit_ratio')
                    ->label(trans("lang.benifit_ratio"))
                    ->required()
                    ->prefix("%")
                    ->numeric()
                    ->default(0),
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
            ->recordUrl('')
            ->defaultSort('id','desc')


            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->label(trans("lang.image"))
                    ->size(80)
                    ->circular(),
                Tables\Columns\TextColumn::make('name_'.App::getLocale())
                    ->label(trans("lang.name"))
                    ->description(fn($record)=>$record->description)
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(trans("lang.description"))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cost')
                    ->label(trans("lang.cost"))
                    ->numeric(getBaseCurrency()->decimal,locale: 'en')
                    ->suffix(
                        " ".getBaseCurrency()->symbol
                    ),
                Tables\Columns\TextColumn::make('barcode')
                    ->label(trans("lang.barcode"))
                    ->searchable()
                    ->hidden()
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
                        return "price";
                    })
                    ->label(trans("lang.price")),
                ViewColumn::make('installment')->view('tables.columns.price-column')
                    ->state(function ($record) {
                        return "installment";
                    })
                    ->label(trans("lang.price")),
                Tables\Columns\TextColumn::make('benifit_ratio')
                    ->numeric(2,locale:'en')
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
                Tables\Filters\TrashedFilter::make()
                ->native(0),
            ])
            ->actions([


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
