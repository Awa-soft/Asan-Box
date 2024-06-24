<x-filament-panels::page>

<div class="grid grid-cols-5 gap-6">
@Package('Inventory')
<div class="col-span-full">
    <p class="my-3 text-lg font-bold ">{{ trans('lang.core_reports') }}</p>
</div>
<x-filament::section>
    <x-slot name="heading">
        {{ trans('lang.safe_locker') }}
    </x-slot>

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
    @endPackage
</div>
</x-filament-panels::page>
