<?php

namespace App\Filament\Resources\CRM;

use App\Filament\Resources\CRM\BourseResource\Pages;
use App\Filament\Resources\CRM\BourseResource\RelationManagers;
use App\Models\CRM\Bourse;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BourseResource extends Resource
{
    use OwnerableTrait;
    protected static ?string $model = Bourse::class;


    protected static ?string $navigationIcon = 'fluentui-building-retail-money-20';
    public static function getModelLabel(): string
    {
        return trans('CRM/lang.bourse.plural_label');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('CRM/lang.bourse.singular_label');
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('CRM/lang.group_label');
    }
    protected static ?int $navigationSort = 4;
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
                Forms\Components\TextInput::make('email')
                    ->label(trans("lang.email"))
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label(trans("lang.address"))
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label(trans("lang.image"))
                    ->directory("bourses/image"),
                    static::Field(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->size(80)
                    ->label(trans("lang.image")),
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
            'index' => Pages\ListBourses::route('/'),
            'create' => Pages\CreateBourse::route('/create'),
            'edit' => Pages\EditBourse::route('/{record}/edit'),
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
