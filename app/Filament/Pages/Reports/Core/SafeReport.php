<?php

namespace App\Filament\Pages\Reports\Core;

use Filament\Pages\Page;

class SafeReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports.core.safe-report';
}
