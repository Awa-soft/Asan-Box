<x-filament-panels::page>

<div class="grid grid-cols-4">
    <livewire:core.package-overview
    name="First Package"
    version="2.1"
    description="The first package description for the application "
    active_date="{{ now()->format('Y-m-d') }}"
    type="Primary"
    status="false"
    color="#088395"
    price="200"
     />
</div>
    <div class="grid grid-cols-2 ctn fi-section">
        <x-filament::section>
            <form wire:submit='uploadPackage'>
                {{ $this->packageForm }}

                <x-filament::button type="submit" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </form>
        </x-filament::section>

    </div>
</x-filament-panels::page>
