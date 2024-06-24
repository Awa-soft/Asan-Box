<?php

namespace App\Filament\Pages\Reports\HR;

use App\Models\HR\EmployeeActivity;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
class EmployeeActivityReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    use WithPagination;
    protected static string $view = 'filament.pages.reports.h-r.employee-activity-report';
    protected static ?string $slug = 'reports/hr/employee-activity/{from}/{to}/{employee_id}/{attr}/{types}';
    protected static bool $shouldRegisterNavigation = false;

    public  $from,$to,$employee_id,$attr = [],$types=[], $data;

    public function mount($from,$to,$employee_id,$attr,$types){
        $this->from = $from;
        $this->to = $to;
        $this->employee_id = $employee_id;
        $this->attr = json_decode($attr,0);
        $this->types = json_decode($types,0);
    }

    public function exportExcel(){


    }

    public function render(): View
    {
        $this->data = EmployeeActivity::when($this->from != 'all', function ($query) {
            return $query->whereDate('date', '>=', Carbon::parse($this->from));
        })->when($this->to!= 'all', function ($query) {
            return $query->whereDate('date', '<=', Carbon::parse($this->to));
        })->when($this->employee_id!= 'all', function ($query) {
            return $query->where('employee_id', $this->employee_id);
        })->when($this->types != [], function ($query) {
            return $query->whereIn('type', $this->types);
        })->get();
        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with('data', $this->data);
    }

}
