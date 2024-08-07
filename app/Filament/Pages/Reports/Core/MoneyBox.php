<?php

namespace App\Filament\Pages\Reports\Core;

use App\Models\Logistic\Branch;
use App\Models\Settings\Currency;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class MoneyBox extends Page implements HasForms
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    use WithPagination;
    use InteractsWithForms;
    public $formData;


    public function getTitle(): string|Htmlable
    {
        return trans('lang.safe_locker');
    }
    public static function getNavigationLabel(): string
    {
        return trans('lang.safe_locker');
    }

    protected function queryString():array
    {
        return [
          'formData'
        ];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
         Section::make(' ')
                ->hiddenLabel()
                ->schema([
                    Select::make('branches')
                        ->options(Branch::all()->pluck('name','id'))
                        ->searchable()
                        ->hidden(auth()->user()->ownerable_type != null)
                        ->disabled(auth()->user()->ownerable_type != null)
                        ->preload()
                        ->multiple()
                        ->live()
                        ->label(trans('lang.branches')),
                    Select::make('currencies')
                        ->options(Currency::all()->pluck('name','id'))
                        ->searchable()
                        ->multiple()
                        ->live()
                        ->label(trans('Settings/lang.currency.plural_label')),
                    DatePicker::make('from')
                        ->label(trans('lang.from'))
                        ->live()
                        ->default(now()->startOfYear()),
                    DatePicker::make('to')
                        ->label(trans('lang.to'))
                        ->default(now()->endOfDay())
                        ->live()
                        ->maxDate(now()->endOfDay()),
                ])->columns(auth()->user()->ownerable_type != null? 3 :4)
        ])->statePath('formData');
    }

    public function mount()
    {
        $this->form->fill($this->formData);
    }

    public function render(): View
    {
        if(auth()->user()->ownerable_type != null){
            if(auth()->user()->ownerable_type == 'App\Models\Logistic\Branch'){
                $this->formData['branches'] = [auth()->user()->ownerable_id];
            }else{
                $this->formData['branches'] = [auth()->user()->ownerable->financial_branch_id];
            }
        }
        $data = [];
        $data['records'] = \App\Models\Core\MoneyBox::orderBy('date','desc')
            ->when(!empty($this->formData['currencies']),function ($query){
                $query->whereIn('currency_id', $this->formData['currencies']);
            })
            ->when(!empty($this->formData['branches']),function ($query){
                $query->whereIn('ownerable_id', $this->formData['branches']);
            })
            ->when($this->formData['from'] != null,function ($query){
                $query->where('date', '>=', $this->formData['from']);
            })->when($this->formData['to'] != null,function ($query){
                $query->where('date', '<=', $this->formData['to']);
            })->paginate(10);
        $data['branches'] = [];
        foreach (Branch::when(!empty($this->formData['branches']),function ($query){
            $query->whereIn('id', $this->formData['branches']);
        })->get() as $branch){
            $data['branches'][$branch->name] = [];
            $branchData = \App\Models\Core\MoneyBox::where('ownerable_id',$branch->id);
            foreach (Currency::when(!empty($this->formData['currencies']),function ($query){
                $query->whereIn('id', $this->formData['currencies']);
            })->get() as $currency){
                $send = $branchData->where('type','send')->where('currency_id',$currency->id)->sum('amount');
                $receive =  $branchData->where('type','receive')->where('currency_id',$currency->id)->sum('amount');
                    $data['branches'][$branch->name][] = [
                        'name'=>$currency->name,
                        'symbol'=>$currency->symbol,
                        'send'=>$send,
                        'receive'=>$receive,
                        'balance'=>$receive-$send,
                        'decimal'=>$currency->decimal
                    ];
            }
        }

        return view('filament.pages.reports.core.money-box', compact('data'))
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ]);
    }

}
