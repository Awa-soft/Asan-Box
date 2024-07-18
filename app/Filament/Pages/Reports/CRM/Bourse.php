<?php

namespace App\Filament\Pages\Reports\CRM;

use App\Models\CRM\Contact;
use Filament\Pages\Page;

class Bourse extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/CRM/bourse/{warehouse}/{branch}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $type,$data;

    public function mount($warehouse,$branch): void
    {
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
        $this->data = \App\Models\CRM\Bourse::when(!empty($branches) || !empty($warehouses), function ($q) use ($branches, $warehouses) {
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
        })->get();
      }
    protected static string $view = 'filament.pages.reports.c-r-m.bourse';
}
