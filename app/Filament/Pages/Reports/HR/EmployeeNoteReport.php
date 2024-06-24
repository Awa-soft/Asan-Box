<?php

namespace App\Filament\Pages\Reports\HR;

use App\Models\HR\EmployeeActivity;
use App\Models\HR\EmployeeNote;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class EmployeeNoteReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports.h-r.employee-note-report';
    use WithPagination;
    protected static ?string $slug = 'reports/hr/employee-notes/{from}/{to}/{employee_id}/{attr}';
    protected static bool $shouldRegisterNavigation = false;

    public  $from,$to,$employee_id,$attr = [];

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
