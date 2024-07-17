<?php

namespace App\Filament\Pages\Reports\Inventory;

use App\Models\Inventory\Category;
use Carbon\Carbon;
use Filament\Pages\Page;

class Details extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/inventory/itemDetails/{warehouse}/{branch}/{type}/{status}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $type,$data;

    public function mount($warehouse,$branch,$type,$status): void{
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
        $this->type == $type;
         if($type == 'categories'){
             $class = \App\Models\Inventory\Category::class;
         }elseif($type == 'brands'){
             $class = \App\Models\Inventory\Brand::class;
         }else{
             $class = \App\Models\Inventory\Unit::class;
         }
        $this->data = $class::when(!empty($branches) || !empty($warehouses), function ($q) use ($branches, $warehouses) {
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
        })->when($status != 'all',function ($q)use($status){
            if($status == 'yes'){
                return $q->where('status',1);
            }else{
                return $q->where('status',0);
            }
        })->get();

    }
    protected static string $view = 'filament.pages.reports.inventory.details';
}
