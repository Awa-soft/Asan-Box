<?php

namespace App\Filament\Resources\POS;

use App\Filament\Resources\POS\PurchaseExpenseResource\Pages;
use App\Filament\Resources\POS\PurchaseExpenseResource\RelationManagers;
use App\Models\POS\PurchaseExpense;
use App\Models\Settings\Currency;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseExpenseResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    protected static ?string $model = PurchaseExpense::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    use HasTranslatableResource;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('purchase_invoice_id')
                    ->relationship('invoice', 'invoice_number')
                    ->searchable()
                    ->preload()
                    ->default(1)
                    ->required(),
                    TextInput::make("title")
                    ->label(trans("lang.title"))
                    ->required(),
                    Select::make("currency_id")
                    ->label(trans("lang.type"))
                    ->relationship("currency", "symbol")
                    ->searchable()
                    ->preload()
                    ->default(1)
                    ->required(),
                    TextInput::make("amount")
                    ->label(trans("lang.amount"))
                    ->numeric()
                    ->required(),
                   Textarea::make("note")
                    ->columnSpanFull(),
                    FileUpload::make("attachement")
                    ->label(trans("lang.attachement"))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
            ->columns([
                Tables\Columns\TextColumn::make('invoice.invoice_number')
                    ->numeric()
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                ->sortable()
                ->numeric(fn($record)=>$record->currency->decimal,locale:'en')
                ->suffix(fn($record)=>" ".$record->currency->symbol),


                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
                Tables\Columns\TextColumn::make('attachement')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseExpenses::route('/'),
            // 'create' => Pages\CreatePurchaseExpense::route('/create'),
            // 'edit' => Pages\EditPurchaseExpense::route('/{record}/edit'),
        ];
    }
}
