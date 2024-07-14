<div>
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
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\Logistic\WarehouseResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('Logistic/lang.reports.warehouse') }}
            </x-slot>
            {{$this->logisticWarehouse}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchLogisticWarehouse()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\Logistic\ItemTransactionCodeResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('Logistic/lang.reports.itemTransactions') }}
            </x-slot>
            {{$this->logisticItemTransactions}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchLogisticItemTransactions()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
    </div></div>
