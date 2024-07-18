<x-filament-panels::page>
    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid grid-cols-3 items-center p-2 rounded-md align-middle border ">
                <div>
                    {!! trans('lang.statement_date', ['from' => $from, 'to' => $to!='all'?$to:now()->format('Y/m/d') ]) !!}
                </div>
                <div class="font-bold">
                    {{trans('HR/lang.reports.hrEmployeesSalary')}}
                </div>
                <div>
                </div>
            </div>
        @endslot
        @slot('tableHeader')
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
                @if(valueInArray('employee',$attr))
                    <th>
                        {{trans('lang.employee')}}
                    </th>
                @endif
            @if(valueInArray('punish',$attr))
                <th>
                    {{trans('lang.punish')}}
                </th>
            @endif
            @if(valueInArray('bonus',$attr))
                <th>
                    {{trans('lang.bonus')}}
                </th>
            @endif
            @if(valueInArray('overtime',$attr))
                <th>
                    {{trans('lang.overtime')}}
                </th>
            @endif
            @if(valueInArray('advance',$attr))
                <th>
                    {{trans('lang.advance')}}
                </th>
            @endif
            @if(valueInArray('leave',$attr))
                <th>
                    {{trans('lang.leaves')}}
                </th>
            @endif
            @if(valueInArray('work_average',$attr))
                <th>
                    {{trans('lang.work_average')}}
                </th>
            @endif
                @if(valueInArray('amount',$attr))
                    <th>
                        {{trans('lang.amount')}}
                    </th>
                @endif
                @if(valueInArray('payment_amount',$attr))
                    <th>
                        {{trans('lang.payment_amount')}}
                    </th>
                @endif


        @endslot
        @slot('tableContent')
            @foreach($data as $dt)
                <tr>
                    @if(valueInArray('owner',$attr))
                        <td>
                            {{$dt->ownerable->name?? ''}}
                        </td>
                    @endif
                        @if(valueInArray('user',$attr))
                            <td>
                                {{$dt->user->name?? ''}}
                            </td>
                        @endif
                    @if(valueInArray('employee',$attr))
                        <td>
                            {{$dt->employee->name}}
                        </td>
                    @endif
                    @if(valueInArray('punish',$attr))
                        <td>
                            {{number_format($dt->activities->where('type','punish')->sum('amount')?? 0,$dt->currency->decimal) . $dt->currency->symbol}}
                        </td>
                    @endif
                    @if(valueInArray('bonus',$attr))
                        <td>
                            {{number_format($dt->activities->where('type','bonus')->sum('amount')?? 0,$dt->currency->decimal) . $dt->currency->symbol}}
                        </td>
                    @endif
                    @if(valueInArray('overtime',$attr))
                        <td>
                            {{number_format($dt->activities->where('type','overtime')->sum('amount')?? 0,$dt->currency->decimal) . $dt->currency->symbol}}
                        </td>
                    @endif
                    @if(valueInArray('advance',$attr))
                        <td>
                            {{number_format($dt->activities->where('type','advance')->sum('amount')?? 0,$dt->currency->decimal) . $dt->currency->symbol}}
                        </td>
                    @endif
                    @if(valueInArray('work_average',$attr))
                        <td>
                            {{number_format($dt->work_average)}}
                        </td>
                    @endif
                        @if(valueInArray('amount',$attr))
                            <td>
                                {{number_format($dt->amount?? 0,$dt->currency->decimal) . $dt->currency->symbol}}
                            </td>
                        @endif
                        @if(valueInArray('payment_amount',$attr))
                            <td>
                                {{number_format($dt->payment_amount?? 0,$dt->currency->decimal) . $dt->currency->symbol}}
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
