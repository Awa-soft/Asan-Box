<?php

namespace App\Filament\Resources\Finance\BoursePaymentResource\Pages;

use App\Filament\Resources\Finance\BoursePaymentResource;
use App\Models\Finance\BoursePayment;
use App\Models\Finance\Payment;
use Filament\Resources\Pages\Page;

class Invoice extends Page
{
    protected static string $resource = BoursePaymentResource::class;
    public $record;
    protected static ?string $title = '';
    public function mount($record):void
    {
        $this->record = BoursePayment::findOrFail($record);
    }
    protected static string $view = 'filament.resources.finance.bourse-payment-resource.pages.invoice';
}
