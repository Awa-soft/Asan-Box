<?php

namespace App\Filament\Pages\Reports\Logistic;

use Carbon\Carbon;
use Filament\Pages\Page;

class ItemTransactions extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/logistic/branch/{warehouses}/{branches}/{to}/{from}';
    protected static bool $shouldRegisterNavigation = false;
    public $data,$from,$to;
    public function mount($from,$to,$warehouses,$branches){
        $this->from = $from;
        $this->to = $to;
        $branches = json_decode($branches,0);
        $warehouses = json_decode($warehouses,0);
        $this->data = \App\Models\Logistic\ItemTransactionInvoice::when($branches!=[],function ($q)use($branches){
            $q->where(function($query) use ($branches) {
                $query->whereIn('fromable_id', $branches)->where('fromable_type', 'App\Models\Logistic\Branch');
            })->orWhere(function($query) use ($branches) {
                $query->whereIn('toable_id', $branches)->where('toable_type', 'App\Models\Logistic\Branch');
            });
        })->when($branches!=[],function ($q)use($warehouses){
            $q->where(function($query) use ($warehouses) {
                $query->whereIn('fromable_id', $warehouses)->where('fromable_type', 'App\Models\Logistic\Warehouse');
            })->orWhere(function($query) use ($warehouses) {
                $query->whereIn('toable_id', $warehouses)->where('toable_type', 'App\Models\Logistic\Warehouse');
            });
        })->when($from != 'all', function ($query)use($from) {
            return $query->whereDate('date', '>=', Carbon::parse($from));
        })->when($to != 'all', function ($query)use($to) {
            return $query->whereDate('date', '<=', Carbon::parse($to));
        })->get();
    }

    protected static string $view = 'filament.pages.reports.logistic.item-transactions';
}
