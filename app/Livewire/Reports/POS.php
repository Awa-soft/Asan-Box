<?php

namespace App\Livewire\Reports;

use App\Filament\Pages\Logistic\ItemTransaction;
use App\Filament\Pages\POS\PurchasePage;
use App\Filament\Pages\POS\SalePage;
use App\Filament\Pages\Reports\HR\EmployeeSalary;
use App\Filament\Pages\Reports\POS\ItemRepairs;
use App\Filament\Pages\Reports\POS\Purchase;
use App\Filament\Pages\Reports\POS\PurchaseCodes;
use App\Filament\Pages\Reports\POS\PurchaseExpenses;
use App\Filament\Pages\Reports\POS\PurchaseItems;
use App\Filament\Pages\Reports\POS\Sale;
use App\Filament\Pages\Reports\POS\SaleCodes;
use App\Filament\Pages\Reports\POS\SaleItems;
use App\Filament\Resources\Logistic\BranchResource;
use App\Filament\Resources\Logistic\WarehouseResource;
use App\Filament\Resources\POS\ItemRepairResource;
use App\Filament\Resources\POS\PurchaseExpenseResource;
use App\Filament\Resources\POS\PurchaseInvoiceResource;
use App\Filament\Resources\POS\SaleInvoiceResource;
use App\Models\Inventory\Item;
use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Livewire\Component;

class POS extends Component  implements HasForms
{
    use InteractsWithForms;
    public $purchase=[],$sale  =[],$purchaseItems = [],$purchaseCodes=[],$purchaseExpenses;
    public $purchaseReturn=[],$purchaseReturnItems = [],$purchaseReturnCodes=[],$purchaseReturnExpenses;
    public$saleItems = [],$saleCodes=[];
    public $saleReturn  =[],$saleReturnItems = [],$saleReturnCodes=[];
    public $saleInstallment  =[],$saleInstallmentItems = [],$saleInstallmentCodes=[];
    public $itemRepairs = [];
    public $localizationFolder = 'POS';
    public $formNames = [
        'purchase'=>PurchasePage::class,
        'purchaseItems'=>PurchaseInvoiceResource::class,
        'purchaseCodes'=>PurchaseInvoiceResource::class,
        'purchaseExpenses'=>PurchaseExpenseResource::class,
        'purchaseReturn'=>PurchasePage::class,
        'purchaseReturnItems'=>PurchaseInvoiceResource::class,
        'purchaseReturnCodes'=>PurchaseInvoiceResource::class,
        'purchaseReturnExpenses'=>PurchaseExpenseResource::class,
        'sale'=>SalePage::class,
        'saleItems'=>SaleInvoiceResource::class,
        'saleCodes'=>SaleInvoiceResource::class,
        'saleReturn'=>SaleInvoiceResource::class,
        'saleReturnItems'=>SaleInvoiceResource::class,
        'saleReturnCodes'=>SaleInvoiceResource::class,
        'saleInstallment'=>SaleInvoiceResource::class,
        'saleInstallmentItems'=>SaleInvoiceResource::class,
        'saleInstallmentCodes'=>SaleInvoiceResource::class,
        'itemRepairs'=>ItemRepairResource::class
    ];
    public function mount()
    {
        $data = [];
        if(userHasBranch()){
            $data = ['branch_id'=>[
                getBranchId()
            ]];
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


    //repair items
    public function itemRepairsSearch(){
        if(checkPackage('POS')){
            $this->itemRepairsForm->getState();
            $data = $this->itemRepairs;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $branch = json_encode($data['branch_id']??[]);
            $warehouse = json_encode($data['warehouse_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(ItemRepairs::getUrl(['branch'=>$branch,'warehouse'=>$warehouse,'item'=>$item,'from'=>$from,'to'=>$to,'type'=>$data['type']??'all']));
        }else{
            return '';
        }
    }
    public function itemRepairsForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\ItemRepair::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                    Select::make('item_id')
                        ->relationship('item','name_'.App::getLocale())
                        ->multiple()
                        ->searchable()
                        ->preload(),
                    Select::make('type')
                        ->options(\App\Models\POS\ItemRepair::getTypes())
                        ->native(0),
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


                ])->statePath('itemRepairs');
        }else{
            return $form->statePath('itemRepairs');
        }
    }
    //purchase
    public function purchaseSearch(){
        if(checkPackage('POS')){
            $this->purchaseForm->getState();
            $data = $this->purchase;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(Purchase::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'type'=>'purchase']));
        }else{
            return '';
        }
    }
    public function purchaseForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\PurchaseInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->columnSpanFull()
                        ->preload(),
                    Select::make('contact_id')
                        ->columnSpanFull()
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                ])->statePath('purchase');
        }else{
            return $form->statePath('purchase');
        }
    }
    public function purchaseItemsSearch(){
        if(checkPackage('POS')){
            $this->purchaseItemsForm->getState();
            $data = $this->purchaseItems;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(PurchaseItems::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'purchase']));
        }else{
            return '';
        }
    }
    public function purchaseItemsForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\PurchaseInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('purchaseItems');
        }else{
            return $form->statePath('purchaseItems');
        }
    }
    public function purchaseCodesSearch(){
        if(checkPackage('POS')){
            $this->purchaseCodesForm->getState();
            $data = $this->purchaseCodes;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(PurchaseCodes::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'purchase']));
        }else{
            return '';
        }
    }
    public function purchaseCodesForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\PurchaseInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('purchaseCodes');
        }else{
            return $form->statePath('purchaseCodes');
        }
    }

    public function purchaseExpensesSearch(){
        if(checkPackage('POS')){
            $this->purchaseExpensesForm->getState();
            $data = $this->purchaseExpenses;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(PurchaseExpenses::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'type'=>'purchase']));
        }else{
            return '';
        }
    }
    public function purchaseExpensesForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\PurchaseInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->columnSpanFull()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->columnSpanFull()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),

                ])->statePath('purchaseEpxenses');
        }else{
            return $form->statePath('purchaseEpxenses');
        }
    }

//    purchase Return
    public function purchaseReturnSearch(){
        if(checkPackage('POS')){
            $this->purchaseReturnForm->getState();
            $data = $this->purchaseReturn;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(Purchase::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'type'=>'return']));
        }else{
            return '';
        }
    }
    public function purchaseReturnForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\PurchaseInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->columnSpanFull()
                        ->preload(),
                    Select::make('contact_id')
                        ->columnSpanFull()
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                ])->statePath('purchaseReturn');
        }else{
            return $form->statePath('purchaseReturn');
        }
    }
    public function purchaseReturnItemsSearch(){
        if(checkPackage('POS')){
            $this->purchaseReturnItemsForm->getState();
            $data = $this->purchaseReturnItems;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(PurchaseItems::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'return']));
        }else{
            return '';
        }
    }
    public function purchaseReturnItemsForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\PurchaseInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('purchaseReturnItems');
        }else{
            return $form->statePath('purchaseReturnItems');
        }
    }
    public function purchaseReturnCodesSearch(){
        if(checkPackage('POS')){
            $this->purchaseReturnCodesForm->getState();
            $data = $this->purchaseReturnCodes;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(PurchaseCodes::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'return']));
        }else{
            return '';
        }
    }
    public function purchaseReturnCodesForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\PurchaseInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('purchaseReturnCodes');
        }else{
            return $form->statePath('purchaseReturnCodes');
        }
    }

    public function purchaseReturnExpensesSearch(){
        if(checkPackage('POS')){
            $this->purchaseReturnExpensesForm->getState();
            $data = $this->purchaseReturnCodes;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(PurchaseExpenses::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'type'=>'return']));
        }else{
            return '';
        }
    }
    public function purchaseReturnExpensesForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\PurchaseInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->columnSpanFull()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->columnSpanFull()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),

                ])->statePath('purchaseReturnEpxenses');
        }else{
            return $form->statePath('purchaseReturnEpxenses');
        }
    }
// sale
    public function saleSearch(){
        if(checkPackage('POS')){
            $this->saleForm->getState();
            $data = $this->sale;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(Sale::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'type'=>'sale']));
        }else{
            return '';
        }
    }
    public function saleForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\SaleInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->searchable()
                        ->live()
                        ->columnSpanFull()
                        ->preload(),
                    Select::make('contact_id')
                        ->columnSpanFull()
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                ])->statePath('sale');
        }else{
            return $form->statePath('sale');
        }
    }
    public function saleItemsSearch(){
        if(checkPackage('POS')){
            $this->saleItemsForm->getState();
            $data = $this->saleItems;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(SaleItems::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'sale']));
        }else{
            return '';
        }
    }
    public function saleItemsForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\SaleInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('saleItems');
        }else{
            return $form->statePath('saleItems');
        }
    }
    public function saleCodesSearch(){
        if(checkPackage('POS')){
            $this->saleCodesForm->getState();
            $data = $this->saleCodes;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(SaleCodes::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'sale']));
        }else{
            return '';
        }
    }
    public function saleCodesForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\SaleInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('saleCodes');
        }else{
            return $form->statePath('saleCodes');
        }
    }

//    sale return
    public function saleReturnSearch(){
        if(checkPackage('POS')){
            $this->saleReturnForm->getState();
            $data = $this->saleReturn;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(Sale::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'type'=>'return']));
        }else{
            return '';
        }
    }
    public function saleReturnForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\SaleInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->searchable()
                        ->live()
                        ->columnSpanFull()
                        ->preload(),
                    Select::make('contact_id')
                        ->columnSpanFull()
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                ])->statePath('saleReturn');
        }else{
            return $form->statePath('saleReturn');
        }
    }
    public function saleReturnItemsSearch(){
        if(checkPackage('POS')){
            $this->saleReturnItemsForm->getState();
            $data = $this->saleReturnItems;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(SaleItems::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'return']));
        }else{
            return '';
        }
    }
    public function saleReturnItemsForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\SaleInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('saleReturnItems');
        }else{
            return $form->statePath('saleReturnItems');
        }
    }
    public function saleReturnCodesSearch(){
        if(checkPackage('POS')){
            $this->saleReturnCodesForm->getState();
            $data = $this->saleReturnCodes;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(SaleCodes::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'return']));
        }else{
            return '';
        }
    }
    public function saleReturnCodesForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\SaleInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('saleReturnCodes');
        }else{
            return $form->statePath('saleReturnCodes');
        }
    }

    // installment
    public function saleInstallmentSearch(){
        if(checkPackage('POS')){
            $this->saleInstallmentForm->getState();
            $data = $this->saleInstallment;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(Sale::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'type'=>'installment']));
        }else{
            return '';
        }
    }
    public function saleInstallmentForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\SaleInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->searchable()
                        ->live()
                        ->columnSpanFull()
                        ->preload(),
                    Select::make('contact_id')
                        ->columnSpanFull()
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                ])->statePath('saleInstallment');
        }else{
            return $form->statePath('saleInstallment');
        }
    }
    public function saleInstallmentItemsSearch(){
        if(checkPackage('POS')){
            $this->saleInstallmentItemsForm->getState();
            $data = $this->saleInstallmentItems;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(SaleItems::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'installment']));
        }else{
            return '';
        }
    }
    public function saleInstallmentItemsForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\SaleInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('saleInstallmentItems');
        }else{
            return $form->statePath('saleInstallmentItems');
        }
    }
    public function saleInstallmentCodesSearch(){
        if(checkPackage('POS')){
            $this->saleInstallmentCodesForm->getState();
            $data = $this->saleInstallmentCodes;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            $item = json_encode($data['item_id']??[]);
            return $this->redirect(SaleCodes::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'item'=>$item,'type'=>'installment']));
        }else{
            return '';
        }
    }
    public function saleInstallmentCodesForm(Form $form): Form
    {
        if(checkPackage('POS')){
            return $form->columns(2)->model(\App\Models\POS\SaleInvoice::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                     Select::make('branch_id')
                        ->hidden(userHasBranch())
                        ->relationship('branch','name')
                        ->multiple()
                        ->live()
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->live()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                    Select::make('item_id')
                        ->label(trans('Inventory/lang.item.plural_label'))
                        ->columnSpan(userHasBranch() ? 1:'full')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('saleInstallmentCodes');
        }else{
            return $form->statePath('saleInstallmentCodes');
        }
    }



    public function render():View
    {
        return view('livewire.reports.reports-content');
    }
}
