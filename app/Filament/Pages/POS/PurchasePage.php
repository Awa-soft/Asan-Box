<?php

namespace App\Filament\Pages\POS;

use App\Models\Inventory\Category;
use App\Models\Inventory\Item;
use App\Models\POS\PurchaseInvoice;
use App\Models\Settings\Currency;
use App\Traits\Core\OwnerableTrait;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class PurchasePage extends Page implements HasForms
{
    use HasPageShield, InteractsWithForms, OwnerableTrait;
    protected static ?string $navigationIcon = 'iconpark-buy';
    public static function getNavigationLabel(): string
    {
        return trans('POS/lang.purchase.plural_label');
    }
    public  function getHeading(): string
    {
        return "";
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('POS/lang.group_label');
    }

    public $currencies, $items, $tableData = [], $selected = [], $categories = [], $selectedCategories = [], $codes = [], $key, $multipleSelect = false;
    public ?array $invoiceData = [];
    protected function getForms(): array
    {
        return [
            'invoiceForm',
        ];
    }
    public function invoiceForm(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make("type")
                    ->default('purchase'),
                TextInput::make('invoice_number')
                    ->readOnly()
                    ->default(PurchaseInvoice::InvoiceNumber()),
                TextInput::make('vendor_invoice'),
                DateTimePicker::make('date')
                    ->default(now())
                    ->required(),
                Select::make('branch_id')
                ->label(trans("Logistic/lang.branch.singular_label"))
                ->relationship("branch", "name")
                ->preload()
                ->searchable(),
                Select::make('contact_id')
                    ->relationship("contact", "name")
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('currency_id')
                ->default(1)
                    ->relationship("currency", "name")
                    ->preload()
                    ->live()
                    ->searchable()
                    ->required(),
                TextInput::make('balance')
                    ->disabled()
                    ->default(0),
                TextInput::make('discount')
                    ->required()
                    ->default(0),
                TextInput::make('total')
                    ->disabled()
                    ->default(0),
                TextInput::make('paid_amount')
                    ->required()
                    ->default(0),

            ])
            ->model(PurchaseInvoice::class)
            ->statePath('invoiceData')
            ->columns(5);
    }
    public function mount()
    {
        $this->currencies = Currency::all();
        $this->categories = Category::all();
        $this->items = Item::all();
        $this->invoiceForm->fill();

    }

    public function addToSelect($record)
    {
        if (in_array($record['id'], $this->selected)) {
            $key = array_search($record['id'], $this->selected);
            unset($this->selected[$key]);
            $this->invoiceData['total'] = collect($this->tableData)
            ->map(function($record) {
                return convertToCurrency(
                    $record['currency_id'],
                    $this->invoiceData['currency_id'],
                    $record[$record['type'] . '_price']
                );
            })
            ->sum();

            $this->refreshTable();
            return;
        }
        $this->selected[] = $record['id'];
        $this->refreshTable();
    }
    public function removeFromTable($key)
    {
        // remove from table with the given key
        unset($this->tableData[$key]);
        $this->refreshTable();
    }

    public function updated(){
        $this->refreshTable();
    }

    public function addToTable()
    {
        $records = $this->items->whereIn('id', $this->selected)->map(function ($record) {
            return [
                'id' => $record->id,
                'name' => $record->name,
                'single_price' => $record->single_price,
                'multiple_price' => $record->multiple_price,
                'quantity' => 1,
                "type" => 'single',
                "image" => $record->image,
                "currency_id" => 1,
                "gift" => 1,
                "codes" => []

            ];
        })->toArray();
        $this->tableData = array_merge($this->tableData, $records);
        $this->selected = [];
        $this->refreshTable();

    $this->refreshTable();
    }

    public function selectAll()
    {
        $this->selected = $this->items->pluck('id')->toArray();
    }

    public function deselectAll()
    {
        $this->selected = [];
    }

    public function selectCategory($record)
    {
        if (in_array($record, $this->selectedCategories)) {
            $key = array_search($record, $this->selectedCategories);
            unset($this->selectedCategories[$key]);
            $this->items = Item::when($this->selectedCategories, function ($q) {
                return $q->whereHas('category', function ($q) {
                    return $q->whereIn('id', $this->selectedCategories);
                });
            })->get();
            return;
        }
        $this->selectedCategories[] = $record;
        $this->items = Item::when($this->selectedCategories, function ($q) {
            return $q->whereHas('category', function ($q) {
                return $q->whereIn('id', $this->selectedCategories);
            });
        })->get();
    }


    public function openCodeModal($key){
        $this->codes = [];
        $this->codes = $this->tableData[$key]['codes'];
        $this->key = $key;
        $this->dispatch('open-modal',id:"code-modal");
    }

    public function addToCode(){
        $this->tableData[$this->key]['codes'][] = $this->codes;
        $this->codes = [];

        $this->refreshTable();
    }


    private function refreshTable(){
        $this->invoiceData['total'] = collect($this->tableData)
        ->map(function($record) {
            dump(convertToCurrency(
                1,
                2,
                100
            ));
            return convertToCurrency(
                $record['currency_id'],
                $this->invoiceData['currency_id'],
                $record[$record['type'] . '_price']
                *  collect($record['codes'])->where("gift", "no")->count()
            );
        })
        ->sum();

    $this->invoiceData['total'] = number_format(
        $this->invoiceData['total'],
        getCurrencyDecimal($this->invoiceData['currency_id'])
    );
    }


    public function submit(){
        dd($this->invoiceData);
    }
    protected static string $view = 'filament.pages.p-o-s.purchase-page';
}
