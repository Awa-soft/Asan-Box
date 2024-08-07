<?php

namespace App\Filament\Pages\Core;

use App\Filament\Pages\Reports\HR\EmployeeNoteReport;
use App\Filament\Pages\Reports\HR\EmployeeReport;
use App\Filament\Pages\Reports\HR\EmployeeSalary;
use App\Filament\Pages\Reports\HR\EmployeeSummary;
use App\Filament\Pages\Reports\HR\IdentityTypeReport;
use App\Filament\Pages\Reports\HR\PositionReport;
use App\Filament\Pages\Reports\HR\TeamReport;
use App\Filament\Pages\Reports\Logistic\Branch;
use App\Traits\Core\TranslatableForm;
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
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public $activeTab='Logistic';

    public ?array $SafeData = [];
    public $hrEmployeeActivity,$hrEmployeeLeave,$hrEmployeeNote,$hrIdentityType,$hrTeam,$hrPosition,$hrEmployee,$hrEmployeeSalary,$hrEmployeeSummary;
    public $logisticBranch;
    protected function getForms(): array
    {
        return [
            'hrEmployeeActivityForm',
            'hrEmployeeLeaveForm',
            'hrEmployeeNoteForm',
            'hrIdentityTypesForm',
            'hrTeamsForm',
            'hrPositionsForm',
            'hrEmployeesForm',
            'hrEmployeesSalaryForm',
            'hrEmployeesSummaryForm',
            'SafeForm',
            'logisticBranches'
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
            return $form->columns(2)->model(\App\Models\HR\EmployeeActivity::class)
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
                    ->options(\App\Models\HR\EmployeeActivity::getLabels())->native(0)
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
                        ->columnSpanFull()

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
            return $form->columns(2)->model(\App\Models\HR\EmployeeLeave::class)
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
                        ->options(EmployeeLeave::getLabels())->native(0)
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
                        ->columnSpanFull()
                        ->multiple()
                ])->statePath('hrEmployeeLeave');
        }else{
            return $form->statePath('hrEmployeeLeave');
        }



    }

//  Employee Leave
    public function searchEmployeeNote(){
        if(checkPackage('HR')){
            $data = $this->hrEmployeeNoteForm->getState();
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $employee_id = $data['employee_id']?? 'all';
            $attr = json_encode($data['attr']??[]);
            return $this->redirect(EmployeeNoteReport::getUrl(['from' => $from, 'to' => $to, 'employee_id' =>$employee_id, 'attr' => $attr]));
        }else{
            return null;
        }
    }
    public function hrEmployeeNoteForm(Form $form): Form
    {
        if(checkPackage('HR')){
            return $form->columns(2)->model(\App\Models\HR\EmployeeNote::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                    Select::make('employee_id')
                        ->label(trans('lang.employee'))
                        ->relationship('employee', 'name')
                        ->columnSpanFull()
                        ->searchable()
                        ->preload(),
                    Select::make('attr')
                        ->label(trans('lang.attributes'))
                        ->options(EmployeeNote::getLabels())->native(0)
                        ->options([
                            'owner' => trans('lang.owner'),
                            'user'=>trans('user'),
                            'employee.name'=>trans('lang.employee'),
                            'date'=>trans('lang.date'),
                            'note'=>trans('lang.note'),
                        ])->native(0)
                        ->columnSpanFull()
                        ->multiple()
                ])->statePath('hrEmployeeNote');
        }else{
            return $form->statePath('hrEmployeeNote');
        }
    }

    //  Identity Types
    public function searchIdentityTypes(){
        if(checkPackage('HR')){
            $data = $this->hrIdentityTypesForm->getState();
            $attr = json_encode($data['attr']??[]);
            return $this->redirect(IdentityTypeReport::getUrl(['attr' => $attr]));
        }else{
            return null;
        }
    }
    public function hrIdentityTypesForm(Form $form): Form
    {
        if(checkPackage('HR')){
            return $form->model(\App\Models\HR\IdentityType::class)
                ->schema([

                    Select::make('attr')
                        ->label(trans('lang.attributes'))
                        ->options(IdentityType::getLabels())->native(0)
                        ->multiple()
                ])->statePath('hrIdentityType');
        }else{
            return $form->statePath('hrIdentityType');
        }
    }

    //  Positions
    public function searchPositions(){
        if(checkPackage('HR')){
            $data = $this->hrPositionsForm->getState();
            $attr = json_encode($data['attr']??[]);
            return $this->redirect(PositionReport::getUrl(['attr' => $attr]));
        }else{
            return null;
        }
    }
    public function hrPositionsForm(Form $form): Form
    {
        if(checkPackage('HR')){
            return $form->model(\App\Models\HR\Position::class)
                ->schema([

                    Select::make('attr')
                        ->label(trans('lang.attributes'))
                        ->options([
                            'owner' => trans('lang.owner'),
                            'user'=>trans('user'),
                            'name'=>trans('lang.name'),
                            'employees'=>trans('lang.employees'),
                        ])->native(0)
                        ->multiple()
                ])->statePath('hrPosition');
        }else{
            return $form->statePath('hrPosition');
        }
    }

//  Positions
    public function searchTeams(){
        if(checkPackage('HR')){
            $data = $this->hrTeamsForm->getState();
            $attr = json_encode($data['attr']??[]);
            return $this->redirect(TeamReport::getUrl(['attr' => $attr]));
        }else{
            return null;
        }
    }
    public function hrTeamsForm(Form $form): Form
    {
        if(checkPackage('HR')){
            return $form->model(\App\Models\HR\Team::class)
                ->schema([
                    Select::make('attr')
                        ->label(trans('lang.attributes'))
                        ->options([
                            'owner' => trans('lang.owner'),
                            'user'=>trans('user'),
                            'name'=>trans('lang.name'),
                            'leader'=>trans('lang.leader'),
                            'members'=>trans('lang.members'),
                        ])->native(0)
                        ->multiple()
                ])->statePath('hrTeam');
        }else{
            return $form->statePath('hrTeam');
        }
    }
    //  Employees
    public function searchEmployees(){
        if(checkPackage('HR')){
            $data = $this->hrEmployeesForm->getState();
            $hireDateFrom = $data['hire_date_from']?? 'all';
            $hireDateTo = $data['hire_date_to']?? 'all';
            $attr = json_encode($data['attr']??[]);
            $positions = json_encode($data['positions']??[]);
            $teams = json_encode($data['team_id']??[]);
            return $this->redirect(EmployeeReport::getUrl(['positions'=>$positions,'teams'=>$teams,'hire_date_to'=>$hireDateTo,'hire_date_from'=>$hireDateFrom,'attr' => $attr]));
        }else{
            return null;
        }
    }
    public function hrEmployeesForm(Form $form): Form
    {
        if(checkPackage('HR')){
            return $form->columns(2)->model(\App\Models\HR\Employee::class)
                ->schema([
                    DatePicker::make('hire_date_from')
                        ->label(trans('lang.hire_date') . ' - ' . trans('lang.from')),
                    DatePicker::make('hire_date_to')
                        ->label(trans('lang.hire_date') . ' - ' . trans('lang.to')),
                    Select::make('team_id')
                        ->multiple()
                        ->preload()
                        ->relationship('team', 'name'),
                    Select::make('positions')
                        ->multiple()
                        ->preload()
                        ->relationship('positions', 'name'),
                    Select::make('attr')
                        ->label(trans('lang.attributes'))
                        ->required()
                        ->maxItems(5)
                        ->options([
                            'owner' => trans('lang.owner'),
                            'user'=>trans('user'),
                            'name'=>trans('lang.name'),
                            'phone'=>trans('lang.phone'),
                            'nationality'=>trans('lang.nationality') . ' - ' . trans('lang.address'),
                            'gender'=>trans('lang.gender'),
                            'identity_number'=>trans('lang.identity_number'),
                            'hire_date'=>trans('lang.hire_date') . ' - ' . trans('lang.termination_date'),
                            'start_time'=>trans('lang.start_time') . ' - ' . trans('lang.end_time'),
                            'salary'=>trans('lang.salary'),
                            'absence_amount'=>trans('lang.absence_amount'),
                            'overtime_amount'=>trans('lang.overtime_amount'),
                            'annual_leave'=>trans('lang.annual_leave'),
                            'team_id'=>trans('lang.team'),
                            'positions'=>trans('lang.positions'),
                            'note'=>trans('lang.note')
                        ])->native(0)
                        ->columnSpanFull()
                        ->multiple()
                ])->statePath('hrEmployee');
        }else{
            return $form->statePath('hrEmployee');
        }
    }

    //  Employees
    public function searchEmployeesSummary(){
        if(checkPackage('HR')){
            $data = $this->hrEmployeesSummaryForm->getState();
            $attr = json_encode($data['attr']??[]);
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            return $this->redirect(EmployeeSummary::getUrl(['from'=>$from,'to'=>$to,'attr' => $attr]));
        }else{
            return null;
        }
    }
    public function hrEmployeesSummaryForm(Form $form): Form
    {
        if(checkPackage('HR')){
            return $form->columns(2)->model(\App\Models\HR\Employee::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                    Select::make('attr')
                        ->label(trans('lang.attributes'))
                        ->options([
                            'owner' => trans('lang.owner'),
                            'name'=>trans('lang.name'),
                            'punish'=>trans('lang.punish'),
                            'bonus'=>trans('lang.bonus'),
                            'overtime'=>trans('lang.overtime'),
                            'advance'=>trans('lang.advance'),
                            'salary'=>trans('lang.salary'),
                            'leave'=>trans('lang.leaves'),
                            'absence'=>trans('lang.absence'),
                        ])->native(0)
                        ->columnSpanFull()
                        ->multiple()
                ])->statePath('hrEmployeeSummary');
        }else{
            return $form->statePath('hrEmployeeSummary');
        }
    }

//    Employee Salary
    public function searchEmployeesSalary(){
        if(checkPackage('HR')){
            $data = $this->hrEmployeesSalaryForm->getState();
            $attr = json_encode($data['attr']??[]);
            $from = $data['from']?? 'all';
            $to = $data['to']?? 'all';
            $emplotyeeId = $data['employee_id']?? 'all';
            return $this->redirect(EmployeeSalary::getUrl(['employee_id'=>$emplotyeeId,'from'=>$from,'to'=>$to,'attr' => $attr]));
        }else{
            return null;
        }
    }
    public function hrEmployeesSalaryForm(Form $form): Form
    {
        if(checkPackage('HR')){
            return $form->columns(2)->model(\App\Models\HR\EmployeeSalary::class)
                ->schema([
                    DatePicker::make('from')
                        ->label(trans('lang.from')),
                    DatePicker::make('to')
                        ->label(trans('lang.to')),
                    Select::make('employee_id')
                        ->label(trans('lang.employee'))
                        ->searchable()
                        ->preload()
                    ->relationship('employee', 'name'),
                    Select::make('attr')
                        ->label(trans('lang.attributes'))
                        ->required()
                        ->maxItems(6)
                        ->options([
                            'owner' => trans('lang.owner'),
                            'user'=>trans('lang.user'),
                            'employee'=>trans('lang.employee'),
                            'last_salary'=>trans('lang.last_salary'),
                            'salary_date'=>trans('lang.salary_date'),
                            'payment_date'=>trans('lang.payment_date'),
                            'work_average'=>trans('lang.work_average'),
                            'punish'=>trans('lang.punish'),
                            'bonus'=>trans('lang.bonus'),
                            'overtime'=>trans('lang.overtime'),
                            'advance'=>trans('lang.advance'),
                            'amount'=>trans('lang.amount'),
                            'payment_amount'=>trans('lang.payment_amount'),
                        ])->native(0)
                        ->multiple()
                ])->statePath('hrEmployeeSalary');
        }else{
            return $form->statePath('hrEmployeeSalary');
        }
    }


//    Logistics
    public function logisticBranches(Form $form):Form{
        return $form->schema([
                Select::make('branches')
                    ->multiple()
                    ->label(trans('lang.branches'))
                    ->options(\App\Models\Logistic\Branch::all()->pluck('name','id')),
                Select::make('attr')
                    ->label(trans('lang.attributes'))
                    ->required()
                    ->native(0)
                    ->multiple()
                ->options([
                    'details'=>trans('lang.details'),
                    'warehouses'=>trans('lang.warehouses'),
                    'items'=>trans('Inventory/lang.item.plural_label'),
                ])
            ->live()
        ])->statePath('logisticBranch');
    }
    public function searchLogisticBranch()
    {
      $data =  $this->logisticBranches->getState();
        $attr = json_encode($data['attr']??[]);
        $branches = json_encode($data['branches']??[]);
        return $this->redirect(Branch::getUrl(['attr' => $attr,'branches'=>$branches]));
    }
    public function mount(){

        $this->hrEmployeeActivityForm->fill();
        $this->hrEmployeeLeaveForm->fill();
        $this->hrEmployeeNoteForm->fill();
        $this->hrIdentityTypesForm->fill();
        $this->hrTeamsForm->fill();
        $this->hrPositionsForm->fill();
        $this->hrEmployeesForm->fill();
        $this->hrEmployeesSalaryForm->fill();
        $this->hrEmployeesSummaryForm->fill();
        $this->SafeForm->fill();
        $this->logisticBranches->fill();


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
