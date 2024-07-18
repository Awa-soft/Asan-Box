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
    @if($activeTab != '' || $activeTab != null)
        <x-filament::tabs label="Content tabs">
            @Package('HR')
            <x-filament::tabs.item
                icon="tabler-users-group"
                :active="$activeTab === 'HR'"
                wire:click="$set('activeTab', 'HR')">
                {{ trans('HR/lang.reports.label') }}
            </x-filament::tabs.item>
            @endPackage
            @Package('Logistic')
            <x-filament::tabs.item
                icon="tabler-building-warehouse"
                :active="$activeTab === 'Logistic'"
                wire:click="$set('activeTab', 'Logistic')">
                {{ trans('Logistic/lang.reports.label') }}
            </x-filament::tabs.item>
            @endPackage
            @Package('POS')
            <x-filament::tabs.item
                icon="iconpark-buy"
                :active="$activeTab === 'POS'"
                wire:click="$set('activeTab', 'POS')">
                {{ trans('POS/lang.group_label') }}
            </x-filament::tabs.item>
            @endPackage
            @Package('Inventory')
            <x-filament::tabs.item
                icon="tabler-brand-ubuntu"
                :active="$activeTab === 'Inventory'"
                wire:click="$set('activeTab', 'Inventory')">

                {{ trans('Inventory/lang.group_label') }}
            </x-filament::tabs.item>
            @endPackage
            @Package('CRM')
            <x-filament::tabs.item
                icon="tabler-components"
                :active="$activeTab === 'CRM'"
                wire:click="$set('activeTab', 'CRM')">
                {{ trans('CRM/lang.group_label') }}
            </x-filament::tabs.item>
            @endPackage
            @Package('Finance')
            <x-filament::tabs.item
                icon="tabler-report-money"
                :active="$activeTab === 'Finance'"
                wire:click="$set('activeTab', 'Finance')">
                {{ trans('Finance/lang.group_label') }}
            </x-filament::tabs.item>
            @endPackage
        </x-filament::tabs>
    @endif

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
        @case('CRM')
            @Package('CRM')
            <livewire:reports.c-r-m/>
            @endPackage
            @break
        @case('Finance')
            @Package('Finance')
            <livewire:reports.finance/>
            @endPackage
            @break
        @default
               <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                   @Package('HR')
                   <div wire:click="$set('activeTab', 'HR')" class="bg-white dark:bg-gray-700 rounded cursor-pointer flex items-center gap-4 align-middle hover:shadow-lg  transition-all duration-100" style="border:1px solid rgb(var(--primary-500))">
                       <div class="bg-primary-500 text-white p-8">
                            @svg("tabler-users-group",'w-14 h-14')
                       </div>
                      <div class="text-2xl w-full text-center font-bold">
                          {{ trans('HR/lang.reports.label') }}
                      </div>
                   </div>
                   @endPackage
                   @Package('Logistic')
                   <div wire:click="$set('activeTab', 'Logistic')" class="bg-white dark:bg-gray-700 rounded cursor-pointer flex items-center gap-4 align-middle hover:shadow-lg  transition-all duration-100" style="border:1px solid rgb(var(--primary-500))">
                       <div class="bg-primary-500 text-white p-8">
                           @svg("tabler-building-warehouse",'w-14 h-14')
                       </div>
                       <div class="text-2xl w-full text-center font-bold">
                           {{ trans('Logistic/lang.reports.label') }}
                       </div>
                   </div>
                   @endPackage
                   @Package('POS')
                   <div wire:click="$set('activeTab', 'POS')" class="bg-white dark:bg-gray-700 rounded cursor-pointer flex items-center gap-4 align-middle hover:shadow-lg  transition-all duration-100" style="border:1px solid rgb(var(--primary-500))">
                       <div class="bg-primary-500 text-white p-8">
                           @svg("iconpark-buy",'w-14 h-14')
                       </div>
                       <div class="text-2xl w-full text-center font-bold">
                           {{ trans('POS/lang.group_label') }}
                       </div>
                   </div>
                   @endPackage
                   @Package('Inventory')
                   <div wire:click="$set('activeTab', 'Inventory')" class="bg-white dark:bg-gray-700 rounded cursor-pointer flex items-center gap-4 align-middle hover:shadow-lg  transition-all duration-100" style="border:1px solid rgb(var(--primary-500))">
                       <div class="bg-primary-500 text-white p-8">
                           @svg("tabler-brand-ubuntu",'w-14 h-14')
                       </div>
                       <div class="text-2xl w-full text-center font-bold">
                           {{ trans('Inventory/lang.group_label') }}
                       </div>
                   </div>
                   @endPackage
                   @Package('CRM')
                   <div wire:click="$set('activeTab', 'CRM')" class="bg-white dark:bg-gray-700 rounded cursor-pointer flex items-center gap-4 align-middle hover:shadow-lg  transition-all duration-100" style="border:1px solid rgb(var(--primary-500))">
                       <div class="bg-primary-500 text-white p-8">
                           @svg("tabler-components",'w-14 h-14')
                       </div>
                       <div class="text-2xl w-full text-center font-bold">
                           {{ trans('CRM/lang.group_label') }}
                       </div>
                   </div>
                   @endPackage
                   @Package('Finance')
                   <div wire:click="$set('activeTab', 'Finance')" class="bg-white dark:bg-gray-700 rounded cursor-pointer flex items-center gap-4 align-middle hover:shadow-lg  transition-all duration-100" style="border:1px solid rgb(var(--primary-500))">
                       <div class="bg-primary-500 text-white p-8">
                           @svg("tabler-report-money",'w-14 h-14')
                       </div>
                       <div class="text-2xl w-full text-center font-bold">
                           {{ trans('Finance/lang.group_label') }}
                       </div>
                   </div>
                   @endPackage
               </div>
            @break
       @endswitch

    </x-filament-panels::page>

