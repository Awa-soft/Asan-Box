<?php

namespace App\Livewire\Reports;

use App\Filament\Resources\CRM\BothResource;
use App\Filament\Resources\CRM\BourseResource;
use App\Filament\Resources\CRM\CustomerResource;
use App\Filament\Resources\CRM\PartnerAccountResource;
use App\Filament\Resources\CRM\PartnerResource;
use App\Filament\Resources\CRM\PartnershipResource;
use App\Filament\Resources\CRM\VendorResource;
use App\Models\CRM\PartnerAccount;
use App\Models\CRM\Partnership;
use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
use App\Traits\Core\ReportsTrait;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class CRM extends Component  implements HasForms
{
    use InteractsWithForms;
    public $localizationFolder = 'CRM';
    public $customersData = [],$vendorsData=[],$bothData=[],$boursesData = [],$partnersData=[],$partnershipData=[],$partnerAccountData=[];
    public $formNames = [
        'customers'=>CustomerResource::class,
        'vendors'=>VendorResource::class,
        'both'=>BothResource::class,
        'bourses'=>BourseResource::class,
        'partnership'=>PartnershipResource::class,
        'partnerAccount'=>PartnerAccountResource::class,
        'partners'=>PartnerResource::class,

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
    public function sameFields():array
    {
        return [
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
            Select::make('debt')
                ->label(trans('lang.balance'))
                ->native(0)
                ->required()
                ->options([
                    'all'=>trans('lang.all'),
                    'only_debt'=>trans('lang.only_debt'),
                    'without_debt'=>trans('lang.without_debt'),
                ]),
            Select::make('maximumDebt')
                ->label(trans('lang.max_debt'))
                ->native(0)
                ->required()
                ->options([
                    'all'=>trans('lang.all'),
                    'reached'=>trans('lang.reached_maximum_debt'),
                    'not_reached'=>trans('lang.not_reached_maximum_debt'),
                ]),
            Select::make('status')
                ->label(trans('lang.status'))
                ->native(0)
                ->columnSpanFull()
                ->options([
                    'yes'=>trans('lang.yes'),
                    'no'=>trans('lang.no'),
                ]),

        ];
    }
//    customers
    public function customersSearch()
    {
        $this->customersForm->getState();
        $data = $this->customersData;
        $branch = json_encode($data['branch_id']??[]);
        $warehouse = json_encode($data['warehouse_id']??[]);
        $debt = $data['debt']?? 'all';
        $status = $data['status']?? 'all';
        $maximumDebt = $data['maximumDebt']?? 'all';
        return $this->redirect(\App\Filament\Pages\Reports\CRM\Customer::getUrl(['maximumDebt'=>$maximumDebt,'branch'=>$branch,'warehouse'=>$warehouse,'debt'=>$debt,'status'=>$status,'type'=>'customer']));
    }
    public function customersForm(Form $form): Form
    {
        return $form->schema($this->sameFields())->columns(2)
            ->statePath('customersData');
    }
//    vendors
    public function vendorsSearch()
    {
        $this->vendorsForm->getState();
        $data = $this->vendorsData;
        $branch = json_encode($data['branch_id']??[]);
        $warehouse = json_encode($data['warehouse_id']??[]);
        $debt = $data['debt']?? 'all';
        $status = $data['status']?? 'all';
        $maximumDebt = $data['maximumDebt']?? 'all';
        return $this->redirect(\App\Filament\Pages\Reports\CRM\Customer::getUrl(['maximumDebt'=>$maximumDebt,'branch'=>$branch,'warehouse'=>$warehouse,'debt'=>$debt,'status'=>$status,'type'=>'vendor']));
    }
    public function vendorsForm(Form $form): Form{
        return $form->schema($this->sameFields())->columns(2)->statePath('vendorsData');
    }
    // both
    public function bothSearch(){
        $this->bothForm->getState();
        $data = $this->bothData;
        $branch = json_encode($data['branch_id']??[]);
        $warehouse = json_encode($data['warehouse_id']??[]);
        $debt = $data['debt']?? 'all';
        $status = $data['status']?? 'all';
        $maximumDebt = $data['maximumDebt']?? 'all';
        return $this->redirect(\App\Filament\Pages\Reports\CRM\Customer::getUrl(['maximumDebt'=>$maximumDebt,'branch'=>$branch,'warehouse'=>$warehouse,'debt'=>$debt,'status'=>$status,'type'=>'both']));
    }
    public function bothForm(Form $form): Form{
        return $form->schema($this->sameFields())->columns(2)->statePath('bothData');
    }
//    bourses
    public function boursesSearch(){
        $this->boursesForm->getState();
        $data = $this->boursesData;
        $branch = json_encode($data['branch_id']??[]);
        $warehouse = json_encode($data['warehouse_id']??[]);
        return $this->redirect(\App\Filament\Pages\Reports\CRM\Bourse::getUrl(['branch'=>$branch,'warehouse'=>$warehouse]));
    }
    public function boursesForm(Form $form): Form{
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
        ])->columns(1)->statePath('boursesData');
    }

//    partners
    public function partnersSearch(){
        $this->partnersForm->getState();
        $data = $this->partnersData;
    }
    public function partnersForm(Form $form): Form{
        return $form->schema([
            Select::make('branch_id')
                ->hidden(userHasBranch())
                ->multiple()
                ->live()
                ->label(trans('lang.branches'))
                ->options(Branch::all()->pluck('name','id'))
                ->searchable()
                ->preload(),

        ])->statePath('partnersData');
    }
    // partnership
    public function partnershipSearch(){
        $this->partnershipForm->getState();
        $data = $this->partnershipData;
    }
    public function partnershipForm(Form $form): Form{
        return $form->schema([
            DatePicker::make('from')
                ->label(trans('lang.start_date')),
            DatePicker::make('to')
                ->label(trans('lang.end_date')),
            Select::make('branch_id')
                ->hidden(userHasBranch())
                ->multiple()
                ->live()
                ->columnSpanFull()
                ->label(trans('lang.branches'))
                ->options(Branch::all()->pluck('name','id'))
                ->searchable()
                ->preload(),
        ])->columns(2)->statePath('partnershipData');
    }
    // partnerAccount
    public function partnerAccountSearch(){
        $this->partnerAccountForm->getState();
        $data = $this->partnerAccountData;
    }
    public function partnerAccountForm(Form $form): Form{
        return $form
            ->model(PartnerAccount::class)
            ->schema([
                Select::make('partnership_id')
                    ->relationship('partnership', 'id')
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        $data = $record->start_date;
                        if($record->end_date != null){
                            $data = $record->start_date.' - '.$record->end_date;
                        }
                        return $data;
                    })
                    ->searchable()
                    ->preload()
                    ->label(trans('CRM/lang.partnership.singular_label'))
                    ->live()
                    ->multiple(),
                Select::make('partner_id')
                    ->relationship('partner', 'name')
                    ->label(trans('CRM/lang.partner.singular_label'))
                    ->searchable()
                    ->searchable()
                    ->preload()
                    ->preload()
                    ->multiple(),
        ])->statePath('partnerAccountData');
    }

    public function render()
    {
        return view('livewire.reports.reports-content');
    }
}
