<div>
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

    {{-- Because she competes with no one, no one can compete with her. --}}
</div>
