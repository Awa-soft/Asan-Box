<?php

namespace App\Filament\Resources\Finance\PaymentResource\Pages;

use App\Filament\Resources\Finance\PaymentResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    use TranslatableForm;
    protected static string $resource = PaymentResource::class;
}
