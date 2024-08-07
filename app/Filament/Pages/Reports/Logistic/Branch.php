<?php

namespace App\Filament\Pages\Reports\Logistic;

use Filament\Pages\Page;
use Livewire\WithPagination;

class Branch extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    use WithPagination;
    protected static ?string $slug = 'reports/logistic/branch/{attr}/{branches}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';
    public $attr,$data;
    public function mount($attr,$branches){
        $branches = json_decode($branches,0);
        $this->attr = json_decode($attr,0);
        $this->data = \App\Models\Logistic\Branch::when($branches!=[],function ($q)use($branches){
            return $q->whereIn('id',$branches);
        })->get();
    }

    protected static string $view = 'filament.pages.reports.logistic.branch';
}
