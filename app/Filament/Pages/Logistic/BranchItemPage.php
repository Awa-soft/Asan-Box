<?php

namespace App\Filament\Pages\Logistic;

use App\Models\Inventory\Category;
use App\Models\Inventory\Item;
use App\Models\Logistic\Branch;
use App\Models\Logistic\BranchItem;
use App\Models\Logistic\PurchaseInvoice;
use App\Models\Settings\Currency;
use App\Traits\Core\OwnerableTrait;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Exception;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class BranchItemPage extends Page implements HasForms
{
    use HasPageShield, InteractsWithForms;
    protected static ?string $navigationIcon = 'iconpark-buy';
    public static function getNavigationLabel(): string
    {
        return trans('Logistic/lang.branch_item.plural_label');
    }
    public  function getHeading(): string
    {
        return "";
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('Logistic/lang.group_label');
    }

    public $branchs, $items, $transfered=[], $selected = [], $selectedTransfered =[], $selectedBranch;

    public function mount(){
        $this->branchs = Branch::all();
        $this->items = Item::all();
        $this->transfered['data'] = [];
    }

    public function updated(){
        if($this->selectedBranch){
            $this->transfered['data'] = Branch::find($this->selectedBranch)->items;
        }
    }

    public function addToSelect($type, $id){
       if($type == "selection"){
         // if id exists in selected array, remove it
         if (in_array($id, $this->selected)) {
            $key = array_search($id, $this->selected);
            unset($this->selected[$key]);
            return;
        }
        // add id to selected array
        $this->selected[] = $id;
       }
       else{
        if (in_array($id, $this->selectedTransfered)) {
            $key = array_search($id, $this->selectedTransfered);
            unset($this->selectedTransfered[$key]);
            return;
        }
        $this->selectedTransfered[] = $id;
       }
    }

    public function selectAll($type, $operation){
        if($type == "items"){
            if($operation == "select"){
                $this->selected = $this->items->pluck('id')->toArray();
            }
            else{
                $this->selected = [];
            }
        }
        else{
            if($operation == "select"){
                $this->selectedTransfered = $this->transfered['data']->pluck('id')->toArray();
            }
            else{
                $this->selectedTransfered = [];
            }
        }
    }

    public function transfer(){
        // transfer selected to transfered array if not exists using Item::find()
        if($this->selectedBranch != null){
            foreach($this->selected as $id){
                if(!in_array($id, collect($this->transfered['data'])->pluck('id')->toArray())){
                    $this->transfered['data'][] = Item::find($id);
                }

            Notification::make()
            ->title(trans("filament-actions::edit.single.notifications.saved.title"))
            ->success()
            ->send();
            }
            Branch::find($this->selectedBranch)->items()->sync(collect($this->transfered['data'])->pluck('id')->toArray());
            $this->selected = [];
        }
        else{
            Notification::make()
            ->title(trans("lang.please_select",["name" => trans("lang.branch")]))
            ->warning()
            ->send();
        }
    }

    public function transferBack()
    {
        if ($this->selectedTransfered != null) {
            foreach ($this->selectedTransfered as $id) {
                if (in_array($id, collect($this->transfered['data'])->pluck('id')->toArray())) {
                    $key = array_search($id, collect($this->transfered['data'])->pluck('id')->toArray());
                    unset($this->transfered['data'][$key]);
                }
                Notification::make()
                    ->title(trans("filament-actions::edit.single.notifications.saved.title"))
                    ->success()
                    ->send();
            }
            Branch::find($this->selectedBranch)->items()->sync(collect($this->transfered['data'])->pluck('id')->toArray());
            $this->selectedTransfered = [];
        }
    }

    protected static string $view = 'filament.pages.logistic.branch-item-page';
}
