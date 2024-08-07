<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">
                    <b>{{trans('lang.from')}}:</b> {{$from}}
                </div>
                <div class="font-bold text-center">
                    {{trans('Inventory/lang.reports.itemLoss')}}
                </div>
                <div class="text-end">
                    <b>{{trans('lang.to')}}:</b> {{$to}}
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('lang.owner')}}
                </th>
                <th>
                    {{trans('lang.item')}}
                </th>
                <th>
                    {{trans('lang.code')}}
                </th>
                <th>
                    {{trans('lang.cost')}}
                </th>
                <th>
                    {{trans('lang.date')}}
                </th>
                <th>
                    {{trans('lang.user')}}
                </th>
            </tr>
        @endslot
        @slot('tableContent')
                @foreach($data as $dt)
                    <tr>
                        <td>
                            {{$dt->ownerable->name}}
                        </td>
                        <td>
                            {{$dt->item->{'name_'.\Illuminate\Support\Facades\App::getLocale()} }}
                        </td>
                        <td>
                            {{$dt->code}}
                        </td>
                        <td>
                            {{number_format($dt->cost,$dt->currency->decimal)}} {{$dt->currency->symbol}}
                        </td>
                        <td>
                            {{$dt->date}}
                        </td>
                        <td>
                            {{$dt->user->name}}
                        </td>
                    </tr>
                @endforeach
        @endslot
        @slot('tableFooter')
                <tr class="bg-primary-500 text-white">
                    <th>
                        {{trans('lang.total')}}
                    </th>
                    <th colspan="1"></th>
                    <th>
                        {{number_format($data->count())}}
                    </th>
                    <th colspan="3"></th>
                </tr>
                @foreach($currencies as $currency)
                    <tr class="bg-primary-200">
                        <th>
                            {{$currency->name}}
                        </th>
                        <th colspan="1">
                        </th>
                        <th>
                            {{number_format($data->where('currency_id',$currency->id)->count())}}
                        </th>
                        <th>
                            {{number_format($data->where('currency_id',$currency->id)->sum('cost'),$currency->decimal)}} {{$currency->symbol}}
                        </th>
                        <th colspan="2">
                        </th>
                    </tr>
                @endforeach
        @endslot
        @slot('pageFooter')
        @endslot
    </x-core.report-content>
</x-filament-panels::page>
