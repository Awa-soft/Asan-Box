<?php

namespace App\Filament\Pages\Reports\CRM;

use Carbon\Carbon;
use Filament\Pages\Page;

class PartnerShip extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/CRM/partnership/{branch}/{from}/{to}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $data,$from,$to;

    public function mount($branch,$from,$to): void
    {
        $this->from = $from;
        $this->to = $to;
        if (!userHasBranch()) {
            $branches = json_decode($branch, 0);
        } else {
            $branches = [getBranchId()];
        }
        $this->data = \App\Models\CRM\Partnership::when(!empty($branches) , function ($q) use ($branches) {
            $q->whereIn('branch_id', $branches);
        })->when($from != 'all', function ($query)use($from) {
            return $query->whereDate('start_date', '>=', Carbon::parse($from));
        })->when($to != 'all', function ($query)use($to) {
            return $query->whereDate('end_date', '<=', Carbon::parse($to));
        })->get();
    }
    protected static string $view = 'filament.pages.reports.c-r-m.partner-ship';
}
