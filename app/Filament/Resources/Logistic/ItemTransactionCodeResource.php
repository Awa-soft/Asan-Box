<?php

namespace App\Filament\Resources\Logistic;

use App\Models\Logistic\ItemTransactionCode;
use App\Traits\Core\HasTranslatableResource;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\App;

class ItemTransactionCodeResource extends Resource
{
    use HasTranslatableResource;
    protected static ?string $model = ItemTransactionCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
            ->columns([
                Tables\Columns\TextColumn::make('itemTransactionDetail.item.name_'.App::getLocale())
                    ->label(trans('Inventory/lang.item.singular_label'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('itemTransactionDetail.invoice.fromable.name')
                    ->label(trans('lang.from'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('itemTransactionDetail.invoice.toable.name')
                    ->label(trans('lang.to'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label(trans('lang.code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(trans('lang.status'))
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn($state)=>trans('lang.'.$state))
                    ->color(fn($state)=>$state == 'pending'?Color::Amber:($state == 'rejected'?'danger':'success')),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(trans('lang.user'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_date')
                    ->label(trans('lang.status_date'))
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('lang.created_at'))
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('lang.updated_at'))
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->actions([
                Tables\Actions\Action::make('accept')
                    ->label(trans('lang.accept'))
                    ->hidden(fn ($record)=>$record->status == 'accepted')
                    ->action(fn($record)=>$record->update([
                        'status'=>'accepted',
                    ]))->color('success'),
                Tables\Actions\Action::make('reject')
                    ->label(trans('lang.reject'))
                    ->hidden(fn ($record)=>$record->status == 'rejected')
                    ->action(fn($record)=>$record->update([
                        'status'=>'rejected',
                    ]))->color('danger'),
                ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\Logistic\ItemTransactionCodeResource\Pages\ManageItemTransactionCodes::route('/'),
        ];
    }
}
