<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="flex justify-between">
                <div class="flex flex-col">
                    <p class="text-xl font-bold"> <span class="text-primary-600">No.</span> {{ $record->invoice_number }}</p>
                    <p class="text-xl font-bold"> <span class="text-primary-600">{{ trans('lang.contact') }}</span>: {{ $record->contact->name }}</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-xl font-bold"> <span class="text-primary-600">{{ trans('lang.date') }}</span>: {{ $record->date }}</p>
                    <p class="text-xl font-bold"> <span class="text-primary-600">{{ trans('lang.balance') }}</span>: {{number_format($record->contact->balance, getBasecurrency()->decimal)}}
                      {{ getBasecurrency()->symbol }}
                    </p>
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('lang.item')}}
                </th>
                <th>
                    {{trans('lang.quantity')}}
                </th>
                <th>
                    {{trans('lang.price')}}
                </th>
                <th>
                    {{trans('lang.discount')}}
                </th>
            </tr>
        @endslot
        @slot('tableContent')
           @foreach ($record->details as $detail)
                <tr>
                    <td>
                        {{$detail->item->name}}
                    </td>
                    <td>
                        {{ $detail->codes->map(function($record){
                            if($record->gift){
                                    return $record;
                            }
                        })->count() }}
                    </td>
                    <td>
                        {{number_format($detail->price, $detail->currency->decimal)}} {{ $detail->currency->symbol }}
                    </td>
                    <td>
                        {{$detail->item->discount}} %
                    </td>
                </tr>
           @endforeach
        @endslot
        @slot('tableFooter')

        @endslot
        @slot('pageFooter')
              
        @endslot
    </x-core.report-content>

</x-filament-panels::page>
