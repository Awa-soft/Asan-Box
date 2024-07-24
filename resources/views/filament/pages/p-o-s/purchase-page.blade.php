<x-filament-panels::page>
    <div class="grid w-full gap-5 xl:grid-cols-12">
        <p class="text-3xl font-bold xl:col-span-7 2xl:col-span-7">{{ trans('POS/lang.purchase.plural_label') }}</p>
        <div class="grid grid-cols-5 gap-2 text-xs h-max xl:col-span-5 2xl:col-span-5" x-data="{
            active: 'single',
        }">
            <div dir="ltr"
                class="relative grid items-center grid-cols-2 text-center border-2 border-gray-400 rounded-full dark:border-gray-900">
                <div  class="absolute grid items-center justify-center w-full h-full grid-cols-2 text-center">
                    <p wire:click="$set('multipleSelect', false)" @click="active='single'"
                        class="top-0 z-10 cursor-pointer">{{ trans('lang.single') }}</p>
                    <p wire:click="$set('multipleSelect', true)" @click="active='multiple'" class="z-10 cursor-pointer">
                        {{ trans('lang.multiple') }} </p>
                </div>
                <div class="absolute top-0 grid w-full h-full grid-cols-2">
                    <div :class="active == 'single' ? 'translate-x-0' : 'translate-x-full'"
                        class="w-full h-full duration-300 rounded-full bg-primary-500"></div>
                </div>
            </div>
            <div wire:click="addToTable"
                class="flex items-center justify-center p-2 text-white duration-300 rounded-md shadow cursor-pointer bg-primary-600 hover:bg-primary-500">
                {{ trans('lang.add_to', ['name' => trans('lang.table')]) }}
            </div>
            <div wire:click="selectAll"
                class="flex items-center justify-center p-2 text-white duration-300 bg-green-600 rounded-md shadow cursor-pointer hover:bg-green-500">
                {{ trans('lang.select_all') }}
            </div>
            <div wire:click="deselectAll"
                class="flex items-center justify-center p-2 text-white duration-300 rounded-md shadow cursor-pointer bg-danger-600 hover:bg-danger-500">
                {{ trans('lang.deselect_all') }}
            </div>
            <div wire:click="submit"
                class="flex items-center justify-center p-2 text-white duration-300 bg-blue-600 rounded-md shadow cursor-pointer hover:bg-blue-500">
                {{ trans('filament-actions::modal.actions.submit.label') }}
            </div>
        </div>

    </div>
    <div class="grid xl:grid-cols-12 xl:h-[76vh] h-[85vh] gap-5">

        <div class="flex flex-col h-full gap-3 rounded-md xl:col-span-9 2xl:col-span-9">
            <div
                class="flex w-full gap-5 p-2 border-2 border-dotted rounded-md h-maxdark:border-gray-700 border-black/50">
                <form class="w-full ">
                    {{ $this->invoiceForm }}
                </form>
            </div>
            <div
                class="w-full gap-3 overflow-y-scroll border-2 border-dotted rounded-md h-5/6 max-h-[50vh] dark:border-gray-700 border-black/50">
                <table class="w-full ">
                    <thead>
                        <tr class="grid w-full grid-cols-9 text-sm font-semibold text-center bg-white dark:bg-gray-900">
                            <td class="py-3 border-b border-e dark:border-gray-600">{{ trans('lang.type') }}</td>
                            <td class="py-3 border-b border-e dark:border-gray-600">{{ trans('lang.image') }}</td>
                            <td class="py-3 border-b border-e dark:border-gray-600">
                                {{ trans('Inventory/lang.item.singular_label') }}</td>
                            <td class="py-3 border-b border-e dark:border-gray-600">
                                {{ trans('settings/lang.currency.singular_label') }}</td>
                            <td class="py-3 border-b border-e dark:border-gray-600">{{ trans('lang.quantity') }}</td>
                            <td class="py-3 border-b border-e dark:border-gray-600">{{ trans('lang.gift') }}</td>
                            <td class="py-3 border-b border-e dark:border-gray-600">{{ trans('lang.cost') }}</td>
                            <td class="py-3 border-b border-e dark:border-gray-600">{{ trans('lang.total_cost') }}
                                </td>
                            <td class="py-3 border-b dark:border-gray-600"></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tableData as $key => $data)
                            <tr  class="grid items-center w-full grid-cols-9 gap-1 even:bg-gray-200">
                                <td class="py-2 text-center ps-2">
                                    <x-filament::input.wrapper>
                                        <x-filament::input.select wire:model.live="tableData.{{ $key }}.type">
                                            <option value="single">{{ trans('lang.single') }}</option>
                                            <option value="multiple">{{ trans('lang.multiple') }}</option>
                                        </x-filament::input.select>
                                    </x-filament::input.wrapper>
                                </td>
                                <td class="flex justify-center item-center">
                                    <div class="py-1 text-center rounded-full w-14 h-14 aspect-square">
                                        @if ($data['image'])
                                            <img class="w-full h-full rounded-full aspect-square"
                                                src="/storage/{{ $data['image'] }}" alt="">
                                        @else
                                            <img class="w-full h-full rounded-full aspect-square"
                                                src="/assets/img/item.png" alt="">
                                        @endif
                                    </div>
                                </td>
                                <td class="py-2 text-center"> {{ $data['brand'] }} - {{ $data['name_'.\Illuminate\Support\Facades\App::getLocale()] }}</td>
                                <td class="py-2 text-center">
                                    <x-filament::input.wrapper>
                                        <x-filament::input.select
                                            wire:model.live="tableData.{{ $key }}.currency_id">
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}">{{ $currency->name }} -
                                                    {{ $currency->symbol }}</option>
                                            @endforeach
                                        </x-filament::input.select>
                                    </x-filament::input.wrapper>
                                </td>
                                <td class="py-2 text-center">
                                    <p>{{ collect($data['codes'])->where('gift', 0)->count() }}</p>
                                </td>
                                <td class="py-2 text-center">
                                    <p>{{ collect($data['codes'])->where('gift', 1)->count() }}</p>
                                </td>
                                <td class="py-2 text-center"><x-filament::input.wrapper>
                                        <x-filament::input type="number"
                                            wire:model.live.debounce.500ms="tableData.{{ $key }}.price" />
                                    </x-filament::input.wrapper></td>
                                <td class="py-2 text-center">
                                    {{ number_format($data['price'] *collect($data['codes'])->where('gift', 0)->count(),getCurrencyDecimal($data['currency_id'] ?? 1)) }}
                                    {{ getCurrencySymbol($data['currency_id'] ?? 1) }}
                                </td>
                                <td class="py-2 ">
                                    <div class="grid grid-cols-3 gap-y-5">

                                        <div wire:click='openCodeModal( {{ $key }} )'
                                            class="w-8 text-green-600 duration-300 cursor-pointer hover:text-green-500">
                                            <x-heroicon-o-plus />
                                        </div>
                                        <div wire:click="removeFromTable('{{ $key }}')"
                                            class="w-8 duration-300 cursor-pointer text-danger-600 hover:text-danger-500">
                                            <x-heroicon-o-trash />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div
                class="flex w-full gap-5 p-2 border-2 border-dotted rounded-md h-maxdark:border-gray-700 border-black/50">
                <form class="w-full ">
                    {{ $this->invoiceForm2 }}
                </form>
            </div>
        </div>

        <div
            class="grid relative order-first max-h-[80vh] h-full border-2 border-dotted rounded-md grid-rows-12 xl:h-full xl:col-span-3 2xl:col-span-3 xl:order-last dark:border-gray-700 border-black/50">
            <div class="sticky top-0 flex flex-col w-full row-span-1 gap-3 p-2 bg-white dark:bg-gray-900">
                <p class="text-xl font-semibold">{{ trans('Inventory/lang.item.plural_label') }}</p>
                <x-filament::input.wrapper>
                    <x-filament::input type="text" wire:model.live="name" placeholder="{{ trans('lang.search') }}" />
                </x-filament::input.wrapper>
            </div>
            <ul class="overflow-y-scroll row-span-10">
                <div class="flex flex-col w-full gap-3 p-2 max-h-11/12 overflow-y-scroll">
                    @foreach ($items as $item)
                        <li wire:click='addToSelect({{ $item }})'
                            class="flex {{ in_array($item['id'], $selected) ? 'bg-primary-600' : 'dark:bg-gray-900 bg-white' }} items-center w-full gap-3 p-3 duration-300  border rounded-md cursor-pointer  hover:bg-primary-600 dark:hover:bg-primary-400 dark:border-gray-700 ">
                            <div class="w-10 aspect-square">
                                @if ($item->image)
                                    <img class="object-fill w-full h-full rounded-full"
                                        src="/storage/{{ $item->image }}" alt="">
                                @else
                                    <img class="object-fill w-full h-full rounded-full" src="/assets/img/item.png"
                                        alt="">
                                @endif
                            </div>
                            <div class="flex items-center justify-between w-full">
                                <div class="flex flex-col ">
                                    <p class="text-base font-bold">{{ $item->{'name_'.\Illuminate\Support\Facades\App::getLocale()} }} </p>
                                    <p class="text-xs font-light">{{ $item->brand?$item->brand->name:null }} -
                                        {{ $item->category?$item->category->name:null }}</p>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <p class="text-xs font-light">{{ number_format($item->min_price, 2) }} $</p>
                                    <p class="text-xs font-light">{{ number_format($item->max_price, 2) }} $</p>
                                </div>
                            </div>
                        </li>
                    @endforeach

                </div>
            </ul>
            <div class="absolute bottom-0 flex flex-col w-full row-span-1 gap-3 p-2 bg-white dark:bg-gray-900">
                {{$items->links('custom-pagination-links-view')}}
            </div>

        </div>

    </div>

    <x-filament::modal id="code-modal" width="xl">
        <div class="flex flex-col w-full gap-3">
            <form wire:submit='addToCode' class="flex items-center w-full gap-5 px-3">

                <div class="flex items-center w-full gap-5 ">
                    <div class="w-full">
                        <label for="">{{ trans('lang.code') }}</label>
                        <x-filament::input.wrapper>
                            <x-filament::input type="text" wire:model="codes.code"
                                placeholder="{{ trans('lang.code') }}" />
                        </x-filament::input.wrapper>
                    </div>
                    <div class="flex items-center gap-3 mt-5 w-max">
                        <label for="">{{ trans('lang.gift') }}</label>
                        <input type="checkbox" wire:model='codes.gift' value="yes" id=""
                            name="gift">
                    </div>
                </div>

                <button type="submit"
                    class="w-8 mt-5 duration-300 cursor-pointer text-primary-600 hover:text-primary-500">
                    <x-heroicon-o-plus />
                </button>
            </form>

            <div class="flex flex-col gap-3 px-2 overflow-y-scroll h-96">
                @forelse ($this->tableData[$this->key]['codes']??[] as $key=>$code)
                    <div class="flex items-center justify-between w-full p-3 text-black bg-gray-200 rounded-md">
                        <p>{{ $code['code'] }}</p>

                        <div class="flex gap-3">
                            @if ($code['gift'] == 1)
                                <p wire:click='toggleGift({{ $key }})'
                                    class="p-2 text-xs text-white uppercase bg-green-600 rounded-md cursor-pointer">
                                    {{ trans('lang.gift') }}</p>
                            @else
                                <p wire:click='toggleGift({{ $key }})'
                                    class="p-2 text-xs text-white uppercase bg-yellow-500 rounded-md cursor-pointer">
                                    {{ trans('lang.cost') }}</p>
                            @endif

                            <div wire:click="removeCode('{{ $key }}')"
                                class="w-8 duration-300 cursor-pointer text-danger-600 hover:text-danger-500">
                                <x-heroicon-o-trash />
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

        </div>
    </x-filament::modal>
</x-filament-panels::page>
