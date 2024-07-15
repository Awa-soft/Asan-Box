<?php

namespace App\Livewire\Reports;

use App\Filament\Pages\Reports\HR\EmployeeSalary;
use App\Filament\Pages\Reports\POS\Purchase;
use App\Filament\Pages\Reports\POS\PurchaseCodes;
use App\Filament\Pages\Reports\POS\PurchaseExpenses;
use App\Filament\Pages\Reports\POS\PurchaseItems;
use App\Filament\Pages\Reports\POS\SaleCodes;
use App\Filament\Pages\Reports\POS\SaleItems;
use App\Models\Inventory\Item;
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

    protected function getForms(): array
    {
        return [
            'purchaseForm',
            'purchaseItemsForm',
            'purchaseCodesForm',
            'purchaseExpensesForm',
            'purchaseReturnForm',
            'purchaseReturnItemsForm',
            'purchaseReturnCodesForm',
            'purchaseReturnExpensesForm',
            'saleForm',
            'saleItemsForm',
            'saleCodesForm',
            'saleReturnForm',
            'saleReturnItemsForm',
            'saleReturnCodesForm',
        ];
    }

    //purchase
    public function searchPurchase(){
        if(checkPackage('HR')){
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
    public function searchPurchaseItems(){
        if(checkPackage('HR')){
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
                        ->columnSpanFull()
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('purchaseItems');
        }else{
            return $form->statePath('purchaseItems');
        }
    }
    public function searchPurchaseCodes(){
        if(checkPackage('HR')){
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
                        ->columnSpanFull()
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('purchaseCodes');
        }else{
            return $form->statePath('purchaseCodes');
        }
    }

    public function searchPurchaseExpenses(){
        if(checkPackage('HR')){
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
    public function searchPurchaseReturn(){
        if(checkPackage('HR')){
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
    public function searchPurchaseReturnItems(){
        if(checkPackage('HR')){
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
                        ->columnSpanFull()
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('purchaseReturnItems');
        }else{
            return $form->statePath('purchaseReturnItems');
        }
    }
    public function searchPurchaseReturnCodes(){
        if(checkPackage('HR')){
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
                        ->columnSpanFull()
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('purchaseReturnCodes');
        }else{
            return $form->statePath('purchaseReturnCodes');
        }
    }

    public function searchPurchaseReturnExpenses(){
        if(checkPackage('HR')){
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
    public function searchSale(){
        if(checkPackage('HR')){
            $this->saleForm->getState();
            $data = $this->sale;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(Purchase::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'type'=>'sale']));
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
    public function searchSaleItems(){
        if(checkPackage('HR')){
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
                        ->columnSpanFull()
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('saleItems');
        }else{
            return $form->statePath('saleItems');
        }
    }
    public function searchSaleCodes(){
        if(checkPackage('HR')){
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
                        ->columnSpanFull()
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
    public function searchSaleReturn(){
        if(checkPackage('HR')){
            $this->saleReturnForm->getState();
            $data = $this->saleReturn;
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(Purchase::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to,'type'=>'return']));
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
    public function searchSaleReturnItems(){
        if(checkPackage('HR')){
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
                        ->columnSpanFull()
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->options(Item::all()->pluck('name_'.App::getLocale(),'id'))
                ])->statePath('saleReturnItems');
        }else{
            return $form->statePath('saleReturnItems');
        }
    }
    public function searchSaleReturnCodes(){
        if(checkPackage('HR')){
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
                        ->columnSpanFull()
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


    public function mount():void
    {
        $this->purchaseForm->fill();
        $this->purchaseItemsForm->fill();
        $this->purchaseCodesForm->fill();
        $this->purchaseExpensesForm->fill();

        $this->purchaseReturnForm->fill();
        $this->purchaseReturnItemsForm->fill();
        $this->purchaseReturnCodesForm->fill();
        $this->purchaseReturnExpensesForm->fill();

        $this->saleForm->fill();
        $this->saleItemsForm->fill();
        $this->saleCodesForm->fill();

        $this->saleReturnForm->fill();
        $this->saleReturnItemsForm->fill();
        $this->saleReturnCodesForm->fill();
    }
    public function render():View
    {
        return view('livewire.reports.p-o-s');
    }
}
