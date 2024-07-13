<?php

namespace App\Livewire\Reports;

use App\Filament\Pages\Reports\Logistic\Branch;
use App\Filament\Pages\Reports\Logistic\ItemTransactions;
use App\Filament\Pages\Reports\Logistic\WareHouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class Logistic extends Component implements HasForms
{
    use InteractsWithForms;


    public function mount()
    {
        $this->logisticBranches->fill();
        $this->logisticWarehouse->fill();
        $this->logisticItemTransactions->fill();
    }

    public $logisticBranch,$logisticWarehouseData;
    protected function getForms(): array
    {
        return [
            'logisticBranches',
            'logisticWarehouse',
            'logisticItemTransactions'
        ];
    }

//    Logistics
//     Branches
    public function logisticBranches(Form $form):Form{
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
    public function searchLogisticBranch()
    {
        $data =  $this->logisticBranches->getState();
        $attr = json_encode($data['attr']??[]);
        $branches = json_encode($data['branches']??[]);
        return $this->redirect(Branch::getUrl(['attr' => $attr,'branches'=>$branches]));
    }

//    Warehouses
    public function logisticWarehouse(Form $form):Form{
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
    public function searchLogisticWarehouse()
    {
        $data =  $this->logisticWarehouse->getState();
        $attr = json_encode($data['attr']??[]);
        $warehouses = json_encode($data['warehouse']??[]);

        return $this->redirect(WareHouse::getUrl(['attr' => $attr,'warehouses'=>$warehouses]));
    }

    public $logisticItemTransaction = [];
    //    Transactions
    public function logisticItemTransactions(Form $form):Form{
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
    public function searchLogisticItemTransactions()
    {
        $data =  $this->logisticItemTransactions->getState();
        $warehouses = json_encode($data['warehouse']??[]);
        $branches = json_encode($data['branches']??[]);
        $from = $data['from']?? 'all';
        $to = $data['to']?? 'all';
        return $this->redirect(ItemTransactions::getUrl(['warehouses'=>$warehouses,'branches'=>$branches,'from'=>$from,'to'=>$to]));
    }
    public function render()
    {
        return view('livewire.reports.logistic');
    }
}
