<x-filament-panels::page>

    <div class="grid grid-cols-5">
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
    </div>
</x-filament-panels::page>
