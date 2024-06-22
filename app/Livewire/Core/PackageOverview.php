<?php

namespace App\Livewire\Core;

use Filament\Widgets\Widget;

class PackageOverview extends Widget
{
    public $name, $version, $description, $status, $active_date, $type, $price, $color;
    protected static string $view = 'livewire.core.package-overview';
}
