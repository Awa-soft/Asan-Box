<?php

namespace App\Filament\Resources\CRM\BourseResource\Pages;

use App\Filament\Resources\CRM\BourseResource;
use App\Models\CRM\Bourse;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class Statement extends Page
{
    protected static string $resource = BourseResource::class;

    public $record,$from,$to;

    public function getTitle(): string|Htmlable
    {
        return "";
    }
    public function mount($from, $to, $record){
        $this->from = $from;
        $this->to = $to;
        $this->record = $record;
    }
    public function render(): View
    {
        $bourse  = Bourse::where('id',$this->record)
            ->with('boursePayment',function ($q){
            return $q->when($this->from != 'all', function($query) {
                return $query->whereDate('date', '>=', $this->from);
            })->when($this->to != 'all', function($query){
                return $query->whereDate('date', '<=', $this->to);
            })->orderBy('date','desc');
        })->get()->first();
        if(!$bourse){
            abort(404);
        }
        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with(['bourse'=> $bourse]);
    }

        protected static string $view = 'filament.resources.c-r-m.bourse-resource.pages.statement';
}
