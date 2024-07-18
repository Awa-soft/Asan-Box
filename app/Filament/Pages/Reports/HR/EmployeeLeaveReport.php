<?php

namespace App\Filament\Pages\Reports\HR;

use App\Exports\ExcelExport;
use App\Models\HR\EmployeeActivity;
use App\Models\HR\EmployeeLeave;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeLeaveReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports.h-r.employee-leave-report';
    protected static ?string $slug = 'reports/hr/employee-leave/{from}/{to}/{employee_id}/{attr}/{status}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public  $from,$to,$employee_id,$attr = [],$status=[];
    protected function getHeaderActions(): array
    {
        return [
            Action::make("excel")
            ->label(trans("lang.excel"))
                ->action(fn()=>$this->exportExcel())
                ->color("success"),
        ];
    }
    public function mount($from,$to,$employee_id,$attr,$status){
        $this->from = $from;
        $this->to = $to;
        $this->employee_id = $employee_id;
        $this->attr = json_decode($attr,0);
        $this->status = json_decode($status,0);
    }

    public function exportExcel(){
        return Excel::download(new ExcelExport(
            EmployeeLeave::when($this->from != 'all', function ($query) {
                return $query->whereDate('date', '>=', Carbon::parse($this->from));
            })->when($this->to!= 'all', function ($query) {
                return $query->whereDate('date', '<=', Carbon::parse($this->to));
            })->when($this->employee_id!= 'all', function ($query) {
                return $query->where('employee_id', $this->employee_id);
            })->when($this->status != [], function ($query) {
                return $query->whereIn('status', $this->status);
            })
            ,
            count(array_keys($this->attr))>0 ? array_keys($this->attr) : array_keys(EmployeeLeave::getLabels()),
            [
                "ownerable_type",
                "ownerable_id"
            ]
        ), now() . " - employee-leaves.xlsx");
    }
    public function render(): View
    {
        $data = EmployeeLeave::when($this->from != 'all', function ($query) {
            return $query->whereDate('date', '>=', Carbon::parse($this->from));
        })->when($this->to!= 'all', function ($query) {
            return $query->whereDate('date', '<=', Carbon::parse($this->to));
        })->when($this->employee_id!= 'all', function ($query) {
            return $query->where('employee_id', $this->employee_id);
        })->when($this->status != [], function ($query) {
            return $query->whereIn('status', $this->status);
        })->get();
        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with('data', $data);
    }

}
