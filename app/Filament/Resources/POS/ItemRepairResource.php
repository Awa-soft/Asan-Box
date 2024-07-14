<?php

namespace App\Filament\Resources\POS;

use App\Filament\Resources\POS\ItemRepairResource\Pages;
use App\Filament\Resources\POS\ItemRepairResource\RelationManagers;
use App\Models\Inventory\ItemLoss;
use App\Models\POS\ItemRepair;
use App\Models\POS\PurchaseDetailCode;
use App\Models\Settings\Currency;
use App\Traits\Core\HasTranslatableResource;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;

class ItemRepairResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use HasTranslatableResource;
    use OwnerableTrait;
    protected static ?string $model = ItemRepair::class;

    protected static ?string $navigationIcon = 'rpg-repair';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::Field()->columnSpanFull(),
                Forms\Components\Select::make('item_id')
                    ->relationship('item', 'name_'.App::getLocale())
                    ->afterStateUpdated(function (Forms\Set $set,$state){
                        $set('code',null);
                        $set('cost',null);
                    })
                    ->live()
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->live()
                    ->afterStateUpdated(function ($state,Forms\Set $set,Forms\Get $get){
                            $set('cost',PurchaseDetailCode::where('code',$state)->where('item_id',$get('item_id'))->get()->first()?->price);
                    })
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options(static::$model::getTypes())
                    ->required()
                    ->native(0),
                Forms\Components\TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->prefix(fn(Forms\Get $get)=>Currency::find($get('currency_id'))?->symbol),
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'name')
                    ->live()
                    ->default(1)
                    ->native(0)
                    ->required(),
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
                static::Column(),
                Tables\Columns\TextColumn::make('item.name_'.\Illuminate\Support\Facades\App::getLocale())
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn($state)=>static::$model::getTypes()[$state]),
                Tables\Columns\TextColumn::make('cost')
                    ->suffix(fn ($record)=>' ' . $record->currency->symbol)
                    ->numeric(fn($record)=>$record->currency->decimal,locale: 'en')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageItemRepairs::route('/'),
        ];
    }
}
