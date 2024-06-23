<?php

namespace App\Filament\Resources\HR\EmployeeResource\Pages;

use App\Filament\Resources\HR\EmployeeResource;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeActivity;
use App\Models\HR\EmployeeSalary;
use App\Traits\Core\HasPrintCss;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class Statement extends Page
{
    protected static string $resource = EmployeeResource::class;

    protected static string $view = 'filament.resources.h-r.employee-resource.pages.statement';
    public function getTitle(): string|Htmlable
    {
        return trans('lang.statement',['name' => Employee::findOrFail($this->record)->name]);
    }

    public $record,$from,$to,$activity;
    public function mount($from, $to, $activity, $record){
        $this->from = $from;
        $this->to = $to;
        $this->activity = json_decode($activity);
        $this->record = $record;
    }
    public function render(): View
    {

        $employee = Employee::where('id',$this->record)
        ->with('activities',function ($q){
            return $q->when($this->from != 'all', function($query) {
                return $query->whereDate('date', '>=', $this->from);
            })->when($this->to != 'all', function($query){
                return $query->whereDate('date', '<=', $this->to);
            })->when($this->activity[0] != 'all', function($query){
                return $query->whereIn('type', $this->activity);
            });
        })->with('leaves',function ($q){
                return $q->when($this->from != 'all', function($query) {
                    return $query->whereDate('created_at', '>=', $this->from);
                })->when($this->to != 'all', function($query){
                    return $query->whereDate('created_at', '<=', $this->to);
                })->when(!in_array('leaves',$this->activity) && $this->activity[0] != 'all', function($query){
                    return $query->where('id',0);
                });
            })->with('notes',function ($q){
                return $q->when($this->from != 'all', function($query) {
                    return $query->whereDate('date', '>=', $this->from);
                })->when($this->to != 'all', function($query){
                    return $query->whereDate('date', '<=', $this->to);
                })->when(!in_array('notes',$this->activity)&& $this->activity[0] != 'all', function($query){
                    return $query->where('id',0);
                });
            })->with('salaries',function ($q){
                return $q->when($this->from != 'all', function($query) {
                    return $query->whereDate('salary_date', '>=', $this->from);
                })->when($this->to != 'all', function($query){
                    return $query->whereDate('salary_date', '<=', $this->to);
                })->when(!in_array('salary',$this->activity) && $this->activity[0] != 'all', function($query){
                    return $query->where('id',0);
                });
            })->get()->first();
        if(!$employee){
            abort(404);
        }

        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with('employee', $employee);
    }
}
