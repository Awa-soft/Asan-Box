<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\PaymentResource\Pages;
use App\Filament\Resources\Finance\PaymentResource\RelationManagers;
use App\Models\CRM\Contact;
use App\Models\Finance\Payment;
use App\Traits\Core\HasSoftDeletes;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

class PaymentResource extends Resource
{
    use HasSoftDeletes, HasTranslatableResource;

    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('invoice_number')
                ->required()
                ->readOnly()
                ->default(static::$model::InvoiceNumber()),
                Forms\Components\Select::make('branch_id')
                ->relationship('branch', 'name')
                ->required()
                ->searchable()
                ->preload(),
            Forms\Components\Select::make('contact_id')
                ->relationship('contact', 'name_'.App::getLocale(),modifyQueryUsing: function ($query){
                    return $query->where('status',1);
                })
                ->getOptionLabelFromRecordUsing(fn($record)=> "$record->name_ckb - $record->phone" )
                ->required()
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function (callable $set, callable $get) {
                    if ($get("contact_id")) {
                        $set("balance", number_format(Contact::find($get("contact_id"))->balance, getBaseCurrency()->decimal,'.',''));
                    }
                }),
            Forms\Components\TextInput::make('balance')
                ->required()
                ->readOnly(),
            Forms\Components\Select::make('currency_id')
                ->relationship('currency', 'symbol')
                ->required()
                ->searchable()
                ->preload(),

            Forms\Components\Select::make('type')
                ->options(
                    self::$model::getTypes()
                )
                ->required()
                ->native(0),

            Forms\Components\TextInput::make('amount')
                ->required()
                ->numeric(),
            Forms\Components\Hidden::make('balance'),
            Forms\Components\DatePicker::make('date')
                ->required(),
            Forms\Components\FileUpload::make('attachment')
                ->directory("bourse_payments"),
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
                Tables\Columns\TextColumn::make('contact.name_'.\Illuminate\Support\Facades\App::getLocale())
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attachment')
                    ->searchable(),
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
                Tables\Actions\Action::make('print')
                    ->label(trans('lang.print'))
                   ->action(function($record){
                        redirect(static::getUrl('print',['record' => $record->id]));
                    })->icon('tabler-printer')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
            'print'=>Pages\Invoice::route('{record}/print')
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
