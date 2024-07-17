<?php

namespace App\Livewire\Reports;

use App\Filament\Pages\Logistic\ItemTransaction;
use App\Filament\Pages\Reports\Logistic\Branch;
use App\Filament\Pages\Reports\Logistic\ItemTransactions;
use App\Filament\Pages\Reports\Logistic\WareHouse;
use App\Filament\Resources\Logistic\BranchResource;
use App\Filament\Resources\Logistic\WarehouseResource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class Logistic extends Component implements HasForms
{
    use InteractsWithForms;
    public $logisticBranch,$logisticWarehouseData,$logisticItemTransaction;

    public $localizationFolder = 'Logistic';
    public $formNames = [
        'logisticBranches' => BranchResource::class,
        'logisticWarehouse' => WarehouseResource::class,
        'logisticItemTransactions' =>ItemTransaction::class,
    ];
    public function mount()
    {
        foreach($this->formNames as $key => $form){
            $this->{$key.'Form'}->fill();
        }

    }

    protected function getForms(): array
    {
        $forms = [];
        foreach($this->formNames as $key => $form){
            $forms[] = $key.'Form';
        }
        return $forms;
    }

//    Logistics
//     Branches
    public function logisticBranchesForm(Form $form):Form{
        return $form->schema([
            Select::make('branches')
                ->multiple()
                ->label(trans('lang.branches'))
                ->options(\App\Models\Logistic\Branch::all()->pluck('name','id')),
            Select::make('attr')
                ->label(trans('lang.attributes'))
                ->required()
                ->native(0)
                ->multiple()
                ->options([
                    'details'=>trans('lang.details'),
                    'warehouses'=>trans('lang.warehouses'),
                    'items'=>trans('Inventory/lang.item.plural_label'),
                ])
                ->live()
        ])->statePath('logisticBranch');
    }
    public function logisticBranchesSearch()
    {
        $data =  $this->logisticBranchesForm->getState();
        $attr = json_encode($data['attr']??[]);
        $branches = json_encode($data['branches']??[]);
        return $this->redirect(Branch::getUrl(['attr' => $attr,'branches'=>$branches]));
    }

//    Warehouses
    public function logisticWarehouseForm(Form $form):Form{
        return $form->schema([
            Select::make('warehouse')
                ->multiple()
                ->label(trans('lang.warehouses'))
                ->options(\App\Models\Logistic\Warehouse::all()->pluck('name','id')),
            Select::make('attr')
                ->label(trans('lang.attributes'))
                ->required()
                ->native(0)
                ->multiple()
                ->options([
                    'details'=>trans('lang.details'),
                    'items'=>trans('Inventory/lang.item.plural_label'),
                ])
                ->live()
        ])->statePath('logisticWarehouseData');
    }
    public function logisticWarehouseSearch()
    {
        $data =  $this->logisticWarehouseForm->getState();
        $attr = json_encode($data['attr']??[]);
        $warehouses = json_encode($data['warehouse']??[]);

        return $this->redirect(WareHouse::getUrl(['attr' => $attr,'warehouses'=>$warehouses]));
    }

    //    Transactions
    public function logisticItemTransactionsForm(Form $form):Form{
        return $form->schema([
            DatePicker::make('from')
                ->label(trans('lang.from')),
            DatePicker::make('to')
                ->label(trans('lang.to')),
            Select::make('warehouse')
                ->multiple()
                ->label(trans('lang.warehouses'))
                ->options(\App\Models\Logistic\Warehouse::all()->pluck('name','id')),
            Select::make('branches')
                ->multiple()
                ->label(trans('lang.branches'))
                ->options(\App\Models\Logistic\Branch::all()->pluck('name','id')),
        ])->statePath('logisticItemTransaction')->columns(2);
    }
    public function logisticItemTransactionsSearch()
    {
        $data =  $this->logisticItemTransactionsForm->getState();
        $warehouses = json_encode($data['warehouse']??[]);
        $branches = json_encode($data['branches']??[]);
        $from = $data['from']?? 'all';
        $to = $data['to']?? 'all';
        return $this->redirect(ItemTransactions::getUrl(['warehouses'=>$warehouses,'branches'=>$branches,'from'=>$from,'to'=>$to]));
    }
    public function render()
    {
        return view('livewire.reports.reports-content');
    }
}
