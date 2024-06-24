<?php

namespace App\Filament\Pages\Core;


use App\Traits\Core\TranslatableForm;
use Filament\Forms\Components\DatePicker;

use App\Filament\Pages\Reports\HR\EmployeeActivityReport;
use App\Filament\Pages\Reports\HR\EmployeeLeaveReport;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class ReportPage extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    use TranslatableForm;
    public ?array $SafeData = [];
    public $hrEmployeeActivity,$hrEmployeeLeave;
    protected function getForms(): array
    {
        return [
            'hrEmployeeActivityForm',
            'hrEmployeeLeaveForm',
        ];
    }
//    Employee Activity
    public function searchEmployeeActivity(){
        if(checkPackage('HR')){
            $data = $this->hrEmployeeActivityForm->getState();
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $type =json_encode( $data['type']??[]);
            $employee_id = $data['employee_id']?? 'all';
            $attr = json_encode($data['attr']??[]);
            return $this->redirect(EmployeeActivityReport::getUrl(['from' => $from, 'to' => $to, 'employee_id' =>$employee_id, 'attr' => $attr, 'types' => $type]));
        }else{
            return null;
        }
    }
    public function hrEmployeeActivityForm(Form $form): Form
    {
        if(checkPackage('HR')){
            return $form
                ->model(\App\Models\HR\EmployeeActivity::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                    Select::make('type')
                        ->label(trans('lang.type'))
                        ->native(0)
                        ->options(\App\Models\HR\EmployeeActivity::getTypes())
                        ->multiple(),
                    Select::make('employee_id')
                    ->label(trans('lang.employee'))
                    ->relationship('employee', 'name')
                    ->searchable()
                    ->preload(),
                    Select::make('attr')
                        ->label(trans('lang.attributes'))
                    ->options([
                        'invoice_number' => trans('lang.invoice_number'),
                        'owner' => trans('lang.owner'),
                        'user'=>trans('user'),
                        'employee.name'=>trans('lang.employee'),
                        'type'=>trans('lang.type'),
                        'amount'=>trans('lang.amount'),
                        'currency_rate'=>trans('lang.currency_rate'),
                        'date'=>trans('lang.date'),
                        'note'=>trans('lang.note'),
                    ])->native(0)
                    ->multiple()
                ])->statePath('hrEmployeeActivity');
        }else{
            return $form->statePath('hrEmployeeActivity');
        }



    }

//  Employee Leave
    public function searchEmployeeLeave(){
        if(checkPackage('HR')){
            $data = $this->hrEmployeeLeaveForm->getState();
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $status =json_encode( $data['status']??[]);
            $employee_id = $data['employee_id']?? 'all';
            $attr = json_encode($data['attr']??[]);
            return $this->redirect(EmployeeLeaveReport::getUrl(['from' => $from, 'to' => $to, 'employee_id' =>$employee_id, 'attr' => $attr, 'status' => $status]));
        }else{
            return null;
        }
    }
    public function hrEmployeeLeaveForm(Form $form): Form
    {
        if(checkPackage('HR')){
            return $form
                ->model(\App\Models\HR\EmployeeLeave::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                    Select::make('status')
                        ->label(trans('lang.status'))
                        ->native(0)
                        ->options(\App\Models\HR\EmployeeLeave::getStatus())
                        ->multiple(),
                    Select::make('employee_id')
                        ->label(trans('lang.employee'))
                        ->relationship('employee', 'name')
                        ->searchable()
                        ->preload(),
                    Select::make('attr')
                        ->label(trans('lang.attributes'))
                        ->options([
                            'owner' => trans('lang.owner'),
                            'user'=>trans('user'),
                            'employee.name'=>trans('lang.employee'),
                            'status'=>trans('lang.status'),
                            'from'=>trans('lang.from'),
                            'to'=>trans('lang.to'),
                            'date'=>trans('lang.date'),
                            'note'=>trans('lang.note'),
                        ])->native(0)
                        ->multiple()
                ])->statePath('hrEmployeeLeave');
        }else{
            return $form->statePath('hrEmployeeLeave');
        }



    }
    public function mount(){

        $this->hrEmployeeActivityForm->fill();
        $this->hrEmployeeLeaveForm->fill();

        }

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
