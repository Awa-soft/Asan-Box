<?php

namespace App\Filament\Resources\Finance\BoursePaymentResource\Pages;

use App\Filament\Resources\Finance\BoursePaymentResource;
use App\Traits\Core\TranslatableForm;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBoursePayment extends CreateRecord
{
    use TranslatableForm;

    protected static string $resource = BoursePaymentResource::class;
}
