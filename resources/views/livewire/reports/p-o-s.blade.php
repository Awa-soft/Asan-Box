<div>
    <div class="grid items-start grid-cols-1 gap-4 xl:grid-cols-4">
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\POS\PurchaseInvoiceResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.purchase') }}
            </x-slot>
            {{$this->purchaseForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchPurchase()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\POS\SaleInvoiceResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.sale') }}
            </x-slot>
            {{$this->saleForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchSale()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
    </div>
    </div>
