<?php

namespace App\Filament\Pages\Core;

use App\Traits\Core\TranslatableForm;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class ReportPage extends Page implements HasForms
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    use TranslatableForm;
    public ?array $SafeData = [];

    public function mount()
    {
        $this->SafeForm->fill();
    }
    protected function getForms(): array
    {
        return [
            'SafeForm',
        ];
    }

    public function SafeForm(Form $form): Form
    {
        return $form->schema(
            [
                DatePicker::make('from'),
                DatePicker::make('to'),
            ]
        )
        ->statePath('SafeData');
    }

    public function navigateToReport($report)
    {
        switch ($report) {
            case 'safe':
                $this->redirect(route("filament.admin.pages.reports.core.safe.{from}.{to}", [$this->SafeData['from'] ?? 'all', $this->SafeData['to'] ?? 'all']), true);
                break;

            default:
                # code...
                break;
        }
    }
    protected static string $view = 'filament.pages.core.report-page';
}
