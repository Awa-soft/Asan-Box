<?php

namespace App\Livewire\Reports;

use App\Filament\Pages\Reports\HR\EmployeeSalary;
use App\Filament\Pages\Reports\POS\Purchase;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\View\View;
use Livewire\Component;

class POS extends Component  implements HasForms
{
    use InteractsWithForms;
    public $purchase=[];

    protected function getForms(): array
    {
        return [
            'purchaseForm',
            'saleForm'
        ];
    }
    public function searchPurchase(){
        if(checkPackage('HR')){
            $data = $this->purchaseForm->getState();
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(Purchase::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to]));
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
                        ->searchable()
                        ->columnSpanFull()
                        ->preload(),
                    Select::make('contact_id')
                        ->columnSpanFull()
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                ])->statePath('purchase');
        }else{
            return $form->statePath('purchase');
        }
    }


    public function searchSale(){
        if(checkPackage('HR')){
            $data = $this->purchaseForm->getState();
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $contact = json_encode($data['contact_id']??[]);
            $branch = json_encode($data['branch_id']??[]);
            return $this->redirect(Purchase::getUrl(['branch'=>$branch,'contact'=>$contact,'from'=>$from,'to'=>$to]));
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
                        ->columnSpanFull()
                        ->preload(),
                    Select::make('contact_id')
                        ->columnSpanFull()
                        ->label(trans('lang.contact'))
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->relationship("contact", "name_".\Illuminate\Support\Facades\App::getLocale()),
                ])->statePath('sale');
        }else{
            return $form->statePath('sale');
        }
    }

    public function mount():void
    {
        $this->purchaseForm->fill();
        $this->saleForm->fill();
    }
    public function render():View
    {
        return view('livewire.reports.p-o-s');
    }
}
