<x-filament-panels::page>
<style>

    @page{
        width: 5cm;
    }

    @media print{
        .fi-header div{
            width: 100%;
        }
        .fi-header-heading{
            text-align: center
        }
        .fi-body {
            background: white;
        }
        .fi-ta-actions, .fi-sidebar,.fi-topbar,.fi-ta-header-ctn,.fi-ta-header-cell-sort-icon,.fi-sidebar-close-overlay,.fi-ac,.fi-breadcrumbs{
            display: none;
            visibility: hidden;
        }
        .fi-header{
            display: none !important;
        }

    }

 




</style>
<div class="container  mx-auto p-2">
    <div class="w-1/2 print:hidden mx-auto flex gap-2 flex-col">
        <label>
            {{trans('lang.number_of_codes')}}
        </label>
        <x-filament::input.wrapper>
            <x-filament::input
                type="numeric"
                wire:model.live.debounce.200ms="numberOfCodes"
                max="30"
            />
        </x-filament::input.wrapper>
    </div>
    @foreach($codes as $key => $code)
        @if($key %7 == 0 && $key !=0)
            <div class="break-after-page"></div>
        @endif
       <div class="flex flex-col items-center align-middle w-[5cm] bg-white my-2 border  mx-auto p-4">
           <div>
               @php
                   echo DNS1D::getBarcodeHTML($code, 'C128',h:60,w:0.9);
               @endphp
           </div>
           <div>
               {{$code}}
           </div>
       </div>
    @endforeach
</div>

</x-filament-panels::page>
