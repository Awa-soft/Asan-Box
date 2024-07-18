<?php

namespace App\Filament\Pages\Reports\CRM;

use Carbon\Carbon;
use Filament\Pages\Page;

class PartnerAccount extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/CRM/partnerAccounts/{partner}/{partnerShip}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $data;

    public function mount($partner,$partnerShip): void
    {
        $partnerShip = json_decode($partnerShip, 0);
        $partner = json_decode($partner, 0);

        $this->data = \App\Models\CRM\PartnerAccount::when(!empty($partner) , function ($q) use ($partner) {
            $q->whereIn('partner_id', $partner);
        })->when(!empty($partnerShip) , function ($q) use ($partnerShip) {
            $q->whereIn('partnership_id', $partnerShip);
        })->get();
    }
    protected static string $view = 'filament.pages.reports.c-r-m.partner-account';
}
