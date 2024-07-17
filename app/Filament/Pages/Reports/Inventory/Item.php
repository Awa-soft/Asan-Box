<?php

namespace App\Filament\Pages\Reports\Inventory;

use Carbon\Carbon;
use Filament\Pages\Page;

class Item extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/inventory/items/{from}/{to}/{categories}/{units}/{brands}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $from,$to,$data;

    public function mount($from,$to,$brands,$categories,$units): void{
        $categories = json_decode($categories, 0);
        $brands = json_decode($brands, 0);
        $units = json_decode($units, 0);

        $this->from = $from;
        $this->to = $to;
        $this->data = \App\Models\Inventory\Item::when($categories != [],function ($q)use($categories){
            return $q->whereIn('category_id',$categories);
        })->when($brands!=[],function ($q)use($brands){
            return $q->whereIn('brand_id',$brands);
        })->when($units != [],function ($q)use($units){
            return $q->whereIn('unit_id',$units);
        })->when($from != 'all', function ($query)use($from) {
            return $query->whereDate('date', '>=', Carbon::parse($from));
        })->when($to != 'all', function ($query)use($to) {
            return $query->whereDate('date', '<=', Carbon::parse($to));
        })->get();

    }
    protected static string $view = 'filament.pages.reports.inventory.item';
}
