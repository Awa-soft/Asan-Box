<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">
                    <b>{{trans('lang.from')}}:</b> {{$from}}
                </div>
                <div class="font-bold text-center">
                    @if($type == 'purchase')
                        {{trans('POS/lang.reports.purchase_expenses')}}
                    @else
                        {{trans('POS/lang.reports.purchase_return_expenses')}}
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
                    {{trans('lang.date')}}
                </th>
            </tr>
        @endslot
        @slot('tableContent')
            @foreach($data as $key => $dt)
                @if($dt->expenses->count()>0)
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
                                {{$dt->date}}
                            </td>
                        </tr>
                    <tr style="background: rgb(var(--primary-300))">
                        <td>
                            {{trans('lang.title')}}
                        </td>
                        <td>
                            {{trans('lang.amount')}}
                        </td>
                        <td>
                            {{trans('lang.note')}}
                        </td>
                        <td>
                            {{trans('lang.date')}}
                        </td>
                    </tr>
                        @foreach($dt->expenses as $exp)
                            <tr>
                                <td>
                                    {{$exp->title}}
                                </td>
                                <td>
                                    {{number_format($exp->amount,$exp->currency->decimal) . ' ' . $exp->currency->symbol}}
                                </td>
                                <td>
                                    {{$exp->note}}
                                </td>
                                <td>
                                    {{$exp->created_at->format('Y-m-d')}}
                                </td>
                            </tr>
                        @endforeach
                    @foreach($currencies as $currency)
                        @if($dt->expenses->where('currency_id',$currency->id)->sum('amount') > 0)
                                <tr style="background: rgb(var(--primary-300))">
                                    <td>
                                        {{trans('lang.total')}}  {{strtoupper($currency->name)}}
                                    </td>
                                    <td>
                                        {{number_format($dt->expenses->where('currency_id',$currency->id)->sum('amount'),$currency->decimal) .' '. $currency->symbol}}
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                        @endif
                    @endforeach
                @endif
                <tr>
                    <td colspan="4" style="padding: 10px;background: white;border: none"></td>
                </tr>
            @endforeach


        @endslot
        @slot('tableFooter')


        @endslot
        @slot('pageFooter')

        @endslot
    </x-core.report-content>

</x-filament-panels::page>
