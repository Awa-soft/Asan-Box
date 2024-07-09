<?php

namespace App\Filament\Resources\CRM;

use App\Filament\Resources\CRM\BothResource\Pages;
use App\Filament\Resources\CRM\BothResource\RelationManagers;
use App\Models\CRM\Both;
use App\Models\CRM\Contact;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BothResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use OwnerableTrait;
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'simpleline-people';
    public static function getModelLabel(): string
    {
        return trans('CRM/lang.both.plural_label');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('CRM/lang.both.singular_label');
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('CRM/lang.group_label');
    }
    protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(trans("lang.phone"))
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(trans("lang.email"))
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label(trans("lang.address"))
                    ->maxLength(255),
                Forms\Components\Hidden::make('type')
                    ->default('Both'),
                Forms\Components\TextInput::make('payment_duration')
                    ->label(trans("lang.payment_duration"))
                    ->numeric(),
                Forms\Components\TextInput::make('max_debt')
                    ->label(trans("lang.max_debt"))
                    ->numeric(),
                Forms\Components\Toggle::make('status')
                    ->visible(fn ($operation) => $operation == "edit")
                    ->default(1)
                    ->label(trans("lang.status"))
                    ->required(),
                static::Field(),
                Forms\Components\FileUpload::make('image')
                    ->label(trans('lang.image'))
                    ->directory("customers/image")
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                static::Column(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->label(trans("lang.image"))
                    ->size(100),

                Tables\Columns\TextColumn::make('name')
                    ->label(trans("lang.name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans("lang.phone"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(trans("lang.email"))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->label(trans("lang.address"))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('payment_duration')
                    ->label(trans("lang.payment_duration"))
                    ->numeric()
                    ->suffix(trans('lang.day'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_debt')
                    ->label(trans("lang.max_debt"))
                    ->numeric()
                    ->suffix(fn($record) => " ".getBaseCurrency()->symbol)
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label(trans("lang.status")),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label(trans("Logistic/lang.branch.singular_label"))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(trans("lang.user"))
                    ->numeric()
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
                Tables\Actions\Action::make('statement')
                ->label(trans('lang.statement_action'))
                ->form([
                    Forms\Components\DatePicker::make('from')
                        ->label(trans('lang.from')),
                    Forms\Components\DatePicker::make('to')
                        ->label(trans('lang.to')),

                ])->action(function(array $data,$record){
                    if(!$data['from']){
                        $data['from'] = 'all';
                    }
                    if(!$data['to']){
                        $data['to'] = 'all';
                    }
                        redirect(static::getUrl('statement',['record' => $record->id, 'from' => $data['from'], 'to' => $data['to']]));
                    })->icon('tabler-report')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListBoths::route('/'),
            'create' => Pages\CreateBoth::route('/create'),
            'edit' => Pages\EditBoth::route('/{record}/edit'),
            'statement'=>Pages\Statement::route('{record}/{from}/{to}/statement'),

        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->both();
    }
}
