<x-filament-panels::page>
    <style>
        .report-page  .fi-section{
            display: flex !important;
            flex-flow: column !important;
            justify-content: normal !important;
            overflow: hidden;
        }
        .report-page .fi-section-content-ctn{
            display: flex !important;
            flex-flow: column !important;
            justify-content: space-between !important;
            height: -webkit-text-available !important;
        }

        .fi-section-header-icon{
            margin-left: 10px !important;
            margin-right: 10px !important;
        }
    </style>
    <x-filament::tabs label="Content tabs">
        @Package('Inventory')
        <x-filament::tabs.item
            :active="$activeTab === 'Inventory'"
            wire:click="$set('activeTab', 'Inventory')">
            {{ trans('lang.core_reports') }}
        </x-filament::tabs.item>
        @endPackage
        @Package('HR')
        <x-filament::tabs.item
            :active="$activeTab === 'HR'"
            wire:click="$set('activeTab', 'HR')">
            {{ trans('HR/lang.reports.label') }}
        </x-filament::tabs.item>
        @endPackage
        @Package('Logistic')
        <x-filament::tabs.item
            :active="$activeTab === 'Logistic'"
            wire:click="$set('activeTab', 'Logistic')">
            {{ trans('Logistic/lang.reports.label') }}
        </x-filament::tabs.item>
        @endPackage
    </x-filament::tabs>
       @switch($activeTab)
           @case('Inventory')
            @Package('Inventory')
            <x-slot name="heading">
                {{ trans('lang.core_reports') }}
            </x-slot>
            <div class="grid items-start grid-cols-1 gap-4 xl:grid-cols-4">
                <x-filament::section>
                    <x-slot name="heading">
                        {{ trans('lang.safe_locker') }}
                    </x-slot>

                    <form wire:submit='navigateToReport("safe")'>
                        {{ $this->SafeForm }}

                        <x-filament::button type='submit' class="my-2">
                            {{ trans('filament-actions::modal.actions.submit.label') }}
                        </x-filament::button>
                    </form>
                </x-filament::section>
            </div>
            @endPackage
           @break
           @case('HR')
            @Package('HR')
            <x-slot name="heading">
                {{ trans('HR/lang.reports.label') }}
            </x-slot>
            <div class="grid items-start grid-cols-1 gap-4 xl:grid-cols-4">
                <x-filament::section>
                    <x-slot name="icon">
                        @svg(\App\Filament\Resources\HR\EmployeeActivityResource::getNavigationIcon(),'w-8 text-primary-500' )
                    </x-slot>
                    <x-slot name="heading">
                        {{ trans('HR/lang.reports.activity') }}
                    </x-slot>
                    {{$this->hrEmployeeActivityForm}}
                    <x-slot name="footerActions">
                        <x-filament::button type="submit" wire:click="searchEmployeeActivity()" class="mt-5">
                            {{ trans('filament-actions::modal.actions.submit.label') }}
                        </x-filament::button>
                    </x-slot>
                </x-filament::section>
                <x-filament::section>
                    <x-slot name="icon">
                        @svg(\App\Filament\Resources\HR\EmployeeLeaveResource::getNavigationIcon(),'w-8 text-primary-500' )
                    </x-slot>
                    <x-slot name="heading">
                        {{ trans('HR/lang.reports.leave') }}
                    </x-slot>
                    {{$this->hrEmployeeLeaveForm}}
                    <x-slot name="footerActions">
                        <x-filament::button type="submit" wire:click="searchEmployeeLeave()" class="mt-5">
                            {{ trans('filament-actions::modal.actions.submit.label') }}
                        </x-filament::button>
                    </x-slot>
                </x-filament::section>
                <x-filament::section>
                    <x-slot name="icon">
                        @svg(\App\Filament\Resources\HR\EmployeeNoteResource::getNavigationIcon(),'w-8 text-primary-500' )
                    </x-slot>
                    <x-slot name="heading">
                        {{ trans('HR/lang.reports.note') }}
                    </x-slot>
                    {{$this->hrEmployeeNoteForm}}
                    <x-slot name="footerActions">
                        <x-filament::button type="submit" wire:click="searchEmployeeNote()" class="mt-5">
                            {{ trans('filament-actions::modal.actions.submit.label') }}
                        </x-filament::button>
                    </x-slot>
                </x-filament::section>
                <x-filament::section>
                    <x-slot name="icon">
                        @svg(\App\Filament\Resources\HR\EmployeeResource::getNavigationIcon(),'w-8 text-primary-500' )
                    </x-slot>
                    <x-slot name="heading">
                        {{ trans('HR/lang.reports.employees') }}
                    </x-slot>
                    {{$this->hrEmployeesForm}}
                    <x-slot name="footerActions">
                        <x-filament::button type="submit" wire:click="searchEmployees()" class="mt-5">
                            {{ trans('filament-actions::modal.actions.submit.label') }}
                        </x-filament::button>
                    </x-slot>
                </x-filament::section>
                <div class="grid grid-col-1 xl:grid-cols-2 col-span-full gap-4">
                    <x-filament::section>
                        <x-slot name="icon">
                            @svg(\App\Filament\Resources\HR\EmployeeResource::getNavigationIcon(),'w-8 text-primary-500' )
                        </x-slot>
                        <x-slot name="heading">
                            {{ trans('HR/lang.reports.employees_summary') }}
                        </x-slot>
                        {{$this->hrEmployeesSummaryForm}}
                        <x-slot name="footerActions">
                            <x-filament::button type="submit" wire:click="searchEmployeesSummary()" class="mt-5">
                                {{ trans('filament-actions::modal.actions.submit.label') }}
                            </x-filament::button>
                        </x-slot>
                    </x-filament::section>
                    <x-filament::section>
                        <x-slot name="icon">
                            @svg(\App\Filament\Resources\HR\EmployeeSalaryResource::getNavigationIcon(),'w-8 text-primary-500' )
                        </x-slot>
                        <x-slot name="heading">
                            {{ trans('HR/lang.reports.employees_salary') }}
                        </x-slot>
                        {{$this->hrEmployeesSalaryForm}}
                        <x-slot name="footerActions">
                            <x-filament::button type="submit" wire:click="searchEmployeesSalary()" class="mt-5">
                                {{ trans('filament-actions::modal.actions.submit.label') }}
                            </x-filament::button>
                        </x-slot>
                    </x-filament::section>
                </div>
                <div class="grid grid-col-1 xl:grid-cols-3 col-span-full gap-4">
                    <x-filament::section>
                        <x-slot name="icon">
                            @svg(\App\Filament\Resources\HR\IdentityTypeResource::getNavigationIcon(),'w-8 text-primary-500' )
                        </x-slot>
                        <x-slot name="heading">
                            {{ trans('HR/lang.reports.identity_types') }}
                        </x-slot>
                        {{$this->hrIdentityTypesForm}}
                        <x-slot name="footerActions">
                            <x-filament::button type="submit" wire:click="searchIdentityTypes()" class="mt-5">
                                {{ trans('filament-actions::modal.actions.submit.label') }}
                            </x-filament::button>
                        </x-slot>
                    </x-filament::section>
                    <x-filament::section>
                        <x-slot name="icon">
                            @svg(\App\Filament\Resources\HR\PositionResource::getNavigationIcon(),'w-8 text-primary-500' )
                        </x-slot>
                        <x-slot name="heading">
                            {{ trans('HR/lang.reports.positions') }}
                        </x-slot>
                        {{$this->hrPositionsForm}}
                        <x-slot name="footerActions">
                            <x-filament::button type="submit" wire:click="searchPositions()" class="mt-5">
                                {{ trans('filament-actions::modal.actions.submit.label') }}
                            </x-filament::button>
                        </x-slot>
                    </x-filament::section>
                    <x-filament::section>
                        <x-slot name="icon">
                            @svg(\App\Filament\Resources\HR\TeamResource::getNavigationIcon(),'w-8 text-primary-500' )
                        </x-slot>
                        <x-slot name="heading">
                            {{ trans('HR/lang.reports.team') }}
                        </x-slot>
                        {{$this->hrTeamsForm}}
                        <x-slot name="footerActions">
                            <x-filament::button type="submit" wire:click="searchTeams()" class="mt-5">
                                {{ trans('filament-actions::modal.actions.submit.label') }}
                            </x-filament::button>
                        </x-slot>
                    </x-filament::section>
                </div>
                @endPackage
            </div>
           @break
           @case('Logistic')
            @Package('Logistic')
            <x-slot name="heading">
                {{ trans('Logistic/lang.reports.label') }}
            </x-slot>
            <div class="grid items-start grid-cols-1 gap-4 xl:grid-cols-4">
                <x-filament::section>
                    <x-slot name="icon">
                        @svg(\App\Filament\Resources\Logistic\BranchResource::getNavigationIcon(),'w-8 text-primary-500' )
                    </x-slot>
                    <x-slot name="heading">
                        {{ trans('Logistic/lang.reports.branch') }}
                    </x-slot>
                    {{$this->logisticBranches}}
                    <x-slot name="footerActions">
                        <x-filament::button type="submit" wire:click="searchLogisticBranch()" class="mt-5">
                            {{ trans('filament-actions::modal.actions.submit.label') }}
                        </x-filament::button>
                    </x-slot>
                </x-filament::section>
                @endPackage
            </div>
            @break
           @break
       @endswitch
    </x-filament-panels::page>

