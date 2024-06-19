<x-filament-panels::page>
    <div class="grid xl:grid-cols-11">
        <div class="col-span-5">
            <label for="">{{ trans('lang.search') }}</label>
            <x-filament::input.wrapper>
                <x-filament::input

                    type="text"
                    placeholder="{{ trans('lang.search') }}"
                    wire:model.live.debounce.500ms="search_item"
                />
            </x-filament::input.wrapper>
        </div>
        <div></div>
        <div class="col-span-5">
            <label for="">{{ trans('Logistic/lang.branch.singular_label') }}</label>
            <x-filament::input.wrapper>
    <x-filament::input.select
    wire:model.live='selectedBranch'>
        <option ></option>

        @forelse ($branchs as $branch)
        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
        @empty

        @endforelse

    </x-filament::input.select>
</x-filament::input.wrapper>
        </div>
    </div>
<div class="grid grid-cols-1 xl:grid-cols-11 w-full gap-3">
    <ul class="xl:col-span-5 h-[43rem] overflow-y-scroll border-2 w-full flex flex-col gap-3  border-dotted rounded-md dark:border-gray-700 border-black/50 p-3">
       <div class="flex gap-3">
        <p wire:click="selectAll('items', 'select')" class="text-sm underline underline-offset-2 text-primary-600 hover:text-primary-500 duration-300 cursor-pointer">{{ trans('lang.select_all') }}</p>
        <p wire:click="selectAll('items', 'deselect')" class="text-sm underline underline-offset-2 text-danger-500 hover:text-danger-400  duration-300 cursor-pointer">{{ trans('lang.deselect_all') }}</p>
       </div>
        @foreach ($items as $item)
        <li wire:click="addToSelect('selection',{{ $item->id }})" class="flex gap-3 {{ in_array($item->id, $selected)?'bg-primary-400':'dark:bg-gray-900 bg-white' }}  w-full items-center p-3 cursor-pointer hover:bg-primary-600 dark:hover:bg-primary-400 duration-300 rounded-md border dark:border-gray-700 ">
            <div class="w-10 aspect-square">
                @if ($item->image !=null)
                <img class="w-full h-full object-fill rounded-full" src="/storage/{{ $item->image }}" alt="">
                @else
                <img class="w-full h-full object-fill rounded-full" src="/assets/img/item.png" alt="">
                @endif
            </div>
            <div class="flex justify-between w-full items-center">
                <p class="text-xl font-normal">{{ $item->name }}</p>
                <div>
                    <p class="text-sm font-light">{{ $item->category->name }}</p>
                    <p class="text-sm font-light"><span>{{ trans('lang.cost') }}: </span>{{ number_format($item->cost, 2) }} $</p>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    <ul class="col-span-1 xl:h-[43rem] h-max items-center justify-center flex xl:flex-col gap-5">
        <li wire:click='transfer' class="w-10 bg-primary-500 hidden xl:block rounded-full text-white shadow shadow-black cursor-pointer hover:bg-primary-400 duration-400">
            <x-heroicon-o-chevron-right />
        </li>
        <li wire:click='transfer' class="w-10 bg-primary-500 block xl:hidden rounded-full text-white shadow shadow-black cursor-pointer hover:bg-primary-400 duration-400">
            <x-heroicon-o-chevron-down  />
        </li>
        <li wire:click='resetSelections' class="w-10 bg-danger-500 rounded-full  text-white shadow shadow-black cursor-pointer hover:bg-danger-400 duration-300">
            <x-heroicon-o-x-mark />
        </li>

        <li wire:click="transferBack" class="w-10 bg-primary-500 hidden xl:block rounded-full text-white shadow shadow-black cursor-pointer hover:bg-primary-400 duration-300">
            <x-heroicon-o-chevron-left />
        </li>
        <li wire:click="transferBack" class="w-10 bg-primary-500 block xl:hidden rounded-full text-white shadow shadow-black cursor-pointer hover:bg-primary-400 duration-300">
            <x-heroicon-o-chevron-up  />
        </li>
    </ul>
    <ul class="xl:col-span-5 overflow-y-scroll h-[43rem] border-2 w-full flex flex-col gap-3  border-dotted rounded-md dark:border-gray-700 border-black/50 p-3">
        <div class="flex gap-3">
            <p wire:click="selectAll('warehouse', 'select')" class="text-sm underline underline-offset-2 text-primary-600 hover:text-primary-500 duration-300 cursor-pointer">{{ trans('lang.select_all') }}</p>
            <p wire:click="selectAll('warehouse', 'deselect')" class="text-sm underline underline-offset-2 text-danger-500 hover:text-danger-400  duration-300 cursor-pointer">{{ trans('lang.deselect_all') }}</p>
           </div>
        @foreach ($transfered['data'] as $key => $item)
        <li wire:click="addToSelect('transfered',{{ $item->id }})" class="flex gap-3 {{ in_array($item->id, $selectedTransfered)?'bg-primary-400':'dark:bg-gray-900 bg-white' }} w-full items-center p-3 cursor-pointer hover:bg-primary-600 dark:hover:bg-primary-400 duration-300 rounded-md border dark:border-gray-700 ">
            <div class="w-10 aspect-square">
                @if ($item->image !=null)
                <img class="w-full h-full object-fill rounded-full" src="/storage/{{ $item->image }}" alt="">
                @else
                <img class="w-full h-full object-fill rounded-full" src="/assets/img/item.png" alt="">
                @endif
            </div>
            <div class="flex justify-between w-full items-center">
                <p class="text-xl font-normal">{{ $item->name }}</p>
                <div>
                    <p class="text-sm font-light">{{ $item->category->name }}</p>
                    <p class="text-sm font-light"><span>{{ trans('lang.cost') }}: </span>{{ number_format($item->cost, 2) }} $</p>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
</x-filament-panels::page>
