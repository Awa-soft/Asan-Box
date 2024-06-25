<?php

namespace App\Filament\Pages\Reports\HR;

use App\Models\HR\Employee;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class EmployeeSummary extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports.h-r.employee-summary';

    use WithPagination;
    protected static ?string $slug = 'reports/hr/employees/{from}/{to}//{attr}';
    protected static bool $shouldRegisterNavigation = false;

    public  $attr = [],$to = 'all', $from = 'all';

    public function mount($attr,$from,$to){
        $this->from = $from;
        $this->to = $to;
        $this->attr = json_decode($attr,0);
    }
    public function render(): View
    {
        $data = Employee::with([
            'salaries'=>function($query) {
                return $query->when($this->from!= 'all', function ($query) {
                    return $query->whereDate('date', '>=', Carbon::parse($this->from));
                })->when($this->to!= 'all', function ($query) {
                    return $query->whereDate('date', '<=', Carbon::parse($this->to));
                });
            },
            'activities'=>function($query) {
                return $query->when($this->from!= 'all', function ($query) {
                    return $query->whereDate('date', '>=', Carbon::parse($this->from));
                })->when($this->to!= 'all', function ($query) {
                    return $query->whereDate('date', '<=', Carbon::parse($this->to));
                });
            },
            'leaves'=>function($query) {
                return $query->when($this->from!= 'all', function ($query) {
                    return $query->whereDate('date', '>=', Carbon::parse($this->from));
                })->when($this->to!= 'all', function ($query) {
                    return $query->whereDate('date', '<=', Carbon::parse($this->to));
                });
            }
        ])->get();;

        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with('data', $data);
    }
}
