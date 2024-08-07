<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">
                </div>
                <div class="font-bold text-center">
                    {{trans('Inventory/lang.reports.'.$type)}}
                </div>
                <div class="text-end">
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('lang.owner')}}
                </th>
                <th>
                    {{trans('lang.name')}}
                </th>
                <th>
                    {{trans('lang.status')}}
                </th>
                <th>
                    {{trans('Inventory/lang.item.plural_label')}}
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
                        {{$dt->name}}
                    </td>
                    <td>
                        @if($dt->status)
                            <span class="text-green-600">{{trans('lang.active')}}</span>
                        @else
                            <span class="text-red-600">{{trans('lang.inactive')}}</span>
                        @endif
                    </td>
                    <td>
                        {{$dt->items->count()}}
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
