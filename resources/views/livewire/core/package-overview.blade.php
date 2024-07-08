<x-filament-widgets::widget>
    {{-- class="absolute top-0 h-full -z-10 end-0" --}}
    <x-filament::section class="relative z-10 w-full">
        <svg class="absolute top-0 h-full -z-10 end-0"  xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
            xmlns:svgjs="http://svgjs.dev/svgjs" viewBox="0 0 600 600" opacity="1">
            <path
                d="M596.4659423828125,594.5026245117188C617.801015218099,549.2146666844686,620.4188130696615,57.7225144704183,599.6072998046875,4.712041854858398C578.7957865397135,-48.2984307607015,472.12042236328125,178.14135837554932,471.59686279296875,276.4397888183594C471.07330322265625,374.73821926116943,575.130869547526,639.7905823389689,596.4659423828125,594.5026245117188C617.801015218099,549.2146666844686,620.4188130696615,57.7225144704183,599.6072998046875,4.712041854858398"
                fill="{{ $color }}" stroke-width="5" stroke="hsl(340, 45%, 30%)" stroke-opacity="0.05"
                transform="matrix(2.1828745883819374,0,0,2.1828745883819374,-642.0111210422267,-352.758350252991)">
            </path>
            <path
                d="M523.4052557785122 522.4619358463206C544.7403286137987 477.1739780190709 547.3581264653612 -14.318174194979633 526.5466132003872 -67.32864681053954C505.73509993541325 -120.33911942609944 399.059735758981 106.10066971015138 398.5361761886685 204.39910015296144C398.012616618356 302.6975305957709 502.07018294322575 567.7498936735703 523.4052557785122 522.4619358463206C544.7403286137987 477.1739780190709 547.3581264653612 -14.318174194979633 526.5466132003872 -67.32864681053954 "
                fill-opacity="0.05" fill="hsl(340, 45%, 50%)" opacity="0.98" stroke-opacity="0.33" stroke-width="3"
                stroke="hsl(340, 45%, 30%)"
                transform="matrix(2.6532977051444226,0,0,2.6532977051444226,-699.1644890763683,-297.5837789456691)">
            </path>
        </svg>
        <div class="relative flex flex-col ">

            <div class="flex items-center gap-3">
                <h1 class="font-bold" style="color:{{ $color }}">{{ $name }} <span
                        class="text-black dark:text-white">V{{ $version }}</span></h1>
                @if ($status)
                    <div class="w-5 text-green-500">
                        <x-iconsax-lin-tick-circle />
                    </div>
                @else
                    <div class="w-5 text-red-500">
                        <x-heroicon-o-x-circle />
                    </div>
                @endif
            </div>
            <div class="flex items-center justify-between">
                <div class="flex flex-col gap-1">
                    <p class="text-sm"><span class="font-semibold "
                            style="color:{{ $color }}">{{ trans('lang.type') }}:</span> {{ $type }}</p>
                    <p class="text-sm"><span class="font-semibold "
                            style="color:{{ $color }}">{{ trans('lang.price') }}:</span> {{ $price }} $
                    </p>
                    <p class="text-sm"><span class="font-semibold "
                            style="color:{{ $color }}">{{ trans('lang.active_date') }}:</span>
                        {{ $active_date }} </p>
                </div>

                <div class="w-20 ">
                    <img class="object-cover w-full " src="/{{ $image }}" alt="">
                </div>
            </div>
            <p class="text-xs">{{ $description }}</p>
        </div>

        
    </x-filament::section>
</x-filament-widgets::widget>
