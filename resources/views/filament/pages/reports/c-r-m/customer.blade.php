<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div>

                </div>
                <div class="font-bold">
                    @if($type == 'customer')
                        {{trans('CRM/lang.reports.customers')}}
                    @elseif($type == 'vendor')
                        {{trans('CRM/lang.reports.vendors')}}
                    @else
                        {{trans('CRM/lang.reports.both')}}
                    @endif
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
                {{trans('lang.max_debt')}}
            </th>
            <th>
                {{trans('lang.balance')}}
            </th>
            <th>
                {{trans('lang.status')}}
            </th>
        @endslot
        @slot('tableContent')
            @foreach($data as $dt)
                <tr>
                    <td>
                        {{$dt->ownerable->name}}
                    </td>
                    <td>
                        {{$dt->{'name_'.\Illuminate\Support\Facades\App::getLocale()} }}
                    </td>
                    <td>
                        {{$dt->phone}}
                    </td>
                    <td>
                        {{number_format($dt->max_debt,2)}} {{getBaseCurrency()?->symbol}}
                    </td>
                    <td>
                        {{number_format($dt->balance,2)}} {{getBaseCurrency()?->symbol}}
                    </td>
                    <td>
                        @if($dt->status)
                            <span class="text-green-600">{{trans('lang.active')}}</span>
                        @else
                            <span class="text-red-600">{{trans('lang.inactive')}}</span>
                        @endif
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
