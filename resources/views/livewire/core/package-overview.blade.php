<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <h1 class="font-bold">{{ $name }} <span>V{{ $version }}</span></h1>
                @if ($status == 'true')
                    <div class="w-8 text-green-500">
                        <x-iconsax-lin-tick-circle />
                    </div>
                @else
                    <div class="w-8 text-red-500">
                        <x-heroicon-o-x-circle />
                    </div>
                @endif
            </div>
            <div class="flex items-center justify-between">
               <div class="flex flex-col gap-1">
                <p class="text-sm"><span class="font-semibold ">{{ trans('lang.type') }}:</span> {{ $type }}</p>
                <p class="text-sm"><span class="font-semibold ">{{ trans('lang.price') }}:</span> {{ $price }} $</p>
                <p class="text-sm"><span class="font-semibold ">{{ trans('lang.active_date') }}:</span> {{ $active_date }} </p>
               </div>

               <div class="w-16">
                <img class="object-top w-full" src="/assets/img/item.png" alt="">
               </div>
            </div>
            <p class="text-xs">{{ $description }}</p>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
