<?php

namespace App\Filament\Pages\Logistic;

use App\Models\Inventory\Category;
use App\Models\Inventory\Item;
use App\Models\Logistic\Branch;
use App\Models\Logistic\ItemTransactionInvoice;
use App\Models\Logistic\Warehouse;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Exception;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ItemTransaction extends Page implements HasForms
{
    use HasPageShield, InteractsWithForms;
    protected static ?string $navigationIcon = 'iconpark-buy';
    public static function getNavigationLabel(): string
    {
        return trans('Logistic/lang.item_transaction.plural_label');
    }
    public function getTitle(): string|Htmlable
    {
        return trans('Logistic/lang.item_transaction.plural_label');
    }

    public  function getHeading(): string
    {
        return "";
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('Logistic/lang.group_label');
    }

    public $currencies, $tableData = [], $selected = [], $categories = [], $selectedCategories = [], $codes = [], $key, $multipleSelect = false;
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
                MorphToSelect::make('fromable')
                    ->label(trans("lang.from"))
                    ->native(0)
                    ->types([
                        MorphToSelect\Type::make(Branch::class)
                            ->titleAttribute('name')
                            ->label(trans('Logistic/lang.branch.singular_label')),
                        MorphToSelect\Type::make(Warehouse::class)
                            ->titleAttribute('name')
                            ->label(trans('Logistic/lang.warehouse.singular_label')),
                    ])
                    ->visible(fn()=>auth()->user()->hasRole('super_admin'))
                    ->searchable()
                    ->live()
                    ->columns(2)
                    ->preload(),
                MorphToSelect::make('toable')
                    ->label(trans("lang.to"))
                    ->native(0)
                    ->types([
                        MorphToSelect\Type::make(Branch::class)
                            ->titleAttribute('name')
                            ->label(trans('Logistic/lang.branch.singular_label')),
                        MorphToSelect\Type::make(Warehouse::class)
                            ->titleAttribute('name')
                            ->label(trans('Logistic/lang.warehouse.singular_label')),
                    ])
                    ->columns(2)
                    ->visible(fn()=>auth()->user()->hasRole('super_admin'))
                    ->searchable()
                    ->live()
                    ->preload()
            ])
            ->model(ItemTransactionInvoice::class)
            ->statePath('invoiceData')
            ->columns(2);
    }
    public function mount()
    {
        $this->categories = Category::all();
        $this->invoiceForm->fill();

    }

    public function addToSelect($record)
    {
        if($this->multipleSelect){
            if (in_array($record['id'], $this->selected)) {
                $key = array_search($record['id'], $this->selected);
                unset($this->selected[$key]);
                $this->refreshTable();
                return;
            }
            $this->selected[] = $record['id'];
        }
        else{
            $record['type'] = 'single';
            $record['quantity'] = 1;
            $record['codes'] =[];
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

    public function updated(){
        $this->refreshTable();
    }

    public function addToTable()
    {
        $records = Item::all()->whereIn('id', $this->selected)->map(function ($record) {
            return [
                'id' => $record->id,
                'name' => $record->{'name_'.\Illuminate\Support\Facades\App::getLocale()},
                'quantity' => 1,
                "image" => $record->image,
                "codes" => []

            ];
        })->toArray();
        $this->tableData = array_merge($this->tableData, $records);
        $this->selected = [];
        // $this->refreshTable();

    }

    public function selectAll()
    {
        $this->selected = Item::all()->pluck('id')->toArray();
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

        if (count($this->codes) > 0) {
            if(Item::hasCode($this->tableData[$this->key]['id'],$this->codes,['fromable'=>$this->invoiceData['fromable_type'],'fromable_id'=>$this->invoiceData['fromable_id']])){
                $this->tableData[$this->key]['codes'][] = $this->codes;
                $this->codes = [];
            }
        }
        $this->refreshTable();
    }


    private function refreshTable(){

    }


    public function submit(){

        DB::beginTransaction();
        try {
            unset($this->invoiceData['total']);
            $invoice = ItemTransactionInvoice::create($this->invoiceData);
            collect($this->tableData)->each(function ($record) use ($invoice) {
                $detail = $invoice->details()->create(
                    [
                        'item_id' => $record['id'],
                    ]
                );
                $detail->codes()->delete();
                collect($record['codes'])->each(function ($code) use ( $detail, $record) {
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
        }
        catch(Exception $e){
            Notification::make()
                ->danger()
                ->title($e->getMessage())
                ->send();
            DB::rollBack();
            return;
        }
    }

    public $name = [];
    use WithPagination;
    public function updatedName(){
        $this->resetPage();
    }
    public function render(): View
    {
        $items = Item::when($this->name != null,function ($query){
            return $query->where('name_'.App::getLocale(), 'like', '%'.$this->name.'%');
        })->orderBy('id','desc')
            ->paginate(20);
        return view($this->getView(), compact('items'))
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ]);
    }

    public function removeCode($key){
        unset($this->tableData[$this->key]['codes'][$key]);
        $this->refreshTable();
    }

    protected static string $view = 'filament.pages.inventory.item-transaction';
}
