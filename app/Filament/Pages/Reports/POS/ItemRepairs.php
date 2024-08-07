<?php

namespace App\Filament\Pages\Reports\POS;

use App\Models\POS\ItemRepair;
use Carbon\Carbon;
use Filament\Pages\Page;

class ItemRepairs extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/pos/itemRepairs/{from}/{to}/{warehouse}/{branch}/{type}/{item}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $from,$to,$type,$item,$data,$currencies;

    public function mount($from,$to,$warehouse,$branch,$type,$item): void{
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
        $this->type = $type;
        $this->data = ItemRepair::
        when(!empty($branches) || !empty($warehouses), function ($q) use ($branches, $warehouses) {
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
        })->when($type != 'all', function ($query)use($type) {
            return $query->where('type', $type);
        })->get();
        $this->currencies = \App\Models\Settings\Currency::all();

    }
    protected static string $view = 'filament.pages.reports.p-o-s.item-repairs';
}
