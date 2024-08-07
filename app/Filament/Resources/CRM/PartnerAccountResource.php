<?php

namespace App\Filament\Resources\CRM;

use App\Filament\Resources\CRM\PartnerAccountResource\Pages;
use App\Filament\Resources\CRM\PartnerAccountResource\RelationManagers;
use App\Models\CRM\PartnerAccount;
use App\Models\CRM\Partnership;
use App\Traits\Core\HasCreateAnother;
use App\Traits\Core\HasTranslatableResource;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerAccountResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use HasCreateAnother;
    use HasTranslatableResource;
    protected static ?string $model = PartnerAccount::class;

    protected static ?string $navigationIcon = 'iconoir-percent-rotate-out';
    protected static ?int $navigationSort = 32;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::selectField('partnership_id',PartnershipResource::class)
                    ->relationship('partnership', 'id')
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        $data = $record->start_date;
                        if($record->end_date != null){
                            $data = $record->start_date.' - '.$record->end_date;
                        }
                        return $data;
                    })
                    ->label(trans('CRM/lang.partnership.singular_label'))
                    ->live()
                    ->required(),
                static::selectField('partner_id',PartnerResource::class)
                    ->relationship('partner', 'name',modifyQueryUsing: function (Forms\Get $get,$query){
                        return $query->whereHas('branches',function ($query)use($get){
                            return $query->where('branch_id',Partnership::find($get('partnership_id'))?->branch_id);
                        });
                    })
                    ->label(trans('CRM/lang.partner.singular_label'))
                    ->searchable()
                    ->preload()

                    ->required(),
                Forms\Components\TextInput::make('percent')
                    ->required()
                    ->label(trans('lang.percent'))
                    ->numeric(),


            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
            ->columns([
                Tables\Columns\TextColumn::make('partnershipAll.name')
                    ->label(trans('CRM/lang.partnership.singular_label'))
                    ->numeric(),
                Tables\Columns\TextColumn::make('status')
                    ->label(trans('lang.status'))
                    ->badge()
                    ->color(fn($state)=>$state == trans('lang.active') ? 'success':'danger'),
                Tables\Columns\TextColumn::make('partner.name')
                    ->label(trans('CRM/lang.partner.singular_label'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('percent')
                    ->label(trans('lang.percent'))
                    ->suffix('%')

                    ->numeric(2,locale:'en')
                    ->sortable(),
                Tables\Columns\TextColumn::make('balance')
                    ->label(trans('lang.balance'))
                    ->suffix(getBaseCurrency()->symbol)
                    ->numeric(getBaseCurrency()->decimal,locale:'en'),
                Tables\Columns\TextColumn::make('profit')
                    ->label(trans('lang.profit'))
                    ->suffix(getBaseCurrency()->symbol)
                    ->numeric(getBaseCurrency()->decimal,locale:'en'),
                Tables\Columns\TextColumn::make('partnership.branch.name')
                    ->label(trans("Logistic/lang.branch.singular_label"))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(trans('Settings/lang.user.singular_label'))
                    ->numeric()
                    ->sortable(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListPartnerAccounts::route('/'),
//            'create' => Pages\CreatePartnerAccount::route('/create'),
//            'edit' => Pages\EditPartnerAccount::route('/{record}/edit'),
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
