<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div>

                </div>
                <div class="font-bold">
                        {{trans('CRM/lang.reports.bourses')}}

                </div>
                <div>
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <th>
                {{trans('lang.owner')}}
            </th>
            <th>
                {{trans('lang.name')}}
            </th>
            <th>
                {{trans('lang.phone')}}
            </th>
            <th>
                {{trans('lang.email')}}
            </th>
                <th>
                    {{trans('lang.balance')}}
                </th>
        @endslot
        @slot('tableContent')
            @foreach($data as $dt)
                <tr>
                    <td>
                        {{$dt->ownerable->name}}
                    </td>
                    <td>
                        {{$dt->{'name'} }}
                    </td>
                    <td>
                        {{$dt->phone}}
                    </td>
                    <td>
                        {{$dt->email}}
                    </td>
                    <td>
                        {{number_format($dt->balance,getBaseCurrency()->decimal)}} {{getBaseCurrency()->symbol}}
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
