<?php

namespace App\Filament\Pages\Reports\POS;

use Carbon\Carbon;
use Filament\Pages\Page;

class Sale extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/pos/sale/{from}/{to}/{contact}/{branch}/{type}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';
    public  $data;
    public $from,$to,$currencies,$type;
    public function mount($from,$to,$branch,$contact,$type):void{
        $this->type = $type;
        if(!userHasBranch()) {
            $branches = json_decode($branch, 0);
        }else{
            $branches = [getBranchId()];
        }
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
        })->where('type',$type)->get();
        $this->currencies = \App\Models\Settings\Currency::all();
    }
    protected static string $view = 'filament.pages.reports.p-o-s.sale';
}
