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
        $this->branchs = Branch::where('status',1)->get();
        $this->items = Item::all();
        $this->transfered['data'] = [];
    }

    public function updated(){
        if($this->selectedBranch){
            $this->transfered['data'] = Branch::find($this->selectedBranch)->items;
        }else{
            $this->transfered['data']= [];
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

    public function resetSelections()
    {
        $this->selected= [];
        $this->selectedTransfered=[];
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
        $items = [];
        if($this->selectedBranch != null){
            foreach($this->selected as $id){
                $items[] = [
                    'item_id'=>$id,
                    'branch_id'=>$this->selectedBranch,
                ];
            }
            BranchItem::where('branch_id',$this->selectedBranch)->whereIn('item_id',$this->selected)->delete();
            BranchItem::insert($items);
            $this->selected = [];
            Notification::make()
                ->title(trans("filament-actions::edit.single.notifications.saved.title"))
                ->success()
                ->send();
        }
        else{
            Notification::make()
            ->title(trans("lang.please_select",["name" => trans("lang.branch")]))
            ->warning()
            ->send();
        }
        $this->updated();
    }


    public function transferBack()
    {
            BranchItem::where('branch_id',$this->selectedBranch)->whereIn('item_id',$this->selectedTransfered)->delete();
            Notification::make()
                ->title(trans("filament-actions::edit.single.notifications.saved.title"))
                ->success()
                ->send();
            $this->selectedTransfered = [];
            $this->updated();
    }

    protected static string $view = 'filament.pages.logistic.branch-item-page';
}
