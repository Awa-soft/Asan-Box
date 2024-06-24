<?php

namespace App\Livewire\Core;

use Filament\Widgets\Widget;

class CurrencyOverview extends Widget
{
    public $symbol, $amount, $name;
    protected static string $view = 'livewire.core.currency-overview';
}
