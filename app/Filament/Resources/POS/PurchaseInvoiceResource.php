<?php

namespace App\Filament\Resources\POS;

use App\Filament\Resources\POS\PurchaseInvoiceResource\Pages;
use App\Filament\Resources\POS\PurchaseInvoiceResource\RelationManagers\DetailsRelationManager;
use App\Filament\Resources\POS\PurchaseInvoiceResource\RelationManagers\ExpensesRelationManager;
use App\Models\POS\PurchaseExpense;
use App\Models\POS\PurchaseInvoice;
use App\Models\Settings\Currency;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea ;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseInvoiceResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use HasTranslatableResource;

    protected static ?string $model = PurchaseInvoice::class;

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
                        return $record->type == 'purchase' ? 'success' : 'danger';
                    }),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vendor_invoice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date("Y-m-d")
                    ->sortable(),
                Tables\Columns\TextColumn::make('vendor.name_'.\Illuminate\Support\Facades\App::getLocale())
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contactPhone.phone')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->sortable()
                    ->numeric(fn($record)=>$record->currency->decimal,locale:'en')
                    ->suffix(fn($record)=>" ".$record->currency->symbol),
                Tables\Columns\TextColumn::make('total_expenses')
                    ->sortable()
                    ->numeric(fn($record)=>$record->currency->decimal,locale:'en')
                    ->suffix(fn($record)=>" ".$record->currency->symbol),
                Tables\Columns\TextColumn::make('paid_amount')
                    ->numeric(fn($record)=>$record->currency->decimal,locale:'en')
                    ->sortable()
                    ->suffix(fn($record)=>" ".$record->currency->symbol),
                Tables\Columns\TextColumn::make('codes')
                     ->state(fn($record)=>$record->codes_count)
                         ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                       Tables\Columns\TextColumn::make('item')
                           ->toggleable(isToggledHiddenByDefault: true)
                       ->state(fn($record)=>$record->items_count)
                    ->searchable(),


                Tables\Columns\TextColumn::make('rate')
                    ->numeric(locale:'en')
                    ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric(locale:'en')
                    ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric(locale:'en')
                    ->suffix(" %")
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
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
                Action::make("expense")
                ->action(function($record,$data){
                    $record->expenses()->create($data);
                })
                ->label(trans("lang.expense"))
                ->form([
                    Group::make([
                        TextInput::make("title")
                    ->label(trans("lang.title"))
                    ->required(),
                    Select::make("currency_id")
                    ->label(trans("lang.type"))
                    ->options(Currency::all()->pluck("name","id")->toArray())
                    ->searchable()
                    ->preload()
                    ->default(1)
                    ->required(),
                    TextInput::make("amount")
                    ->label(trans("lang.amount"))
                    ->numeric()
                    ->required()
                    ->columnSpanFull(),
                   Textarea::make("note")
                    ->columnSpanFull(),
                    FileUpload::make("attachement")
                    ->label(trans("lang.attachement"))
                    ->columnSpanFull(),
                    ])
                    ->columns(2)
                ])
                ->model(PurchaseExpense::class)
                ->modalWidth("lg"),
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
            DetailsRelationManager::class,
            ExpensesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseInvoices::route('/'),
            'create' => Pages\CreatePurchaseInvoice::route('/create'),
            'edit' => Pages\EditPurchaseInvoice::route('/{record}/edit'),
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
