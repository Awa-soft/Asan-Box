<?php

namespace App\Filament\Pages\Reports\Inventory;

use App\Models\POS\ItemRepair;
use Carbon\Carbon;
use Filament\Pages\Page;

class ItemLoss extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/inventory/itemLoss/{from}/{to}/{warehouse}/{branch}/{item}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $from,$to,$item,$data,$currencies;

    public function mount($from,$to,$warehouse,$branch,$item): void{
        if(!userHasBranch()) {
            $branches = json_decode($branch, 0);
        }else{
            $branches = [getBranchId()];
        }
        if(!userHasWarehouse()) {
            $warehouses = json_decode($warehouse, 0);
        }else{
            $warehouses = [getWarehouseId()];
        }
        $items = json_decode($item, 0);
        $this->from = $from;
        $this->to = $to;
        $this->data = \App\Models\Inventory\ItemLoss::when(!empty($branches) || !empty($warehouses), function ($q) use ($branches, $warehouses) {
            $q->where(function ($query) use ($branches, $warehouses) {
                if (!empty($branches)) {
                    $query->where('ownerable_type', 'App\Models\Logistic\Branch')
                        ->whereIn('ownerable_id', $branches);
                }
                if (!empty($warehouses)) {
                    $query->orWhere(function ($query) use ($warehouses) {
                        $query->where('ownerable_type', 'App\Models\Logistic\Warehouse')
                            ->whereIn('ownerable_id', $warehouses);
                    });
                }
            });
        })->when($items != [],function ($q)use($items){
            return $q->whereIn('item_id',$items);
        })->when($from != 'all', function ($query)use($from) {
            return $query->whereDate('date', '>=', Carbon::parse($from));
        })->when($to != 'all', function ($query)use($to) {
            return $query->whereDate('date', '<=', Carbon::parse($to));
        })->get();
        $this->currencies = \App\Models\Settings\Currency::all();

    }
    protected static string $view = 'filament.pages.reports.inventory.item-loss';
}
