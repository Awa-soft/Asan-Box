<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">
                    <b>{{trans('lang.from')}}:</b> {{$from}}
                </div>
                <div class="font-bold text-center">
                    {{trans('Inventory/lang.reports.items')}}
                </div>
                <div class="text-end">
                    <b>{{trans('lang.to')}}:</b> {{$to}}
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('lang.name')}}
                </th>
                <th>
                    {{trans('lang.category')}}
                </th>
                <th>
                    {{trans('lang.brand')}}
                </th>
                <th>
                    {{trans('lang.unit')}}
                </th>
                <th>
                    {{trans('lang.price')}}
                </th>
                <th>
                    {{trans('lang.installment')}}
                </th>
                <th>
                    {{trans('lang.discount')}}
                </th>
                <th>
                    {{trans('lang.expire_date')}}
                </th>
            </tr>
        @endslot
        @slot('tableContent')
            @foreach($data as $dt)
                <tr>
                    <td>
                        {{$dt->{'name_'.\Illuminate\Support\Facades\App::getLocale()} }}
                    </td>
                    <td>
                        {{$dt->category->name }}
                    </td>
                    <td>
                        {{$dt->brand->name}}
                    </td>
                    <td>
                        {{$dt->unit->name}}
                    </td>
                    <td>
                        {{$dt->min_price}} $ <br>
                        {{$dt->max_price}} $
                    </td>
                    <td>
                        {{$dt->installment_min}} $ <br>
                        {{$dt->installment_max}} $
                    </td>
                    <td>
                        {{$dt->discount}} %
                    </td>
                    <td>
                        {{$dt->expire_date}}
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
