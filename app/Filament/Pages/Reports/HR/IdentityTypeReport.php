<?php

namespace App\Filament\Pages\Reports\HR;

use App\Models\HR\EmployeeNote;
use App\Models\HR\IdentityType;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class IdentityTypeReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports.h-r.identity-type-report';

    use WithPagination;
    protected static ?string $slug = 'reports/hr/employee-identity-types/{attr}';
    protected static bool $shouldRegisterNavigation = false;

    public  $attr = [];

    public function mount($attr){
        $this->attr = json_decode($attr,0);
    }
    public function render(): View
    {
        $data = IdentityType::all();
        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with('data', $data);
    }
}
