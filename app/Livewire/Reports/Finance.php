<?php

namespace App\Livewire\Reports;

use App\Filament\Resources\CRM\BothResource;
use App\Filament\Resources\CRM\BourseResource;
use App\Filament\Resources\CRM\CustomerResource;
use App\Filament\Resources\CRM\PartnerAccountResource;
use App\Filament\Resources\CRM\PartnershipResource;
use App\Filament\Resources\CRM\VendorResource;
use App\Filament\Resources\Finance\BoursePaymentResource;
use App\Filament\Resources\Finance\ExpenseResource;
use App\Filament\Resources\Finance\ExpenseTypeResource;
use App\Filament\Resources\Finance\PaymentResource;
use App\Models\CRM\Bourse;
use App\Models\Finance\BoursePayment;
use App\Models\Finance\Expense;
use App\Models\Finance\Payment;
use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Mpdf\Tag\Select;

class Finance extends Component   implements HasForms
{
    use InteractsWithForms;
    public $localizationFolder = 'Finance';

    public $formNames = [
        'boursePayment'=>BoursePaymentResource::class,
        'expense'=>ExpenseResource::class,
        'payment'=>PaymentResource::class
    ];

    public function mount()
    {
        $data = ['debt'=>'all','maximumDebt'=>'all'];
        if(userHasBranch()){
            $data['branch_id'] = [
                getBranchId()
            ];
        }
        if(userHasWarehouse()){
            $data['warehouse_id'] = [
                getWarehouseId()
            ];
        }
        foreach($this->formNames as $key => $form){
            $this->{$key.'Form'}->fill($data);
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

    public $boursePaymentData;
    public function boursePaymentForm(Form $form): Form
    {
        return $form
            ->model(BoursePayment::class)
            ->schema([
                DatePicker::make('from')
                    ->label(trans('lang.from')),
                DatePicker::make('to')
                    ->label(trans('lang.to')),
                \Filament\Forms\Components\Select::make('branch_id')
                    ->hidden(userHasBranch())
                    ->multiple()
                    ->live()
                    ->label(trans('lang.branches'))
                    ->options(Branch::all()->pluck('name','id'))
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('bourse_id')
                    ->relationship('bourse', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('type')
                    ->options(
                        BoursePayment::getTypes()
                    )
                    ->native(0),
        ])->statePath('boursePaymentData')->columns(2);
    }
    public function boursePaymentSearch()
    {
        $this->boursePaymentForm->getState();
        $data = $this->boursePaymentData;
        $from = $data['from']?? 'all';
        $to = $data['to']?? 'all';
        $branch = json_encode($data['branch_id']??[]);
        $bourse = json_encode($data['bourse_id']??[]);
        $currency = json_encode($data['currency_id']??[]);
        $type = $data['type']?? 'all';
        $dt = ['from'=>$from, 'to'=>$to,'bourse'=>$bourse, 'branch'=>$branch, 'currency'=>$currency, 'type'=>$type];
        return $this->redirect(\App\Filament\Pages\Reports\Finance\BoursePayment::getUrl($dt));

    }

//    expenses
    public $expenseData;
    public function expenseForm(Form $form): Form
    {
        return $form
            ->model(Expense::class)
            ->schema([
                DatePicker::make('from')
                    ->label(trans('lang.from')),
                DatePicker::make('to')
                    ->label(trans('lang.to')),
                \Filament\Forms\Components\Select::make('expense_type_id')
                 ->relationship('expenseType', 'type')
                    ->label(trans('lang.expense_type'))
                ->searchable()
                ->preload()
                ->multiple(),
                \Filament\Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('branch_id')
                    ->hidden(userHasBranch())
                    ->multiple()
                    ->live()
                    ->label(trans('lang.branches'))
                    ->options(Branch::all()->pluck('name','id'))
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('warehouse_id')
                    ->hidden(userHasWarehouse())
                    ->multiple()
                    ->label(trans('lang.warehouses'))
                    ->live()
                    ->options(userHasBranch()? Warehouse::whereHas('branches',function ($query){
                        return $query->where('branch_id',getBranchId());
                    })->get()->pluck('name','id') : Warehouse::all()->pluck('name','id'))
                    ->searchable()
                    ->preload(),
        ])->statePath('expenseData')->columns(2);
    }
    public function expenseSearch(){
        $this->expenseForm->getState();
        $data = $this->expenseData;
        $from = $data['from']?? 'all';
        $to = $data['to']?? 'all';
        $expenseType = json_encode($data['expense_type_id']??[]);
        $currency = json_encode($data['currency_id']??[]);
        $branch = json_encode($data['branch_id']??[]);
        $warehouse = json_encode($data['warehouse_id']??[]);
        $dt = ['from'=>$from, 'to'=>$to, 'expenseType'=>$expenseType, 'currency'=>$currency, 'branch'=>$branch, 'warehouse'=>$warehouse];
        return $this->redirect(\App\Filament\Pages\Reports\Finance\Expense::getUrl($dt));

    }
//    payment
    public $paymentData;
    public function paymentForm(Form $form): Form
    {
        return $form
            ->model(Payment::class)
            ->schema([
                DatePicker::make('from')
                    ->label(trans('lang.from')),
                DatePicker::make('to')
                    ->label(trans('lang.to')),
                \Filament\Forms\Components\Select::make('branch_id')
                    ->hidden(userHasBranch())
                    ->multiple()
                    ->live()
                    ->label(trans('lang.branches'))
                    ->options(Branch::all()->pluck('name','id'))
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'name_'.App::getLocale(),modifyQueryUsing: function ($query){
                        return $query->where('status',1);
                    })
                    ->multiple()
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('type')
                    ->options(
                        BoursePayment::getTypes()
                    )
                    ->native(0),
        ])->columns(2)->statePath('paymentData');
    }
    public function paymentSearch(){
        $this->paymentForm->getState();
        $data = $this->paymentData;
        $from = $data['from']?? 'all';
        $to = $data['to']?? 'all';
        $type = $data['type']?? 'all';
        $branch = json_encode($data['branch_id']??[]);
        $contact = json_encode($data['contact_id']??[]);
        $currency = json_encode($data['currency_id']??[]);
        $dt = ['from'=>$from, 'to'=>$to, 'type'=>$type, 'branch'=>$branch, 'contact'=>$contact, 'currency'=>$currency];
        return $this->redirect(\App\Filament\Pages\Reports\Finance\Payment::getUrl($dt));

    }

    public function render()
    {
        return view('livewire.reports.reports-content');
    }
}
