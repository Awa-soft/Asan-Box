<x-filament-panels::page>
    <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-5">
        @Package('Inventory')
            <div class="col-span-full">
                <p class="my-3 text-lg font-bold ">{{ trans('lang.core_reports') }}</p>
            </div>
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
        @endPackage
    @Package('HR')
    <div class="col-span-full">
        <p class="my-3 text-lg font-bold ">{{ trans('HR/lang.reports.label') }}</p>
    </div>
    <x-filament::section>
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


        <div class="flex flex-col gap-4">
            <x-filament::section>
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
</x-filament-panels::page>
