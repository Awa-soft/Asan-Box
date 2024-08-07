<x-filament-panels::page>
    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid grid-cols-3 items-center p-2 rounded-md align-middle border ">
                <div>
                    {!! trans('lang.statement_date', ['from' => $from, 'to' => $to!='all'?$to:now()->format('Y/m/d') ]) !!}
                </div>
                <div class="font-bold">
                    {{trans('HR/lang.reports.hrEmployeesSummary')}}
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
            @if(valueInArray('name',$attr))
                <th>
                    {{trans('lang.name')}}
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
            @if(valueInArray('salary',$attr))
                <th>
                    {{trans('lang.salary')}}
                </th>
            @endif
            @if(valueInArray('leave',$attr))
                <th>
                    {{trans('lang.leaves')}}
                </th>
            @endif
            @if(valueInArray('absence',$attr))
                <th>
                    {{trans('lang.absence')}}
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
                    @if(valueInArray('name',$attr))
                        <td>
                            {{$dt->name}}
                        </td>
                    @endif
                        @if(valueInArray('punish',$attr))
                           <td>
                                {{number_format($dt->activities->where('type','punish')->sum('dollar_amount')?? 0,2)}} $
                           </td>
                        @endif
                        @if(valueInArray('bonus',$attr))
                           <td>
                               {{number_format($dt->activities->where('type','bonus')->sum('dollar_amount')?? 0,2)}} $
                           </td>
                        @endif
                        @if(valueInArray('overtime',$attr))
                           <td>
                               {{number_format($dt->activities->where('type','overtime')->sum('dollar_amount')?? 0,2)}} $
                           </td>
                        @endif
                        @if(valueInArray('advance',$attr))
                           <td>
                               {{number_format($dt->activities->where('type','advance')->sum('dollar_amount')?? 0,2)}} $
                           </td>
                        @endif
                        @if(valueInArray('salary',$attr))
                           <td>
                               {{number_format($dt->salaries->sum('dollar_amount')?? 0,2)}} $
                           </td>
                        @endif
                        @if(valueInArray('leave',$attr))
                           <td>
                               {{number_format($dt->leaves->where('status','approved')->sum('leave_days')?? 0)}}
                           </td>
                        @endif
                        @if(valueInArray('absence',$attr))
                           <td>
                               {{number_format($dt->activities->where('type','absence')->sum('dollar_amount')?? 0,2)}} $
                           </td>
                        @endif

                </tr>
            @endforeach
        @endslot
        @slot('tableFooter')
        <tr>
            <th>
            </th>
        </tr>
        @endslot
        @slot('pageFooter')

        @endslot
    </x-core.report-content>

</x-filament-panels::page>
