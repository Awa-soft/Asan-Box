<?php

namespace App\Filament\Pages\Reports\Logistic;

use Filament\Pages\Page;
use Livewire\WithPagination;

class WareHouse extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    use WithPagination;
    protected static ?string $slug = 'reports/logistic/warehouse/{attr}/{warehouses}';
    protected static bool $shouldRegisterNavigation = false;
    public $attr,$data;
    public function mount($attr,$warehouses){
        $warehouses = json_decode($warehouses,0);
        $this->attr = json_decode($attr,0);
        $this->data = \App\Models\Logistic\Warehouse::when($warehouses!=[],function ($q)use($warehouses){
            return $q->whereIn('id',$warehouses);
        })->get();
    }
    protected static string $view = 'filament.pages.reports.logistic.ware-house';
}
