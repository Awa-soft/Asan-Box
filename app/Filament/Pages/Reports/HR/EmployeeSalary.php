<?php

namespace App\Filament\Pages\Reports\HR;

use App\Models\HR\Employee;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class EmployeeSalary extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports.h-r.employee-salary';

    protected static ?string $title = '';

    protected static ?string $slug = 'reports/hr/employees-summary/{employee_id}/{from}/{to}//{attr}';
    protected static bool $shouldRegisterNavigation = false;

    public  $attr = [],$to = 'all', $from = 'all',$employee_id = 'all';

    public function mount($attr,$from,$to,$employee_id){
        $this->from = $from;
        $this->to = $to;
        $this->employee_id = $employee_id;
        $this->attr = json_decode($attr,0);
    }
    public function render(): View
    {
        $data = \App\Models\HR\EmployeeSalary::when($this->employee_id!= 'all', function ($query) {
            return $query->where('employee_id', $this->employee_id);
        })->when($this->from!= 'all', function ($query) {
            return $query->whereDate('salary_date', '>=', Carbon::parse($this->from));
        })->when($this->to!= 'all', function ($query) {
            return $query->whereDate('salary_date', '<=', Carbon::parse($this->to));
        })->get();
        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with('data', $data);
    }
}
