<?php

namespace App\Filament\Pages\Reports\HR;

use App\Exports\ExcelExport;
use App\Models\HR\EmployeeActivity;
use App\Models\HR\EmployeeNote;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeNoteReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports.h-r.employee-note-report';
    use WithPagination;
    protected static ?string $slug = 'reports/hr/employee-notes/{from}/{to}/{employee_id}/{attr}';
    protected static bool $shouldRegisterNavigation = false;

    public  $from,$to,$employee_id,$attr = [];
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
            EmployeeNote::when($this->from != 'all', function ($query) {
                return $query->whereDate('date', '>=', Carbon::parse($this->from));
            })->when($this->to!= 'all', function ($query) {
                return $query->whereDate('date', '<=', Carbon::parse($this->to));
            })->when($this->employee_id!= 'all', function ($query) {
                return $query->where('employee_id', $this->employee_id);
            })
            ,
            count(array_keys($this->attr))>0 ? array_keys($this->attr) : array_keys(EmployeeNote::getLabels()),
            [
                "ownerable_type",
                "ownerable_id"
            ]
        ), now() . " - employee-leaves.xlsx");
    }
    public function mount($from,$to,$employee_id,$attr){
        $this->from = $from;
        $this->to = $to;
        $this->employee_id = $employee_id;
        $this->attr = json_decode($attr,0);
    }

    public function render(): View
    {
        $data = EmployeeNote::when($this->from != 'all', function ($query) {
            return $query->whereDate('date', '>=', Carbon::parse($this->from));
        })->when($this->to!= 'all', function ($query) {
            return $query->whereDate('date', '<=', Carbon::parse($this->to));
        })->when($this->employee_id!= 'all', function ($query) {
            return $query->where('employee_id', $this->employee_id);
        })->get();
        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with('data', $data);
    }
}
