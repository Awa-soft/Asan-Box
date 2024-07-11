<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">
                    <b>{{trans('lang.from')}}:</b> {{$from}}
                </div>
                <div class="font-bold text-center">
                    {{trans('Logistic/lang.reports.itemTransactions')}}
                </div>
                <div class="text-end">
                    <b>{{trans('lang.to')}}:</b> {{$to}}
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('lang.from')}}
                </th>
                <th>
                    {{trans('lang.to')}}
                </th>
                <th>
                    {{trans('lang.user')}}
                </th>
                <th>
                    {{trans('lang.date')}}
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
                            {{trans('lang.from')}}
                        </th>
                        <th class="bg-primary-500 text-white">
                            {{trans('lang.to')}}
                        </th>
                        <th class="bg-primary-500 text-white">
                            {{trans('lang.user')}}
                        </th>
                        <th class="bg-primary-500 text-white">
                            {{trans('lang.date')}}
                        </th>
                    </tr>
                @endif
                <tr>
                    <th>
                        {{$dt->fromable->name}}
                    </th>
                    <th>
                        {{$dt->toable->name}}
                    </th>
                    <th>
                        {{$dt->user->name}}
                    </th>
                    <th>
                        {{$dt->created_at->format('Y-m-d')}}
                    </th>
                </tr>

            @foreach($dt->details as $key => $detail)
                    <tr   style="background: rgb(var(--primary-200))">
                        <th>
                            {{trans('lang.name')}}
                        </th>
                        <th>
                            {{trans('lang.barcode')}}
                        </th>
                        <th style="background: rgb(var(--primary-200))">
                            {{trans('lang.code')}}
                        </th>
                        <th style="background: rgb(var(--primary-200))">
                            {{trans('lang.status')}}
                        </th>
                    </tr>
                <tr>
                    <td>
                        {{$detail->item->name}}
                    </td>
                    <td>
                        {{$detail->item->barcode}}
                    </td>
                        @foreach($detail->codes as $key => $code)
                            @if($key == 0)
                                    <td>
                                        {{ $code->code }}
                                    </td>
                                    <td>
                                        @if($code->status != 'pending')
                                            {{trans("lang.{$code->status}")}} <small>({{$code->user->name}})</small>
                                        @else
                                            {{trans("lang.{$code->status}")}}
                                        @endif
                                    </td>
                                @else
                                    @break
                            @endif
                    @endforeach
                </tr>
                @foreach($detail->codes as $key => $code)
                    @if($key >0)
                                <tr>
                                    <td colspan="2"></td>
                                    <td>
                                        {{ $code->code }}
                                    </td>
                                    <td>
                                        @if($code->status != 'pending')
                                            {{trans("lang.{$code->status}")}} <small>({{$code->user->name}})</small>
                                        @else
                                            {{trans("lang.{$code->status}")}}
                                        @endif
                                    </td>
                                </tr>
                    @endif
                @endforeach
            @endforeach
            @endforeach
        @endslot
        @slot('tableFooter')

        @endslot
        @slot('pageFooter')

        @endslot
    </x-core.report-content>

</x-filament-panels::page>
