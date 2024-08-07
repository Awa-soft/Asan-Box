<x-filament-panels::page>
    {{$this->form}}
    <div>
        @foreach($data['branches'] as $key => $branch)
            <div class="col-span-full">
                {{$key}}
            </div>
            <div class="grid my-4 grid-cols-1 @if(count($branch) >= 2) md:grid-cols-2 @endif @if(count($branch) >= 3) lg:grid-cols-3 @endif @if(count($branch) >= 4) xl:grid-cols-4 @endif gap-6">
                @foreach($branch as $currencies)
                    <div class="bg-gray-200 flex justify-between items-center align-middle dark:bg-gray-800 p-4 rounded-md">
                        <div>
                            {{$currencies['name']}}
                        </div>
                        <div>
                            {{number_format($currencies['balance'],$currencies['decimal'])}} {{$currencies['symbol']}}
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    <div class="mt-4  bg-gray-200 dark:bg-gray-700 overflow-hidden rounded">
        <table class="w-full">
            <thead class="bg-primary-900 border dark:border-gray-600 text-white">
                <th>
                    {{trans('lang.type')}}
                </th>
                <th>
                    {{trans('lang.title')}}
                </th>
                <th class="py-2">
                    {{trans('lang.branch')}}
                </th>
                <th class="py-2">
                    {{trans('lang.name')}}
                </th>
                <th class="py-2">
                    {{trans('lang.amount')}}
                </th>
                <th class="py-2">
                    {{trans('lang.user')}}
                </th>
                <th class="py-2">
                    {{trans('lang.date')}}
                </th>
            <th>

            </th>
            </thead>
            <tbody>
                @foreach($data['records'] as $key  => $record)
                    <tr class="text-center border  dark:border-gray-600 odd:bg-gray-100 dark:odd:bg-gray-900">
                        <td class=" text-center p-2 @if($record['type'] == 'send') bg-danger-900 @else bg-success-900 @endif text-white">
                            {{trans('lang.'.$record['type'])}}
                        </td>
                        <td class=" text-center p-2">
                            {{$record['title']}}
                        </td>
                        <td class=" text-center p-2">
                            {{$record->branch}}
                        </td>
                        <td class=" text-center p-2">
                            {{$record->name}}
                        </td>
                        <td class=" text-center p-2">
                            {{number_format($record->amount,$record->currency->decimal)}} {{$record->currency->symbol}}
                        </td>
                        <td class=" text-center p-2">
                            {{$record->user->name}}
                        </td>
                        <td class=" text-center p-2">
                            {{\Carbon\Carbon::parse($record->date)->format('Y-m-d')}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{$data['records']->links()}}
    </div>

</x-filament-panels::page>
