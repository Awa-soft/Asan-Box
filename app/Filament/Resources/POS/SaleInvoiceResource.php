<?php

namespace App\Filament\Resources\POS;

use App\Filament\Resources\POS\SaleInvoiceResource\Pages;
use App\Filament\Resources\POS\SaleInvoiceResource\RelationManagers\DetailsRelationManager;
use App\Models\POS\SaleInvoice;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleInvoiceResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use HasTranslatableResource;

    protected static ?string $model = SaleInvoice::class;

    protected static ?string $navigationIcon = 'vaadin-invoice';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('branch_id')
                ->relationship('branch', 'name')
                ->required(),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255)
                    ->default('purchase'),
                Forms\Components\TextInput::make('invoice_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('vendor_invoice')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('paid_amount')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\Select::make('contact_id')
                    ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale())
                    ->required(),
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'name')
                    ->required(),
                Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('balance')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->suffix(" %")
                    ->default(0.00),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
            ->columns([
             Tables\Columns\TextColumn::make('branch.name')
                    ->numeric()
                    ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->badge()
                    ->color(function($record){
                        return $record->type == 'sale' ? 'success' : 'danger';
                    }),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                       Tables\Columns\TextColumn::make('codes')
                     ->state(fn($record)=>$record->codes_count)
                    ->searchable(),
                       Tables\Columns\TextColumn::make('item')
                       ->state(fn($record)=>$record->items_count)
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date("Y-m-d")
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->sortable()
                    ->numeric(fn($record)=>$record->currency->decimal,locale:'en')
                    ->suffix(fn($record)=>" ".$record->currency->symbol),
                Tables\Columns\TextColumn::make('paid_amount')
                    ->numeric(fn($record)=>$record->currency->decimal,locale:'en')
                    ->sortable()
                    ->suffix(fn($record)=>" ".$record->currency->symbol),
                Tables\Columns\TextColumn::make('contact.name_'.\Illuminate\Support\Facades\App::getLocale())
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate')
                    ->numeric()
                    ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric()
                    ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric()
                    ->suffix(" %")
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),

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
                Action::make("receipt")
                ->url(fn($record)=>static::getUrl('receipt', [
                    'record' => $record->id
                ]))

                ->label(trans("lang.receipt"))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DetailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseInvoices::route('/'),
            'create' => Pages\CreatePurchaseInvoice::route('/create'),
            'edit' => Pages\EditPurchaseInvoice::route('/{record}/edit'),
            'receipt' => Pages\Receipt::route('/{record}/receipt'),
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
