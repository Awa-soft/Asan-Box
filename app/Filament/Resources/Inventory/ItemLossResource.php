<?php

namespace App\Filament\Resources\Inventory;

use App\Filament\Resources\Inventory\ItemLossResource\Pages;
use App\Filament\Resources\Inventory\ItemLossResource\RelationManagers;
use App\Models\Inventory\Item;
use App\Models\Inventory\ItemLoss;
use App\Models\POS\PurchaseDetailCode;
use App\Models\Settings\Currency;
use App\Traits\Core\HasSoftDeletes;
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

class ItemLossResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use HasTranslatableResource;
    use OwnerableTrait;

    protected static ?string $model = ItemLoss::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 12;

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
                        if(ItemLoss::where('code',$state)->count()==0 && PurchaseDetailCode::where('code',$state)->where('item_id',$get('item_id'))->count() != 0){
                            $set('cost',PurchaseDetailCode::where('code',$state)->where('item_id',$get('item_id'))->get()->first()?->price);
                        }
                    })
                    ->helperText(function ($state,Forms\Get $get){
                        if($state == null){
                            return null;
                        }
                        if(ItemLoss::where('code',$state)->count()>0){
                            return new HtmlString(trans('lang.losses_available',['code'=>$state]));
                        }
                        if(PurchaseDetailCode::where('code',$state)->where('item_id',$get('item_id'))->count() == 0){
                            return new HtmlString(trans('lang.code_not_found',['code'=>$state]));
                        }
                        return null;
                    })
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
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
                Forms\Components\DatePicker::make('date')->default(now())->required(),
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
                Tables\Columns\TextColumn::make('item.name_'.App::getLocale())
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([

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
            'index' => Pages\ManageItemLosses::route('/'),
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
