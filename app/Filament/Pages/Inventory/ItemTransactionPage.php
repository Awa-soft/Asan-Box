<?php

namespace App\Filament\Pages\Inventory;

use App\Models\Inventory\ItemTransaction;
use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
use App\Traits\Core\TranslatableForm;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class ItemTransactionPage extends Page implements HasForms
{
    use TranslatableForm;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public ?array $data = [];
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                MorphToSelect::make('fromable')
                    ->types([
                        MorphToSelect\Type::make(Branch::class)
                            ->titleAttribute('name'),
                        MorphToSelect\Type::make(Warehouse::class)
                            ->titleAttribute('name'),
                    ])
                    ->native(0),
                MorphToSelect::make('fromable')
                    ->types([
                        MorphToSelect\Type::make(Branch::class)
                            ->titleAttribute('name'),
                        MorphToSelect\Type::make(Warehouse::class)
                            ->titleAttribute('name'),
                    ])
                    ->native(0),
            ])
            ->model(ItemTransaction::class)
            ->columns(2)
            ->statePath('data');
    }

    protected static string $view = 'filament.pages.inventory.item-transaction-page';
}
