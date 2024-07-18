<?php

namespace App\Filament\Pages\Reports\HR;

use App\Exports\ExcelExport;
use App\Models\HR\IdentityType;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class IdentityTypeReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports.h-r.identity-type-report';

    use WithPagination;
    protected static ?string $slug = 'reports/hr/employee-identity-types/{attr}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public  $attr = [];
    protected function getHeaderActions(): array
    {
        return [
            Action::make("excel")
            ->label(trans("lang.excel"))
                ->action(fn()=>$this->exportExcel())
                ->color("success"),
        ];
    }

    public function exportExcel(){
        return Excel::download(new ExcelExport(
            IdentityType::all()
            ,
            count(array_keys($this->attr))>0 ? array_keys($this->attr) : array_keys(IdentityType::getLabels()),
            [
                "ownerable_type",
                "ownerable_id"
            ]
        ), now() . " - identity-types.xlsx");
    }
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
