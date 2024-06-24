<?php

namespace App\Filament\Pages\Reports\Core;

use App\Models\Settings\Currency;
use App\Traits\Core\TranslatableForm;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class SafeReport extends Page implements HasForms
{
    use TranslatableForm;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $slug = 'reports/core/safe/{from}/{to}';
    public ?array $SafeData =[];
    public $currencies;
    public function mount($from, $to){
        $this->SafeForm->fill([
            'from' => $from,
            'to' => $to,
        ]);

        $this->currencies = Currency::all();
    }
    protected function getForms(): array
    {
        return [
            'SafeForm',
        ];
    }

    public function SafeForm(Form $form) :Form{
        return $form->schema(
            [
                DatePicker::make('from'),
                DatePicker::make('to'),
            ]
        )
        ->columns(2)
        ->statePath('SafeData');
    }

    public function navigateToReport($report){
        switch ($report) {
            case 'safe':
                // route without refresh
                $this->redirect(route('filament.pages.reports.core.safe-report'));
                break;

            default:
                # code...
                break;
        }
    }
    protected static string $view = 'filament.pages.reports.core.safe-report';
}
