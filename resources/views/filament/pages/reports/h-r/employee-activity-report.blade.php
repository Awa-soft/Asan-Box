<x-filament-panels::page>

<x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
        <div class="grid grid-cols-3 items-center p-2 rounded-md align-middle border ">
                    <div>
                        {!! trans('lang.statement_date', ['from' => $from, 'to' => $to!='all'?$to:now()->format('Y/m/d') ]) !!}
                    </div>
                <div class="font-bold">
                    {{trans('HR/lang.reports.activity')}}
                </div>
            <div>
            </div>
        </div>
        @endslot
        @slot('tableHeader')
            @if(valueInArray('invoice_number',$attr))
                    <th>
                        #
                    </th>
            @endif
                @if(valueInArray('owner',$attr))
                    <th>
                        {{trans('lang.owner')}}
                    </th>
                @endif
                @if(valueInArray('user',$attr))
                    <th>
                        {{trans('lang.user')}}
                    </th>
                @endif
                @if(valueInArray('employee.name',$attr))
                    <th>
                        {{trans('lang.employee')}}
                    </th>
                @endif
                @if(valueInArray('type',$attr))
                    <th>
                        {{trans('lang.type')}}
                    </th>
                @endif
                @if(valueInArray('amount',$attr))
                    <th>
                        {{trans('lang.amount')}}
                    </th>
                @endif
                @if(valueInArray('currency_rate',$attr))
                    <th>
                        {{trans('lang.currency_rate')}}
                    </th>
                @endif
                @if(valueInArray('date',$attr))
                    <th>
                        {{trans('lang.date')}}
                    </th>
                @endif
                @if(valueInArray('note',$attr))
                    <th>
                        {{trans('lang.note')}}
                    </th>
                @endif
        @endslot
        @slot('tableContent')
            @foreach($data as $dt)
                <tr>





                        @if(valueInArray('invoice_number',$attr))
                        <td>
                        {{$dt->id}}
                    </td>
                        @endif
                        @if(valueInArray('owner',$attr))
                        <td>
                        {{$dt->ownerable->name??''}}
                    </td>
                        @endif
                        @if(valueInArray('user',$attr))
                        <td>
                        {{$dt->user->name??''}}
                    </td>
                        @endif
                        @if(valueInArray('employee.name',$attr))

                        <td>
                        {{$dt->employee->name??''}}
                    </td>
                        @endif
                        @if(valueInArray('type',$attr))
                        <td>
                        {{\App\Models\HR\EmployeeActivity::getTypes()[$dt->type]}}
                    </td>
                        @endif
                        @if(valueInArray('amount',$attr))

                        <td>
                        {{number_format($dt->amount,$dt->currency->decimal) . ' ' . $dt->currency->symbol}}
                    </td>
                        @endif
                        @if(valueInArray('currency_rate',$attr))

                        <td>
                        {{number_format($dt->currency_rdate??0,2)}}
                    </td>
                        @endif
                            @if(valueInArray('date',$attr))
                            <td>
                        {{$dt->date}}
                    </td>
                        @endif
                            @if(valueInArray('note',$attr))

                            <td>
                        {{$dt->note}}
                    </td>
                    @endif
                </tr>
            @endforeach
        @endslot
        @slot('tableFooter')

        @endslot
        @slot('pageFooter')

        @endslot
</x-core.report-content>

</x-filament-panels::page>
