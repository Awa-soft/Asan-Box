<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid grid-cols-3 items-center p-2 rounded-md align-middle border ">
                <div>
                    {!! trans('lang.statement_date', ['from' => $from, 'to' => $to!='all'?$to:now()->format('Y/m/d') ]) !!}
                </div>
                <div class="font-bold">
                    {{trans('HR/lang.reports.hrEmployeeLeave')}}
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
            @if(valueInArray('employee.name',$attr))
                <th>
                    {{trans('lang.employee')}}
                </th>
            @endif
            @if(valueInArray('status',$attr))
                <th>
                    {{trans('lang.status')}}
                </th>
            @endif
            @if(valueInArray('from',$attr))
                <th>
                    {{trans('lang.from')}}
                </th>
            @endif
            @if(valueInArray('to',$attr))
                <th>
                    {{trans('lang.to')}}
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
                    @if(valueInArray('status',$attr))
                        <td>
                            {{\App\Models\HR\EmployeeLeave::getStatus()[$dt->status]}}
                        </td>
                    @endif
                    @if(valueInArray('from',$attr))
                        <td>
                            {{\Carbon\Carbon::parse($dt->from)->format('Y-m-d ')}} <br>
                            {{\Carbon\Carbon::parse($dt->from)->format('H:i')}}
                        </td>
                    @endif
                    @if(valueInArray('to',$attr))
                        <td>
                            {{\Carbon\Carbon::parse($dt->to)->format('Y-m-d ')}} <br>
                            {{\Carbon\Carbon::parse($dt->to)->format('H:i')}}
                        </td>
                    @endif
                    @if(valueInArray('date',$attr))
                        <td>
                            {{\Carbon\Carbon::parse($dt->created_at)->format('Y-m-d')}}
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
