<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-1 p-2 align-middle border rounded-md ">
                <div class="font-bold text-center">
                    {{trans('Logistic/lang.reports.warehouse')}}
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('lang.name')}}
                </th>
                <th>
                    {{trans('phone')}}
                </th>
            </tr>
        @endslot
        @slot('tableContent')
            @foreach($data as $key=>$dt)
                @if($key > 0)
                    <tr>
                        <td  colspan="2" style="padding-bottom: 60px; background: white;border: none"></td>
                    </tr>
                    <tr>
                        <th class="bg-primary-500 text-white">
                            {{trans('lang.name')}}
                        </th>
                        <th class="bg-primary-500 text-white">
                            {{trans('phone')}}
                        </th>
                    </tr>
                @endif
                <tr>
                    <th>
                        {{$dt->name}}
                    </th>
                    <th>
                        {{$dt->phone}}
                    </th>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: justify;padding: 10px 30px">
                        <b>{{trans('lang.address')}}</b> : {{$dt->address}}
                    </th>
                </tr>
                @if(valueInArray('items',$attr))
                    <tr>
                        <th class="bg-primary-300 " colspan="2">
                            {{trans('Inventory/lang.item.plural_label')}}
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div>
                                <table class="w-full">
                                    <thead>
                                    <th>
                                        {{trans('lang.name')}}
                                    </th>
                                    <th>
                                        {{trans('lang.brand')}}
                                    </th>
                                    <th>
                                        {{trans('lang.barcode')}}
                                    </th>
                                    <th>
                                        {{trans('lang.category')}}
                                    </th>
                                    <th>
                                        {{trans('lang.quantity')}}
                                    </th>
                                    </thead>
                                    <tbody>
                                    @foreach($dt->items as $item)
                                        <tr>
                                            <td>
                                                {{$item->name}}
                                            </td>
                                            <td>
                                                {{$item->brand->name}}
                                            </td>
                                            <td>
                                                {{$item->barcode}}
                                            </td>
                                            <td>
                                                {{$item->category->name}}
                                            </td>
                                            <td>
                                                {{\App\Models\Logistic\Warehouse::hasItem($item->id,$dt->id)}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>

                @endif
            @endforeach
        @endslot
        @slot('tableFooter')

        @endslot
        @slot('pageFooter')

        @endslot
    </x-core.report-content>

</x-filament-panels::page>
