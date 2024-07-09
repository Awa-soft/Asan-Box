<?php

namespace App\Filament\Resources\POS\SaleInvoiceResource\Pages;

use App\Filament\Resources\POS\SaleInvoiceResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class Receipt extends Page
{
    protected static string $resource = SaleInvoiceResource::class;
    use InteractsWithRecord;
    
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
    protected static string $view = 'filament.resources.p-o-s.sale-invoice-resource.pages.receipt';
}
