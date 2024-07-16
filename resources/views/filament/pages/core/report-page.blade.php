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
        @Package('Inventory')
        <x-filament::tabs.item
            :active="$activeTab === 'Inventory'"
            wire:click="$set('activeTab', 'Inventory')">
            {{ trans('Inventory/lang.group_label') }}
        </x-filament::tabs.item>
        @endPackage
    </x-filament::tabs>
       @switch($activeTab)
           @case('Inventory')
            @Package('Inventory')
                <livewire:reports.inventory/>
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
            <livewire:reports.p-o-s/>
            @endPackage
            @break
           @break
       @endswitch

    </x-filament-panels::page>

