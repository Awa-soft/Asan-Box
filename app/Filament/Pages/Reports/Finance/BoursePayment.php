<?php

namespace App\Filament\Pages\Reports\Finance;

use App\Models\Settings\Currency;
use Carbon\Carbon;
use Filament\Pages\Page;
use function PHPUnit\Framework\isEmpty;

class BoursePayment extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/Finance/boursePayment/{from}/{to}/{branch}/{currency}/{type}/{bourse}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $data,$currencies;
    public $from,$to;
    public function mount($from,$to,$branch,$currency,$type,$bourse): void
    {
        $this->from = $from;
        $this->to = $to;
        $bourse = json_decode($bourse, 0);
        $currency = json_decode($currency, 0);
        if (!userHasBranch()) {
            $branches = json_decode($branch, 0);
        } else {
            $branches = [getBranchId()];
        }

        $this->data = \App\Models\Finance\BoursePayment::when(!isEmpty($branches),function ($query) use($branches){
            return $query->whereIn('branch_id', $branches);
        })
            ->when($type != 'all', function($query) use($type){
                return $query->where('type', $type);
            })
            ->when(!isEmpty($currency),function ($query) use($currency){
            return $query->whereIn('currency_id', $currency);
        })->when(!isEmpty($bourse),function ($query) use($bourse){
            $query->whereIn('bourse_id', $bourse);
        }) ->when($from != 'all', function ($query)use($from) {
            return $query->whereDate('date', '>=', Carbon::parse($from));
        })->when($to != 'all', function ($query)use($to) {
            return $query->whereDate('date', '<=', Carbon::parse($to));
        })->get();
        $this->currencies = Currency::when(!isEmpty($currency), function ($q) use ($currency){
            return $q->whereIn('id', $currency);
        })->get();

    }
    protected static string $view = 'filament.pages.reports.finance.bourse-payment';
}
