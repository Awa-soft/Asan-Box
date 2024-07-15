<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">
                    <b>{{trans('lang.from')}}:</b> {{$from}}
                </div>
                <div class="font-bold text-center">
                    @if($type == 'sale')
                        {{trans('POS/lang.reports.sale')}}
                    @else
                        {{trans('POS/lang.reports.sale_return')}}
                    @endif

                </div>
                <div class="text-end">
                    <b>{{trans('lang.to')}}:</b> {{$to}}
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('lang.invoice_number')}}
                </th>
                <th>
                    {{trans('lang.branch')}}
                </th>
                <th>
                    {{trans('lang.contact')}}
                </th>
                <th>
                    {{trans('Inventory/lang.item.plural_label')}}
                </th>
                <th>
                    {{trans('lang.codes')}}
                </th>
                <th>
                    {{trans('lang.total')}}
                </th>
                <th>
                    {{trans('lang.paid_amount')}}
                </th>
                <th>
                    {{trans('lang.discount')}}
                </th>
                <th>
                    {{trans('lang.date')}}
                </th>
            </tr>
        @endslot
        @slot('tableContent')
            @foreach($data as $dt)
                <tr>
                    <td>
                        {{$dt->invoice_number}}
                    </td>
                    <td>
                        {{$dt->branch->name}}
                    </td>
                    <td>
                        {{$dt->contact->{'name_'.\Illuminate\Support\Facades\App::getLocale()} }}
                    </td>
                    <td>
                        {{number_format($dt->items_count)}}
                    </td>
                    <td>
                        {{number_format($dt->codes_count)}}
                    </td>
                    <td>
                        {{number_format($dt->total,$dt->currency->decimal)}} {{$dt->currency->symbol}}
                    </td>
                    <td>
                        {{number_format($dt->paid_amount,$dt->currency->decimal)}} {{$dt->currency->symbol}}
                    </td>
                    <td>
                        {{number_format($dt->discount)}} %
                    </td>
                    <td>
                        {{($dt->date)}}
                    </td>

                </tr>
            @endforeach
        @endslot
        @slot('tableFooter')
            <tr class="bg-primary-500 text-white">
                <th>
                    {{trans('lang.total')}}
                </th>
                <th colspan="2">

                </th>
                <th>
                    {{number_format($data->sum('items_count'))}}
                </th>
                <th>
                    {{number_format($data->sum('codes_count'))}}
                </th>
                <th colspan="2"></th>
                <th>
                    {{number_format($data->avg('discount'),2)}} %
                </th>
                <th></th>
            </tr>
            @foreach($currencies as $currency)
                <tr class="bg-primary-200">
                    <th>
                        {{$currency->name}}
                    </th>
                    <th colspan="4">

                    </th>

                    <th>
                        {{number_format($data->where('currency_id',$currency->id)->sum('total'),$currency->decimal)}} {{$currency->symbol}}
                    </th>
                    <th>
                        {{number_format($data->where('currency_id',$currency->id)->sum('paid_amount'),$currency->decimal)}} {{$currency->symbol}}
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
