<x-filament-panels::page>

    <x-core.report-content size="A5" listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 gap-2 align-middle border rounded-md ">
                <div class="text-start">
                        <b>{{trans('lang.no')}}</b>. {{$record->invoice_number}}
                </div>
                <div class="text-center font-bold text-lg">
                   {{trans('lang.payment')}}
                </div>
                <div class=" text-end">
                   <b> {{trans('lang.date')}}</b> : {{$record->date}}
                </div>


            </div>
        @endslot
        @slot('tableHeader')
        @endslot
        @slot('tableContent')
            <tr>
                <th>
                    {{trans('lang.contact')}}
                </th>
                <td style="text-align: justify">
                    {{$record->contact->name}}
                </td>
            </tr>
            <tr>
                <th>
                    {{trans('lang.phone')}}
                </th>
                <td style="text-align: justify">
                    {{$record->contact->phone}}
                </td>
            </tr>
                <tr>
                    <th>
                        {{trans('lang.type')}}
                    </th>
                    <td style="text-align: justify">
                        {{trans("lang.{$record->type}")}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{trans('lang.amount')}}
                    </th>
                    <td style="text-align: justify">
                       {{number_format($record->amount,$record->currency->decimal)}} {{$record->currency->symbol}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{trans('lang.balance')}}
                    </th>
                    <td style="text-align: justify">
                        {{number_format($record->balance,2)}} $
                    </td>
                </tr>
                <tr>
                    <th>
                        {{trans('lang.note')}}
                    </th>
                    <td style="text-align: justify">
                        {{$record->note}}
                    </td>
                </tr>
        @endslot
        @slot('tableFooter')

        @endslot
        @slot('pageFooter')

        @endslot
    </x-core.report-content>

</x-filament-panels::page>
