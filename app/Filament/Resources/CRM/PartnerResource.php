<?php

namespace App\Filament\Resources\CRM;

use App\Filament\Resources\CRM\PartnerResource\Pages;
use App\Filament\Resources\CRM\PartnerResource\RelationManagers;
use App\Filament\Resources\Logistic\BranchResource;
use App\Models\CRM\Partner;
use App\Traits\Core\HasCreateAnother;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerResource extends Resource
{
    use \App\Traits\Core\HasSoftDeletes;
    use HasTranslatableResource;
    use HasCreateAnother;
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'carbon-partnership';
    protected static ?int $navigationSort = 33;

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
                static::selectField('branches',BranchResource::class)
                    ->relationship('branches','name')
                    ->preload()
                    ->searchable()
                    ->multiple(),
                Forms\Components\FileUpload::make('image')
                ->label(trans("lang.image"))
                ->directory("bourses/image"),
            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->recordUrl('')
            ->defaultSort('id','desc')
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
                Tables\Columns\TextColumn::make('branches.name')
                    ->listWithLineBreaks()
                    ->badge()
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
                Tables\Filters\TrashedFilter::make()
                ->native(0),
            ])
            ->actions([


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
