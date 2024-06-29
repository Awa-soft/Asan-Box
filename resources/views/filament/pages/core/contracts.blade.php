<div>
    <div class="mt-6">
        <x-filament::tabs class="w-fit mx-auto">
            <x-filament::tabs.item
                icon="heroicon-o-document-text"
                :active="$activeTab === 'installment_contract'"
                wire:click="changeTab('installment_contract')"
            >
                {{trans('lang.installment_contract') }}
            </x-filament::tabs.item>
            <x-filament::tabs.item
                icon="heroicon-o-document-text"
                :active="$activeTab === 'pledge'"
                wire:click="changeTab('pledge')"
            >
                {{trans('lang.pledge') }}
            </x-filament::tabs.item>
            <x-filament::tabs.item
                icon="heroicon-o-document-text"
                :active="$activeTab === 'bill_of_exchange'"
                wire:click="changeTab('bill_of_exchange')"
            >
                {{trans('lang.bill_of_exchange') }}
            </x-filament::tabs.item>
        </x-filament::tabs>

    </div>
    <x-filament-panels::page>

        {{$this->form}}
    </x-filament-panels::page>

</div>
