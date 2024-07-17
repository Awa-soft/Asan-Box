<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid grid-cols-3 items-center p-2 rounded-md align-middle border ">
                <div>
                    {!! trans('lang.statement_date', ['from' => $hire_date_from, 'to' => $hire_date_to!='all'?$hire_date_to:now()->format('Y/m/d') ]) !!}
                </div>
                <div class="font-bold">
                    {{trans('HR/lang.reports.hrEmployees')}}
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
            @if(valueInArray('name',$attr))
                <th>
                    {{trans('lang.name')}}
                </th>
            @endif

                @if(valueInArray('phone',$attr))
                    <th>
                        {{trans('lang.phone')}}
                    </th>
                @endif
                @if(valueInArray('gender',$attr))
                    <th>
                        {{trans('lang.gender')}}
                    </th>
                @endif
                @if(valueInArray('nationality',$attr))
                    <th>
                        {{trans('lang.address')}}
                    </th>
                @endif
                @if(valueInArray('identity_number',$attr))
                    <th>
                        {{trans('lang.identity_number')}}
                    </th>
                @endif
                @if(valueInArray('hire_date',$attr))
                    <th>
                        {{trans('lang.dates')}}
                    </th>
                @endif
                @if(valueInArray('start_time',$attr))
                    <th>
                        {{trans('lang.work_time')}}
                    </th>
                @endif
                @if(valueInArray('salary',$attr))
                    <th>
                        {{trans('lang.salary')}}
                    </th>
                @endif
                @if(valueInArray('annual_leave',$attr))
                    <th>
                        {{trans('lang.annual_leave')}}
                    </th>
                @endif
                @if(valueInArray('overtime_amount',$attr))
                    <th>
                        {{trans('lang.overtime_amount')}}
                    </th>
                @endif
                @if(valueInArray('absence_amount',$attr))
                    <th>
                        {{trans('lang.absence_amount')}}
                    </th>
                @endif
                @if(valueInArray('team_id',$attr))
                    <th>
                        {{trans('lang.team')}}
                    </th>
                @endif
                @if(valueInArray('positions',$attr))
                    <th>
                        {{trans('lang.positions')}}
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
                            {{$dt->ownerable->name?? ''}}
                        </td>
                    @endif
                    @if(valueInArray('user',$attr))
                        <td>
                            {{$dt->user->name?? ''}}
                        </td>
                    @endif
                    @if(valueInArray('name',$attr))
                        <td>
                            {{$dt->name}}
                        </td>
                    @endif
                    @if(valueInArray('phone',$attr))
                        <td>
                            {{$dt->phone?? '' }}
                        </td>
                    @endif
                    @if(valueInArray('gender',$attr))
                        <td>
                            {{\App\Models\HR\Employee::getGenders()[$dt->gender]}}
                        </td>
                    @endif
                    @if(valueInArray('nationality',$attr))
                        <td>
                            {{trans('countries.'.$dt->nationality?? '')}} <br>
                            {{$dt->address?? ''}}
                        </td>
                    @endif

                    @if(valueInArray('identity_number',$attr))
                        <td>
                            {{$dt->identityType->name?? ''}}
                            <br>
                            {{$dt->identity_number?? ''}}
                        </td>
                    @endif
                    @if(valueInArray('hire_date',$attr))
                        <td>
                            {{$dt->hire_date}}
                            <br>
                            {{$dt->termination_date}}
                        </td>
                    @endif
                    @if(valueInArray('start_time',$attr))
                        <td>
                            {{$dt->start_time?? ''}} <br>
                            {{$dt->end_time?? '' }}
                        </td>
                    @endif
                    @if(valueInArray('salary',$attr))
                        <td>
                            {{number_format($dt->salary,$dt->currency->decimal) . $dt->currency->symbol}}
                            <br>
                            {{\App\Models\HR\Employee::getSalaryTypes()[$dt->salary_type]}}
                        </td>
                    @endif
                    @if(valueInArray('annual_leave',$attr))
                        <td>
                            {{number_format($dt->annual_leave,0)}}
                        </td>
                    @endif
                    @if(valueInArray('overtime_amount',$attr))
                        <td>
                            {{number_format($dt->overtime_amount,$dt->currency->decimal) . $dt->currency->symbol}}
                        </td>
                    @endif
                    @if(valueInArray('absence_amount',$attr))
                        <td>
                            {{number_format($dt->absence_amount,$dt->currency->decimal) . $dt->currency->symbol}}
                        </td>
                    @endif
                        @if(valueInArray('team_id',$attr))
                            <td>
                                @foreach($dt->team as $team)
                                    {{$team->name}} <br>
                                @endforeach
                            </td>
                        @endif
                        @if(valueInArray('positions',$attr))
                            <td>
                                @foreach($dt->positions as $position)
                                    {{$position->name}} <br>
                                @endforeach
                            </td>
                        @endif
                    @if(valueInArray('note',$attr))
                        <td>
                            {{trans('lang.note')}}
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
