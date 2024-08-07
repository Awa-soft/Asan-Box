<?php

namespace App\Filament\Pages\Reports\CRM;

use App\Models\CRM\Contact;
use Filament\Pages\Page;

class Customer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/CRM/contacts/{warehouse}/{branch}/{debt}/{status}/{type}/{maximumDebt}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $type,$data;

    public function mount($warehouse,$branch,$debt,$status,$type,$maximumDebt): void
    {
        $this->type = $type;
        if (!userHasBranch()) {
            $branches = json_decode($branch, 0);
        } else {
            $branches = [getBranchId()];
        }
        if (!userHasWarehouse()) {
            $warehouses = json_decode($warehouse, 0);
        } else {
            $warehouses = [getWarehouseId()];
        }
        $data = Contact::when(!empty($branches) || !empty($warehouses), function ($q) use ($branches, $warehouses) {
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
                return $q->where('status',1);
            }
        })->debt($debt)->maxDebt($maximumDebt);
        if($type == 'customer'){
            $this->data = $data->customer()->get();
        }elseif($type == 'vendor'){
            $this->data = $data->vendor()->get();
        }else{
            $this->data = $data->both()->get();
        }
    }
    protected static string $view = 'filament.pages.reports.c-r-m.customer';
}
