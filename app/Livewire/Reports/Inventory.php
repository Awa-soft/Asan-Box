<?php

namespace App\Livewire\Reports;

use App\Filament\Pages\Reports\POS\ItemRepairs;
use App\Models\Inventory\Item;
use App\Models\Inventory\ItemLoss;
use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class Inventory extends Component  implements HasForms
{
    use InteractsWithForms;
    public $itemLoss = [],$items= [],$brands=[],$categories=[],$units=[];
    public $formNames = [
        'itemLoss',
        'items',
        'brands',
        'categories',
        'units'
    ];
    protected function getForms(): array
    {
        return [
            'itemLossForm',
            'itemsForm',
            'brandsForm',
            'categoriesForm',
            'unitsForm',
        ];
    }

    public function itemLossForm(Form $form): Form
    {
        return $form
            ->model(ItemLoss::class)
            ->columns(2)
            ->schema([
            Fieldset::make('dates')
                ->label(trans('lang.date'))
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                ])->columns(2)->columnSpanFull(),
            Select::make('branch_id')
                ->hidden(userHasBranch())
                ->multiple()
                ->live()
                ->label(trans('lang.branches'))
                ->options(Branch::all()->pluck('name','id'))
                ->searchable()
                ->preload(),
            Select::make('warehouse_id')
                ->hidden(userHasWarehouse())
                ->multiple()
                ->label(trans('lang.warehouses'))
                ->live()
                ->options(userHasBranch()? Warehouse::whereHas('branches',function ($query){
                    return $query->where('branch_id',getBranchId());
                })->get()->pluck('name','id') : Warehouse::all()->pluck('name','id'))
                ->searchable()
                ->preload(),
              Select::make('item_id')
                    ->relationship('item','name_'.App::getLocale())
                    ->multiple()
                    ->searchable()
                  ->columnSpanFull()
                    ->preload(),
        ])->statePath('itemLoss');
    }
    public function itemLossSearch(){
        $this->itemLossForm->getState();
        $data = $this->itemLoss;
        $from = $data['from']?? 'all';
        $to = $data['to']?? 'all';
        $branch = json_encode($data['branch_id']??[]);
        $warehouse = json_encode($data['warehouse_id']??[]);
        $item = json_encode($data['item_id']??[]);
        return $this->redirect(ItemRepairs::getUrl(['branch'=>$branch,'warehouse'=>$warehouse,'item'=>$item,'from'=>$from,'to'=>$to,'type'=>$data['type']??'all']));
    }
    public function itemsForm(Form $form): Form{
        return $form
            ->model(Item::class)
            ->columns(2)
            ->schema([
                Fieldset::make('expireDate')
                    ->label(trans('lang.expire_date'))
            ->schema([
                DatePicker::make('from')
                    ->label(trans('lang.from')),
                DatePicker::make('to')
                    ->label(trans('lang.to')),
            ])->columns(2)->columnSpanFull(),
                Select::make('category_id')
                    ->label(trans("lang.category"))
                    ->relationship('category', 'name')
                    ->preload()
                    ->multiple()
                    ->searchable(),
                Select::make('unit_id')
                    ->label(trans("lang.unit"))
                    ->relationship('unit', 'name')
                    ->preload()
                    ->multiple()
                    ->searchable(),
                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->label(trans("lang.brand"))
                    ->preload()
                    ->multiple()
                    ->columnSpanFull()
                    ->searchable(),
        ])->statePath('items');
    }
    public function itemsSearch(){
        $this->itemsForm->getState();
        $data = $this->items;
    }
    public function brandsForm(Form $form): Form{
        return $form->schema([
            Select::make('branch_id')
                ->hidden(userHasBranch())
                ->multiple()
                ->live()
                ->label(trans('lang.branches'))
                ->options(Branch::all()->pluck('name','id'))
                ->searchable()
                ->preload(),
            Select::make('warehouse_id')
                ->hidden(userHasWarehouse())
                ->multiple()
                ->label(trans('lang.warehouses'))
                ->live()
                ->options(userHasBranch()? Warehouse::whereHas('branches',function ($query){
                    return $query->where('branch_id',getBranchId());
                })->get()->pluck('name','id') : Warehouse::all()->pluck('name','id'))
                ->searchable()
                ->preload(),
            Select::make('status')
                    ->label(trans('lang.status'))
                ->native(0)
                    ->options([
                        'yes'=>trans('lang.yes'),
                        'no'=>trans('lang.no'),
                    ])->columnSpanFull()
        ])->statePath('brands');
    }
    public function brandsSearch(){
        $this->brandsForm->getState();
        $data = $this->brands;
    }
    public function categoriesForm(Form $form): Form{
        return $form->schema([
            Select::make('branch_id')
                ->hidden(userHasBranch())
                ->multiple()
                ->live()
                ->label(trans('lang.branches'))
                ->options(Branch::all()->pluck('name','id'))
                ->searchable()
                ->preload(),
            Select::make('warehouse_id')
                ->hidden(userHasWarehouse())
                ->multiple()
                ->label(trans('lang.warehouses'))
                ->live()
                ->options(userHasBranch()? Warehouse::whereHas('branches',function ($query){
                    return $query->where('branch_id',getBranchId());
                })->get()->pluck('name','id') : Warehouse::all()->pluck('name','id'))
                ->searchable()
                ->preload(),
            Select::make('status')
                ->label(trans('lang.status'))
                ->native(0)
                ->options([
                    'yes'=>trans('lang.yes'),
                    'no'=>trans('lang.no'),
                ])->columnSpanFull()
        ])->statePath('categories');
    }
    public function categoriesSearch(){
        $this->categoriesForm->getState();
        $data = $this->categories;
    }
    public function unitsForm(Form $form): Form{
        return $form->schema([
            Select::make('branch_id')
                ->hidden(userHasBranch())
                ->multiple()
                ->live()
                ->label(trans('lang.branches'))
                ->options(Branch::all()->pluck('name','id'))
                ->searchable()
                ->preload(),
            Select::make('warehouse_id')
                ->hidden(userHasWarehouse())
                ->multiple()
                ->label(trans('lang.warehouses'))
                ->live()
                ->options(userHasBranch()? Warehouse::whereHas('branches',function ($query){
                    return $query->where('branch_id',getBranchId());
                })->get()->pluck('name','id') : Warehouse::all()->pluck('name','id'))
                ->searchable()
                ->preload(),
            Select::make('status')
                ->label(trans('lang.status'))
                ->native(0)
                ->options([
                    'yes'=>trans('lang.yes'),
                    'no'=>trans('lang.no'),
                ])->columnSpanFull()
        ])->statePath('units');
    }
    public function unitsSearch(){
        $this->unitsForm->getState();
        $data = $this->units;
    }


    public function mount()
    {
        $this->itemLossForm->fill();
        $this->itemsForm->fill();
        $this->brandsForm->fill();
        $this->categoriesForm->fill();
        $this->unitsForm->fill();
    }
    public function render()
    {
        return view('livewire.reports.inventory');
    }
}
