<x-filament-panels::page>
    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">
                    <b>{{trans('lang.from')}}:</b> {{$from}}
                </div>
                <div class="font-bold text-center">
                    {{trans('Finance/lang.reports.boursePayment')}}
                </div>
                <div class="text-end">
                    <b>{{trans('lang.to')}}:</b> {{$to}}
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('lang.branch')}}
                </th>
                <th>
                    {{trans('lang.bourse')}}
                </th>
                <th>
                    {{trans('lang.expense_type')}}
                </th>
                <th>
                    {{trans('lang.amount')}}
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
                        {{$dt->branch->name}}
                    </td>
                    <td>
                        {{$dt->bourse->name}}
                    </td>
                    <td>
                        {{trans('lang.'.$dt->type)}}
                    </td>
                    <td>
                        {{number_format($dt->amount,$dt->currency->decimal)}} {{$dt->currency->symbol}}
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
            <tr>
                <th colspan="6" style="text-align: start; background: rgb(var(--primary-500)); color: white">
                    {{trans('lang.total')}}
                </th>
            </tr>
            @foreach($currencies as $currency)
                <tr style="background: rgb(var(--primary-100))">
                    <th>
                        {{$currency->name}}
                    </th>
                    <th></th>
                    <td>
                        {{number_format($data->where('currency_id',$currency->id)->count(),0)}}
                    </td>
                    <td>
                        {{number_format($data->where('currency_id',$currency->id)->sum('amount'),$currency->decimal)}} {{strtoupper($currency->symbol)}}
                    </td>
                    <td colspan="4"></td>
                </tr>
            @endforeach
        @endslot
        @slot('pageFooter')
        @endslot
    </x-core.report-content>
</x-filament-panels::page>
