<?php

namespace App\Filament\Pages\Reports\POS;

use Carbon\Carbon;
use Filament\Pages\Page;

class Sale extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/pos/purchase/{from}/{to}/{contact}/{branch}';
    protected static bool $shouldRegisterNavigation = false;
    public  $data;
    public $from,$to,$currencies;
    public function mount($from,$to,$branch,$contact):void{
        $branches = json_decode($branch,0);
        $contacts = json_decode($contact,0);
        $this->from = $from;
        $this->to = $to;
        $this->data = \App\Models\POS\SaleInvoice::when($branches!=[],function ($q)use($branches){
            return $q->whereIn('branch_id',$branches);
        })->when($contacts !=[],function ($q)use($contacts){
            return $q->whereIn('contact_id',$contacts);
        })->when($from != 'all', function ($query)use($from) {
            return $query->whereDate('date', '>=', Carbon::parse($from));
        })->when($to != 'all', function ($query)use($to) {
            return $query->whereDate('date', '<=', Carbon::parse($to));
        })->get();
        $this->currencies = \App\Models\Settings\Currency::all();
    }
    protected static string $view = 'filament.pages.reports.p-o-s.sale';
}
