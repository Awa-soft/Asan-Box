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

class Profit extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public $formData;


    public function getTitle(): string|Htmlable
    {
        return trans('lang.profit');
    }
    public static function getNavigationLabel(): string
    {
        return trans('lang.profit');
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
                    DatePicker::make('from')
                        ->label(trans('lang.from'))
                        ->live()
                        ->default(now()->startOfYear()),
                    DatePicker::make('to')
                        ->label(trans('lang.to'))
                        ->default(now()->endOfDay())
                        ->live()
                        ->maxDate(now()->endOfDay()),
                ])->columns(auth()->user()->ownerable_type != null? 2 :3)
        ])->statePath('formData');
    }

    public function mount():void
    {
        $this->form->fill($this->formData);
    }

    public function render(): View
    {
        if (auth()->user()->ownerable_type != null) {
            if (auth()->user()->ownerable_type == 'App\Models\Logistic\Branch') {
                $this->formData['branches'] = [auth()->user()->ownerable_id];
            } else {
                $this->formData['branches'] = [auth()->user()->ownerable->financial_branch_id];
            }
        }
        $data = [];


        return view('filament.pages.core.profit', compact('data'))
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ]);
    }

}
