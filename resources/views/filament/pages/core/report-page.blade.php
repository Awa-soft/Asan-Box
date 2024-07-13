<x-filament-panels::page>
    <style>
        .report-page  .fi-section{
            display: flex !important;
            flex-flow: column !important;
            justify-content: normal !important;
            overflow: hidden;
        }
        .report-page .fi-section-content-ctn{
            display: flex !important;
            flex-flow: column !important;
            justify-content: space-between !important;
            height: -webkit-text-available !important;
        }

        .fi-section-header-icon{
            margin-left: 10px !important;
            margin-right: 10px !important;
        }
    </style>
    <x-filament::tabs label="Content tabs">
        @Package('Inventory')
        <x-filament::tabs.item
            :active="$activeTab === 'Inventory'"
            wire:click="$set('activeTab', 'Inventory')">
            {{ trans('lang.core_reports') }}
        </x-filament::tabs.item>
        @endPackage
        @Package('HR')
        <x-filament::tabs.item
            :active="$activeTab === 'HR'"
            wire:click="$set('activeTab', 'HR')">
            {{ trans('HR/lang.reports.label') }}
        </x-filament::tabs.item>
        @endPackage
        @Package('Logistic')
        <x-filament::tabs.item
            :active="$activeTab === 'Logistic'"
            wire:click="$set('activeTab', 'Logistic')">
            {{ trans('Logistic/lang.reports.label') }}
        </x-filament::tabs.item>
        @endPackage
        @Package('POS')
        <x-filament::tabs.item
            :active="$activeTab === 'POS'"
            wire:click="$set('activeTab', 'POS')">
            {{ trans('POS/lang.group_label') }}
        </x-filament::tabs.item>
        @endPackage
    </x-filament::tabs>
       @switch($activeTab)
           @case('Inventory')
            @Package('Inventory')
            <div class="grid items-start grid-cols-1 gap-4 xl:grid-cols-4">
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
            </div>
            @endPackage
           @break
           @case('HR')
            @Package('HR')
                 <livewire:reports.h-r-reports/>
            @endPackage
            @break
           @case('Logistic')
            @Package('Logistic')
                <livewire:reports.logistic/>
            @endPackage
            @break
        @case('POS')
            @Package('POS')
            <div class="grid items-start grid-cols-1 gap-4 xl:grid-cols-4">

            </div>
            @endPackage
            @break
           @break
       @endswitch
    </x-filament-panels::page>

