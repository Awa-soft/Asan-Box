<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">
                    <b>{{trans('lang.from')}}:</b> {{$from}}
                </div>
                <div class="font-bold text-center">
                    @if($type == 'sale')
                        {{trans('POS/lang.reports.sale_codes')}}
                    @else
                        {{trans('POS/lang.reports.sale'.ucfirst($type).'Codes')}}
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
                    {{trans('lang.item')}}
                </th>
                <th>
                    {{trans('lang.code')}}
                </th>
                <th>
                    {{trans('lang.type')}}
                </th>
                <th>
                    {{trans('lang.price')}}
                </th>
                <th>
                    {{trans('lang.date')}}
                </th>
            </tr>
        @endslot
        @slot('tableContent')

            @foreach($data as $key => $dt)
                @if($dt->codes->count()>0)
                    @foreach($dt->codes as $code)
                        <tr>
                            <td>
                                {{$dt->invoice->invoice_number}}
                            </td>
                            <td>
                                {{$dt->invoice->branch->name}}
                            </td>
                            <td>
                                {{$dt->invoice->contact->{'name_'.\Illuminate\Support\Facades\App::getLocale()} }}
                            </td>
                            <td>
                                {{$dt->item->{'name_'.\Illuminate\Support\Facades\App::getLocale()} }}
                            </td>
                            <td>
                                {{$code->code}}
                            </td>
                            <td>
                                @if($code->gift)
                                    {{trans('lang.gift')}}
                                @else
                                    {{trans('lang.cost')}}
                                @endif
                            </td>
                            <td>
                                {{number_format($dt->price,$dt->invoice->currency->decimal)}} {{$dt->invoice->currency->symbol}}
                            </td>
                            <td>
                                {{$dt->invoice->date}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach


        @endslot
        @slot('tableFooter')

            <tr class="bg-primary-900 text-white">
                <th>
                    {{trans('lang.total')}}
                </th>
                <th colspan="3">

                </th>

                <th>
                    {{number_format($data->sum('codes_count'))}}
                </th>
                <th colspan="3"></th>

            </tr>
            @foreach($currencies as $currency)
                <tr class="bg-primary-300">
                    <th>
                        {{$currency->name}}
                    </th>
                    <th colspan="5">

                    </th>

                    <th>
                        {{number_format(\App\Models\POS\SaleDetail::whereHas('invoice',function ($query)use($currency){
                              $query->where('currency_id', $currency->id);
                          })->whereIn('id',$data->pluck('id'))
                      ->get()->sum('total'),$currency->decimal)}} {{$currency->symbol}}
                    </th>
                    <th></th>

                </tr>
            @endforeach
        @endslot
        @slot('pageFooter')

        @endslot
    </x-core.report-content>

</x-filament-panels::page>
