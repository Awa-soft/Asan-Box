<?php

namespace App\Filament\Resources\Logistic;

use App\Filament\Resources\Logistic\BranchResource\Pages;
use App\Filament\Resources\Logistic\BranchResource\RelationManagers;
use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
use App\Traits\Core\HasTranslatableResource;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\SelectAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BranchResource extends Resource
{
    use HasTranslatableResource;

    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'fas-code-branch';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans('lang.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label(trans('lang.address'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(trans('lang.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(trans('lang.email'))
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('longitude')
                    ->label(trans('lang.longitude'))
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('latitude')
                    ->label(trans('lang.latitude'))
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('status')
->visible(fn($operation)=>$operation == "edit")
->default(1)
                    ->label(trans('lang.status'))
                    ->visible(fn ($operation) => $operation == "edit"),
                Forms\Components\Section::make(trans('lang.images'))
                    ->schema([
                        Forms\Components\FileUpload::make('receipt_header')
                            ->label(trans('lang.receipt_header'))
                            ->image()
                            ->required(),
                        Forms\Components\FileUpload::make('receipt_footer')
                            ->label(trans('lang.receipt_footer'))
                            ->image()
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->label(trans('lang.image'))
                            ->avatar()
                            ->image(),
                    ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
->circular()
                    ->label(trans('lang.image'))
                    ->size(100),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('lang.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(trans('lang.address'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans('lang.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('warehouses.name')
                    ->label(trans('Logistic/lang.warehouse.plural_label'))
                    ->listWithLineBreaks()
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->label(trans('lang.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->label(trans('lang.longitude'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->label(trans('lang.latitude'))
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label(trans('lang.status'))
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
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
->modalWidth("lg"),
                    Tables\Actions\Action::make('warehouses')
                        ->modalWidth("lg")
                        ->form(
                            function ($record) {
                                return [
                                    Select::make('warehouses')
                                        ->options(Warehouse::all()->pluck("name", "id")->toArray())
                                        ->default($record->warehouses->pluck("id")->toArray())
                                        ->label(trans('lang.warehouses'))
                                        ->searchable()
                                        ->multiple()
                                        ->preload()
                                ];
                            }
                        )
                        ->color(Color::Emerald)
                        ->icon("fas-warehouse")
                        ->action(function ($data, $record) {
                            $record->warehouses()->sync($data['warehouses']);
                            Notification::make()
                                ->success()
                                ->title(trans("filament-actions::edit.single.notifications.saved.title"))
                                ->send();
                        }),
                        Tables\Actions\DeleteAction::make(),

                ])
                    ->icon('css-more-o'),

            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     // Tables\Actions\DeleteBulkAction::make(),
                //     // Tables\Actions\ForceDeleteBulkAction::make(),
                //     // Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ]);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
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
