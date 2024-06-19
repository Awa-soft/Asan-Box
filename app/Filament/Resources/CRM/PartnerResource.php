<?php

namespace App\Filament\Resources\CRM;

use App\Filament\Resources\CRM\PartnerResource\Pages;
use App\Filament\Resources\CRM\PartnerResource\RelationManagers;
use App\Models\CRM\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'carbon-partnership';
    public static function getModelLabel(): string
    {
        return trans('CRM/lang.partner.plural_label');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('CRM/lang.partner.singular_label');
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('CRM/lang.group_label');
    }
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label(trans("lang.name"))
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('phone')
                ->label(trans("lang.phone"))
                ->tel()
                ->maxLength(255),

            Forms\Components\TextInput::make('address')
                ->label(trans("lang.address"))
                ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                ->label(trans("lang.image"))
                ->directory("bourses/image"),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
->circular()
                ->label(trans("lang.image")),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans("lang.name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans("lang.phone"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(trans("lang.address"))
                    ->searchable(),
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
                Tables\Actions\EditAction::make()
->modalWidth("lg"),
                Tables\Actions\DeleteAction::make(),

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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
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
