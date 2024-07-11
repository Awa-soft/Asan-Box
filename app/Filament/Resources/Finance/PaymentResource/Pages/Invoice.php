<?php

namespace App\Filament\Resources\Finance\PaymentResource\Pages;

use App\Filament\Resources\Finance\PaymentResource;
use App\Models\Finance\Payment;
use Filament\Resources\Pages\Page;

class Invoice extends Page
{
    protected static string $resource = PaymentResource::class;
    public $record;
    protected static ?string $title = '';
    public function mount($record):void
    {
        $this->record = Payment::findOrFail($record);
    }
    protected static string $view = 'filament.resources.finance.pyemnet-resource.pages.invoice';
}
