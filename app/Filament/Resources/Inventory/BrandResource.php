<?php

namespace App\Filament\Resources\Inventory;

use App\Filament\Resources\Inventory\BrandResource\Pages;
use App\Filament\Resources\Inventory\BrandResource\RelationManagers;
use App\Filament\Resources\Inventory\BrandResource\RelationManagers\ItemsRelationManager;
use App\Models\Inventory\Brand;
use App\Traits\Core\OwnerableTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrandResource extends Resource
{
    use OwnerableTrait;
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'fas-b';

    public static function getModelLabel(): string
    {
        return trans('Inventory/lang.brand.plural_label');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('Inventory/lang.brand.singular_label');
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('Inventory/lang.group_label');
    }
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans('lang.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->visible(fn ($operation) => $operation == "edit")
                    ->default(1)
                    ->label(trans('lang.status'))
                    ->required()
                    ->visible(fn ($operation) => $operation == "edit"),
                Forms\Components\FileUpload::make('logo')
                    ->label(trans("lang.image"))
                    ->image()
                    ->directory("inventory/brands"),
                    static::Field(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->circular()
                    ->size(80)
                    ->label(trans("lang.image")),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('lang.name'))
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label(trans('lang.status')),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('primary'),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->icon('css-more-o')

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
            ItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            // 'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
            'view' => Pages\ViewBrand::route('/{record}'),

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
