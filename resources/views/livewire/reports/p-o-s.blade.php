<div>
    <div class="grid items-start grid-cols-1 gap-6 xl:grid-cols-2">
{{--        purchase--}}

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
                @svg(\App\Filament\Resources\Inventory\ItemResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.purchase_items') }}
            </x-slot>
            {{$this->purchaseItemsForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchPurchaseItems()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\Logistic\ItemTransactionCodeResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.purchase_codes') }}
            </x-slot>
            {{$this->purchaseCodesForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchPurchaseCodes()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\POS\PurchaseExpenseResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.purchase_expenses') }}
            </x-slot>
            {{$this->purchaseExpensesForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchPurchaseExpenses()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>

{{--        Return PurchaseReturn--}}
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\POS\PurchaseInvoiceResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.purchase_return') }}
            </x-slot>
            {{$this->purchaseReturnForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchPurchaseReturn()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\Inventory\ItemResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.purchase_return_items') }}
            </x-slot>
            {{$this->purchaseReturnItemsForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchPurchaseReturnItems()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\Logistic\ItemTransactionCodeResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.purchase_return_codes') }}
            </x-slot>
            {{$this->purchaseReturnCodesForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchPurchaseReturnCodes()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\POS\PurchaseExpenseResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.purchase_return_expenses') }}
            </x-slot>
            {{$this->purchaseReturnExpensesForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchPurchaseReturnExpenses()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
{{--        Sale--}}
        <div class="col-span-full gap-6 grid grid-cols-1 xl:grid-cols-3">
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
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\Inventory\ItemResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.sale_items') }}
            </x-slot>
            {{$this->saleItemsForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchSaleItems()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\Logistic\ItemTransactionCodeResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.sale_codes') }}
            </x-slot>
            {{$this->saleCodesForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchSaleCodes()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
{{--        Sale Return --}}
            <x-filament::section>
                <x-slot name="icon">
                    @svg(\App\Filament\Resources\POS\SaleInvoiceResource::getNavigationIcon(),'w-8 text-primary-500' )
                </x-slot>
                <x-slot name="heading">
                    {{ trans('POS/lang.reports.sale_return') }}
                </x-slot>
                {{$this->saleReturnForm}}
                <x-slot name="footerActions">
                    <x-filament::button type="submit" wire:click="searchSaleReturn()" class="mt-5">
                        {{ trans('filament-actions::modal.actions.submit.label') }}
                    </x-filament::button>
                </x-slot>
            </x-filament::section>
            <x-filament::section>
                <x-slot name="icon">
                    @svg(\App\Filament\Resources\Inventory\ItemResource::getNavigationIcon(),'w-8 text-primary-500' )
                </x-slot>
                <x-slot name="heading">
                    {{ trans('POS/lang.reports.sale_return_items') }}
                </x-slot>
                {{$this->saleReturnItemsForm}}
                <x-slot name="footerActions">
                    <x-filament::button type="submit" wire:click="searchSaleReturnItems()" class="mt-5">
                        {{ trans('filament-actions::modal.actions.submit.label') }}
                    </x-filament::button>
                </x-slot>
            </x-filament::section>
            <x-filament::section>
                <x-slot name="icon">
                    @svg(\App\Filament\Resources\Logistic\ItemTransactionCodeResource::getNavigationIcon(),'w-8 text-primary-500' )
                </x-slot>
                <x-slot name="heading">
                    {{ trans('POS/lang.reports.sale_return_codes') }}
                </x-slot>
                {{$this->saleReturnCodesForm}}
                <x-slot name="footerActions">
                    <x-filament::button type="submit" wire:click="searchSaleReturnCodes()" class="mt-5">
                        {{ trans('filament-actions::modal.actions.submit.label') }}
                    </x-filament::button>
                </x-slot>
            </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\POS\SaleInvoiceResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.sale_installment') }}
            </x-slot>
            {{$this->saleInstallmentForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchSaleInstallment()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\Inventory\ItemResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.sale_installment_items') }}
            </x-slot>
            {{$this->saleInstallmentItemsForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchSaleInstallmentItems()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="icon">
                @svg(\App\Filament\Resources\Logistic\ItemTransactionCodeResource::getNavigationIcon(),'w-8 text-primary-500' )
            </x-slot>
            <x-slot name="heading">
                {{ trans('POS/lang.reports.sale_installment_codes') }}
            </x-slot>
            {{$this->saleInstallmentCodesForm}}
            <x-slot name="footerActions">
                <x-filament::button type="submit" wire:click="searchSaleInstallmentCodes()" class="mt-5">
                    {{ trans('filament-actions::modal.actions.submit.label') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>


    </div>
        <div class="col-span-full">
            <x-filament::section>
                <x-slot name="icon">
                    @svg(\App\Filament\Resources\POS\ItemRepairResource::getNavigationIcon(),'w-8 text-primary-500' )
                </x-slot>
                <x-slot name="heading">
                    {{ trans('POS/lang.reports.itemRepairs') }}
                </x-slot>
                {{$this->itemRepairsForm}}
                <x-slot name="footerActions">
                    <x-filament::button type="submit" wire:click="searchItemRepairs()" class="mt-5">
                        {{ trans('filament-actions::modal.actions.submit.label') }}
                    </x-filament::button>
                </x-slot>
            </x-filament::section>
        </div>

    </div>
    </div>
