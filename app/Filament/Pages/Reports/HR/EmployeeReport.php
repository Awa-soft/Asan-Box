<?php

namespace App\Filament\Pages\Reports\HR;

use App\Exports\ExcelExport;
use App\Models\HR\Employee;
use App\Models\HR\IdentityType;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports.h-r.employee-report';

    use WithPagination;
    protected static ?string $slug = 'reports/hr/employees/{hire_date_from}/{hire_date_to}/{teams}/{positions}/{attr}';
    protected static bool $shouldRegisterNavigation = false;

    public  $attr = [],$hire_date_to = 'all', $hire_date_from = 'all',$positions = [],$teams = [];
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
            Employee::when($this->hire_date_from!= 'all', function ($query) {
                return $query->whereDate('hire_date', '>=', Carbon::parse($this->hire_date_from));
            })->when($this->hire_date_to!= 'all', function ($query) {
                return $query->whereDate('hire_date', '<=', Carbon::parse($this->hire_date_to));
            })->when($this->positions != [],function ($query){
                return $query->whereHas('positions', function ($q) {
                    $q->whereIn('position_id', $this->positions);
                })->when($this->teams != [],function ($query){
                    $query->whereIn('team_id', $this->teams);
                });
            }),
            count(array_keys($this->attr))>0 ? array_keys($this->attr) : array_keys(Employee::getLabels()),
            [
                "ownerable_type",
                "ownerable_id"
            ]
        ), now() . " - employees.xlsx");
    }
    public function mount($attr,$hire_date_to,$hire_date_from,$positions,$teams){
        $this->hire_date_to = $hire_date_to;
        $this->hire_date_from = $hire_date_from;
        $this->teams = json_decode($teams,0);
        $this->positions = json_decode($positions,0);
        $this->attr = json_decode($attr,0);
    }
    public function render(): View
    {
        $data = Employee::when($this->hire_date_from!= 'all', function ($query) {
            return $query->whereDate('hire_date', '>=', Carbon::parse($this->hire_date_from));
        })->when($this->hire_date_to!= 'all', function ($query) {
            return $query->whereDate('hire_date', '<=', Carbon::parse($this->hire_date_to));
        })->when($this->positions != [],function ($query){
            return $query->whereHas('positions', function ($q) {
                $q->whereIn('position_id', $this->positions);
            })->when($this->teams != [],function ($query){
                $query->whereIn('team_id', $this->teams);
            });
        })->get();
        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with('data', $data);
    }
}
