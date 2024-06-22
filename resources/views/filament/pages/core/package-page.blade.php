<x-filament-panels::page>

<div class="grid gap-5 lg:grid-cols-2 xl:grid-cols-4 md:grid-cols-2">
    @foreach ($packages as $package)
    <livewire:core.package-overview
    name="{{ $package->name }}"
    version="{{ $package->version }}"
    description="{{ $package->description }}"
    active_date="{{ $package->created_at->format('Y-m-d') }}"
    type="{{ $package->type }}"
    status="{{ $package->status }}"
    color="{{ $package->color }}"
    price="{{ $package->price }}"
    image="{{ $package->image }}"
     />
    @endforeach

</div>
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-2 ctn fi-section text-primary-500">
        <x-filament::section>
            <form wire:submit='uploadPackage'>
                {{ $this->uploadPackageForm }}

                <x-filament::button type="submit" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </form>
        </x-filament::section>
        <x-filament::section>
           {{ $this->table }}
        </x-filament::section>

    </div>
</x-filament-panels::page>

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
