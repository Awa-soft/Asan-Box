<x-filament-widgets::widget>
    <x-filament::section>
       <div class="flex items-center justify-between">
            <div class="flex flex-col gap-2">
                <div>
                    <p class="text-sm">{{ $name }}</p>
                    <h1 class="text-2xl font-bold "> <span class="text-primary-600">{{ $amount }}</span> {{ $symbol }}</h1>
                </div>
            </div>
            <div class="relative">
                <p class="font-extrabold text-7xl text-black/55">{{ $symbol }}</p>
       </div>
    </x-filament::section>
</x-filament-widgets::widget>
