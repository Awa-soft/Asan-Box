<?php

namespace App\Filament\Pages\Core;

use App\Filament\Pages\Logistic\ItemTransaction;
use App\Filament\Pages\Reports\HR\EmployeeNoteReport;
use App\Filament\Pages\Reports\HR\EmployeeReport;
use App\Filament\Pages\Reports\HR\EmployeeSalary;
use App\Filament\Pages\Reports\HR\EmployeeSummary;
use App\Filament\Pages\Reports\HR\IdentityTypeReport;
use App\Filament\Pages\Reports\HR\PositionReport;
use App\Filament\Pages\Reports\HR\TeamReport;
use App\Filament\Pages\Reports\Logistic\Branch;
use App\Filament\Pages\Reports\Logistic\ItemTransactions;
use App\Filament\Pages\Reports\Logistic\WareHouse;
use App\Traits\Core\TranslatableForm;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\DatePicker;
use App\Filament\Pages\Reports\HR\EmployeeActivityReport;
use App\Filament\Pages\Reports\HR\EmployeeLeaveReport;
use App\Models\HR\EmployeeLeave;
use App\Models\HR\EmployeeNote;
use App\Models\HR\IdentityType;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class ReportPage extends Page implements HasForms
{
    use InteractsWithForms;
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public $activeTab;

    protected $queryString = ['activeTab'];


    protected static string $view = 'filament.pages.core.report-page';
}
