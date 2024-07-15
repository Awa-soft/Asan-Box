<?php

namespace App\Filament\Pages\Reports\POS;

use Carbon\Carbon;
use Filament\Pages\Page;

class SaleCodes extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/pos/saleCodes/{from}/{to}/{contact}/{branch}/{item}/{type}';
    protected static bool $shouldRegisterNavigation = false;
    public  $data;
    public $from,$to,$currencies,$type;
    public function mount($from,$to,$branch,$contact,$item,$type):void{
        $this->type = $type;
        $branches = json_decode($branch,0);
        $contacts = json_decode($contact,0);
        $item = json_decode($item,0);
        $this->from = $from;
        $this->to = $to;
        $this->data = \App\Models\POS\SaleDetail::
        whereHas('invoice',function ($query)use ($from,$to,$branches,$contacts,$type){
            return $query
                ->where('type',$type)
                ->when($branches!=[],function ($q)use($branches){
                return $q->whereIn('branch_id',$branches);
            })->when($contacts !=[],function ($q)use($contacts){
                return $q->whereIn('contact_id',$contacts);
            })->when($from != 'all', function ($query)use($from) {
                return $query->whereDate('date', '>=', Carbon::parse($from));
            })->when($to != 'all', function ($query)use($to) {
                return $query->whereDate('date', '<=', Carbon::parse($to));
            });
        })->when($item != [],function ($q)use($item){
            return $q->whereIn('item_id', $item);
        })->orderBy('item_id','asc')->get();

        $this->currencies = \App\Models\Settings\Currency::all();
    }
    protected static string $view = 'filament.pages.reports.p-o-s.sale-codes';
}
