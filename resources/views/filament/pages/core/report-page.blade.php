    <x-filament-panels::page>
        <style>
            .report-page  .fi-section{
                display: flex !important;
                flex-flow: column !important;
                justify-content: normal !important;
            }
            .report-page .fi-section-content-ctn{
                display: flex !important;
                flex-flow: column !important;
                justify-content: space-between !important;
                height: -webkit-fill-available !important;
            }
        </style>
        <div class="grid  report-page lg:grid-cols-2 2xl:grid-cols-4 grid-cols-1 gap-4">
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
            @Package('HR')
            <div class="col-span-full">
                <p class="my-3 text-lg font-bold ">{{ trans('HR/lang.reports.label') }}</p>
            </div>
            <x-filament::section>
                <x-slot name="icon">
                    @svg(\App\Filament\Resources\HR\EmployeeActivityResource::getNavigationIcon(),'w-8 text-primary-500' )
                </x-slot>
                <x-slot name="heading">
                    {{ trans('HR/lang.reports.activity') }}
                </x-slot>
                {{$this->hrEmployeeActivityForm}}
                <x-slot name="footerActions">
                    <x-filament::button type="submit" wire:click="searchEmployeeActivity()" class="mt-5">
                        {{ trans('filament-actions::modal.actions.submit.label') }}
                    </x-filament::button>
                </x-slot>
            </x-filament::section>
            <x-filament::section>
                <x-slot name="icon">
                    @svg(\App\Filament\Resources\HR\EmployeeLeaveResource::getNavigationIcon(),'w-8 text-primary-500' )
                </x-slot>
                <x-slot name="heading">
                    {{ trans('HR/lang.reports.leave') }}
                </x-slot>
                {{$this->hrEmployeeLeaveForm}}
                <x-slot name="footerActions">
                    <x-filament::button type="submit" wire:click="searchEmployeeLeave()" class="mt-5">
                        {{ trans('filament-actions::modal.actions.submit.label') }}
                    </x-filament::button>
                </x-slot>
            </x-filament::section>
            <x-filament::section>
                <x-slot name="icon">
                    @svg(\App\Filament\Resources\HR\EmployeeNoteResource::getNavigationIcon(),'w-8 text-primary-500' )
                </x-slot>
                <x-slot name="heading">
                    {{ trans('HR/lang.reports.note') }}
                </x-slot>
                {{$this->hrEmployeeNoteForm}}
                <x-slot name="footerActions">
                    <x-filament::button type="submit" wire:click="searchEmployeeNote()" class="mt-5">
                        {{ trans('filament-actions::modal.actions.submit.label') }}
                    </x-filament::button>
                </x-slot>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="icon">
                    @svg(\App\Filament\Resources\HR\EmployeeResource::getNavigationIcon(),'w-8 fill-primary-500' )
                </x-slot>
                <x-slot name="heading">
                    {{ trans('HR/lang.reports.employees') }}
                </x-slot>
                {{$this->hrEmployeesForm}}
                <x-slot name="footerActions">
                    <x-filament::button type="submit" wire:click="searchEmployees()" class="mt-5">
                        {{ trans('filament-actions::modal.actions.submit.label') }}
                    </x-filament::button>
                </x-slot>
            </x-filament::section>
            <div class="grid grid-col-1 xl:grid-cols-2 col-span-full gap-4">
                <x-filament::section>
                    <x-slot name="icon">
                        @svg(\App\Filament\Resources\HR\EmployeeResource::getNavigationIcon(),'w-8 fill-primary-500' )
                    </x-slot>
                    <x-slot name="heading">
                        {{ trans('HR/lang.reports.employees_summary') }}
                    </x-slot>
                    {{$this->hrEmployeesSummaryForm}}
                    <x-slot name="footerActions">
                        <x-filament::button type="submit" wire:click="searchEmployeesSummary()" class="mt-5">
                            {{ trans('filament-actions::modal.actions.submit.label') }}
                        </x-filament::button>
                    </x-slot>
                </x-filament::section>
            </div>
               <div class="grid grid-col-1 xl:grid-cols-3 col-span-full gap-4">
                   <x-filament::section>
                       <x-slot name="icon">
                           @svg(\App\Filament\Resources\HR\IdentityTypeResource::getNavigationIcon(),'w-8 fill-primary-500' )
                       </x-slot>
                       <x-slot name="heading">
                           {{ trans('HR/lang.reports.identity_types') }}
                       </x-slot>
                       {{$this->hrIdentityTypesForm}}
                       <x-slot name="footerActions">
                           <x-filament::button type="submit" wire:click="searchIdentityTypes()" class="mt-5">
                               {{ trans('filament-actions::modal.actions.submit.label') }}
                           </x-filament::button>
                       </x-slot>
                   </x-filament::section>
                   <x-filament::section>
                       <x-slot name="icon">
                           @svg(\App\Filament\Resources\HR\PositionResource::getNavigationIcon(),'w-8 fill-primary-500' )
                       </x-slot>
                       <x-slot name="heading">
                           {{ trans('HR/lang.reports.positions') }}
                       </x-slot>
                       {{$this->hrPositionsForm}}
                       <x-slot name="footerActions">
                           <x-filament::button type="submit" wire:click="searchPositions()" class="mt-5">
                               {{ trans('filament-actions::modal.actions.submit.label') }}
                           </x-filament::button>
                       </x-slot>
                   </x-filament::section>
                   <x-filament::section>
                       <x-slot name="icon">
                           @svg(\App\Filament\Resources\HR\TeamResource::getNavigationIcon(),'w-8 fill-primary-500' )
                       </x-slot>
                       <x-slot name="heading">
                           {{ trans('HR/lang.reports.team') }}
                       </x-slot>
                       {{$this->hrTeamsForm}}
                       <x-slot name="footerActions">
                           <x-filament::button type="submit" wire:click="searchTeams()" class="mt-5">
                               {{ trans('filament-actions::modal.actions.submit.label') }}
                           </x-filament::button>
                       </x-slot>
                   </x-filament::section>
               </div>
            @endPackage
        </div>
    </x-filament-panels::page>

