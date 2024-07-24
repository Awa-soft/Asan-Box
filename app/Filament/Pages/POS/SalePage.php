<?php

namespace App\Filament\Pages\POS;

use App\Models\Inventory\Category;
use App\Models\Inventory\Item;
use App\Models\POS\SaleInvoice;
use App\Models\Settings\Currency;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Exception;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Filament\Notifications\Notification;

class SalePage extends Page implements HasForms
{
    use HasPageShield, InteractsWithForms;
    public $activeTab = 'sale_tab_1';
    protected static ?string $navigationIcon = 'mdi-point-of-sale';
    public static function getNavigationLabel(): string
    {
        return trans('POS/lang.sale_pos.singular_label');
    }
    public  function getHeading(): string
    {
        return "";
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('POS/lang.group_label');
    }

    public $currencies, $tabs = 1, $items, $tableData = [], $selected = [], $categories = [], $selectedCategories = [], $codes = [], $key, $multipleSelect = false;
    public ?array $invoiceData = [];
    protected function getForms(): array
    {
        return [
            'invoiceForm',
            'invoiceForm2',
        ];
    }
    public function invoiceForm(Form $form): Form
    {
        return $form
            ->schema([
                Select::make("type")
                    ->options(
                        [
                            "sale" => trans("POS/lang.sale_invoice.singular_label"),
                            "return" => trans("POS/lang.sale_return.singular_label"),
                            "installment" => trans("POS/lang.installment.singular_label"),
                        ]
                    )
                    ->native(false)
                    ->required()
                    ->default('sale'),
                TextInput::make('invoice_number')
                    ->label(trans("lang.invoice_number"))
                    ->readOnly()
                    ->default(SaleInvoice::InvoiceNumber()),
                DateTimePicker::make('date')
                    ->default(now())
                    ->required()
                    ->label(trans("lang.date")),
                Select::make('branch_id')
                    ->label(trans("Logistic/lang.branch.singular_label"))
                    ->label(trans("Logistic/lang.branch.singular_label"))
                    ->relationship("branch", "name")
                    ->preload()
                    ->required()
                    ->searchable(),
                Select::make('contact_id')
                    ->label(trans("CRM/lang.vendor.singular_label"))
                    ->relationship('contact', 'name_'.App::getLocale(),modifyQueryUsing: function ($query){
                        return $query->where('status',1);
                    })                    ->preload()
                    ->searchable()
                    ->required(),
                TextInput::make("paid_amount")
                    ->label(trans("lang.paid_amount"))
                    ->numeric(),
                TextInput::make("months")
                    ->label(trans("lang.months"))
                    ->default(0)
                    ->numeric(),
                Textarea::make('note')
                    ->label(trans("lang.note"))
                    ->columnSpan(2),

            ])
            ->model(SaleInvoice::class)
            ->statePath('invoiceData')
            ->columns(5);
    }
    public function invoiceForm2(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('currency_id')

                    ->label(trans("Settings/lang.currency.singular_label"))
                    ->default(Currency::where('base', true)->first()->id)

                    ->label(trans("settings/lang.currency.singular_label"))
                    ->default(1)

                    ->relationship("currency", "name")
                    ->preload()
                    ->live()
                    ->searchable()
                    ->required(),
                TextInput::make('balance')
                    ->label(trans("lang.balance"))
                    ->disabled()
                    ->default(0),
                TextInput::make('discount')
                    ->label(trans("lang.discount"))
                    ->required()
                    ->default(0),
                TextInput::make('total')
                    ->label(trans("lang.total"))
                    ->disabled()
                    ->default(0),
                TextInput::make('paid_amount')
                    ->label(trans("lang.paid_amount"))
                    ->required()
                    ->default(0),
            ])
            ->model(SaleInvoice::class)
            ->statePath('invoiceData')
            ->columns(5);
    }
    public function mount()
    {
        $this->currencies = Currency::all();
        $this->categories = Category::all();
        $this->items = Item::all();
        $this->invoiceForm->fill();
        $this->invoiceForm2->fill();
        $this->activeTab = session()->get('sale_selected_tab') ?? 'sale_tab_1';
        $var = session()->get($this->activeTab);
        if ($var != null && $this->activeTab != null) {
            $var = json_decode($var, true);
            $this->selected = $var['selected'];
            $this->key = $var['key'];
            $this->tableData = $var['tableData'];
            $this->multipleSelect = $var['multipleSelect'];
            $this->invoiceData = $var['invoiceData'];
        } else {
            $this->tableData = [];
            $this->selected = [];
            $this->key = null;
            $this->multipleSelect = false;
            $this->invoiceForm->fill();
            $this->invoiceForm2->fill();
        }
    }

    public function addToSelect($record)
    {
        if ($this->multipleSelect) {
            if (in_array($record['id'], $this->selected)) {
                $key = array_search($record['id'], $this->selected);
                unset($this->selected[$key]);
                $this->invoiceData['total'] = collect($this->tableData)
                    ->map(function ($record) {
                        return convertToCurrency(
                            $record['currency_id'],
                            $this->invoiceData['currency_id'],
                            $record['price']
                        );
                    })
                    ->sum();

                $this->refreshTable();
                return;
            }
            $this->selected[] = $record['id'];
        } else {
            $record['price'] = $record['max_price'];
            $record['currency_id'] = 1;
            $record['type'] = 'single';
            $record['quantity'] = 1;
            $record['gift'] = 0;
            $record['codes'] = [];
                        $record['brand'] = Item::find($record['id'])?->brand?->name;
            $this->tableData[] = $record;
        }

        $this->refreshTable();
    }
    public function removeFromTable($key)
    {
        // remove from table with the given key
        unset($this->tableData[$key]);
        $this->refreshTable();
    }

    public function updated()
    {
        $this->refreshTable();
    }

    public function addToTable()
    {
        $records = $this->items->whereIn('id', $this->selected)->map(function ($record) {
            return [
                'id' => $record->id,
                'name_'.\Illuminate\Support\Facades\App::getLocale() => $record->{'name_'.\Illuminate\Support\Facades\App::getLocale()},
                                'brand'=>$record->brand->name,
                'price' => $record->price,
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
        // $this->refreshTable();

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


    public function openCodeModal($key)
    {
        $this->codes = [];
        $this->codes = $this->tableData[$key]['codes'];
        $this->key = $key;
        $this->dispatch('open-modal', id: "code-modal");
    }

    public function addToCode()
    {
        if (count($this->codes) > 0) {
            if (isset($this->codes['gift'])) {
                $this->codes['gift'] = 1;
            } else {
                $this->codes['gift'] = 0;
            }
            $this->tableData[$this->key]['codes'][] = $this->codes;
            $this->codes = [];
        }

        $this->refreshTable();
    }


    private function refreshTable()
    {
        $this->invoiceData['total'] = collect($this->tableData)
            ->map(function ($record) {
                return convertToCurrency(
                    $record['currency_id'],
                    $this->invoiceData['currency_id'],
                    $record['price']
                        *  collect($record['codes'])->where("gift", "no")->count()
                );
            })
            ->sum();

        $this->invoiceData['total'] = number_format(
            $this->invoiceData['total'],
            getCurrencyDecimal($this->invoiceData['currency_id'])
        );
    }


    public function submit()
    {

        DB::beginTransaction();
        try {
            unset($this->invoiceData['total']);
            $this->invoiceForm->getState();
            $this->invoiceForm2->getState();
            $invoice = SaleInvoice::create($this->invoiceData);
            collect($this->tableData)->each(function ($record) use ($invoice) {
                $detail = $invoice->details()->create(
                    [
                        'item_id' => $record['id'],
                        'quantity' => $record['quantity'],
                        'gift' => $record['gift'],
                        'price' => $record['price'],
                        'currency_id' => $record['currency_id'],
                    ]
                );
                $detail->codes()->delete();
                collect($record['codes'])->each(function ($code) use ($detail, $record) {
                    $code['item_id'] = $record['id'];
                    $detail->codes()->create($code);
                });
            });
            Notification::make()
                ->success()
                ->title(trans("filament-actions::edit.single.notifications.saved.title"))
                ->send();

            // reset arrays
            $this->selected = [];
            $this->tableData = [];
            $this->invoiceForm->fill();
            DB::commit();
            $this->resetSession();
        } catch (Exception $e) {
            Notification::make()
                ->danger()
                ->title($e->getMessage())
                ->send();
            DB::rollBack();
            return;
        }
    }

    public function removeCode($key)
    {
        unset($this->tableData[$this->key]['codes'][$key]);
        $this->refreshTable();
    }
    public function toggleGift($key)
    {
        $this->tableData[$this->key]['codes'][$key]['gift'] = $this->tableData[$this->key]['codes'][$key]['gift'] == 1 ? 0 : 1;
        $this->refreshTable();
    }
    public function setTab($tab)
    {
        $tab = "sale_tab_" . $tab;
        $var = session()->get($tab);

        if ($var != null) {
            $var = json_decode($var, true);
            $this->selected = $var['selected'];
            $this->key = $var['key'];
            $this->tableData = $var['tableData'];
            $this->multipleSelect = $var['multipleSelect'];
            $this->invoiceData = $var['invoiceData'];
        } else {
            $this->tableData = [];
            $this->selected = [];
            $this->key = null;
            $this->multipleSelect = false;
            $this->invoiceForm->fill();
            $this->invoiceForm2->fill();
        }
        $this->activeTab = $tab;
    }

    // function to reset all session
    public function resetSession()
    {
        $this->tableData = [];
        $this->selected = [];
        $this->key = null;
        $this->multipleSelect = false;
        $this->invoiceForm->fill(['invoice_number' => SaleInvoice::InvoiceNumber(), 'date' => now(), 'type' => 'sale', 'currency_id' => 1]);
        $this->invoiceForm2->fill();
        $variables = [
            'tableData' => $this->tableData,
            'selected' => $this->selected,
            'key' => $this->key,
            'multipleSelect' => $this->multipleSelect,
            'invoiceData' => $this->invoiceData
        ];
        session()->put($this->activeTab, json_encode($variables));
    }

    public function render(): View
    {

        $variables = [
            'tableData' => $this->tableData,
            'selected' => $this->selected,
            'key' => $this->key,
            'multipleSelect' => $this->multipleSelect,
            'invoiceData' => $this->invoiceData
        ];
        session()->put($this->activeTab, json_encode($variables));
        session()->put('sale_selected_tab', $this->activeTab);
        return parent::render();
    }

    protected static string $view = 'filament.pages.p-o-s.sale-page';
}
