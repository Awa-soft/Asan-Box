<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\BoursePaymentResource\Pages;
use App\Filament\Resources\Finance\BoursePaymentResource\RelationManagers;
use App\Models\CRM\Bourse;
use App\Models\Finance\BoursePayment;
use App\Traits\Core\HasSoftDeletes;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoursePaymentResource extends Resource
{
    use HasSoftDeletes, HasTranslatableResource;
    protected static ?string $model = BoursePayment::class;

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
                Forms\Components\Select::make('bourse_id')
                    ->relationship('bourse', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (callable $set, callable $get) {
                        if ($get("bourse_id")) {
                            $set("balance", Bourse::find($get("bourse_id"))->balance);
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
                Tables\Columns\TextColumn::make('branch.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bourse.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->badge()
                    ->color(fn ($record) => $record->type == "debit" ? "danger" : 'success'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric(fn ($record) => $record->currency->decimal ?? 2)
                    ->sortable()
                    ->suffix(fn ($record) => $record->currency->symbol ?? '$'),
                Tables\Columns\TextColumn::make('base_currency')
                    ->numeric(
                        fn () => getBaseCurrency()->decimal ?? 2
                    )
                    ->state(
                        function ($record) {
                            return convertToCurrency($record->currency_id, getBaseCurrency()->id, $record->amount, $record->rate, getBaseCurrency()->rate);
                        }
                    )
                    ->suffix(
                        fn () => getBaseCurrency()->symbol ?? '$'
                    )
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('date')
                    ->date('Y-m-d')
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
            'index' => Pages\ListBoursePayments::route('/'),
            'create' => Pages\CreateBoursePayment::route('/create'),
            'edit' => Pages\EditBoursePayment::route('/{record}/edit'),
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
