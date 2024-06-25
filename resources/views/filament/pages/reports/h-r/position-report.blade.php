<x-filament-panels::page>

    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid grid-cols-3 items-center p-2 rounded-md align-middle border ">

                <div class="font-bold col-start-2">
                    {{trans('HR/lang.reports.positions')}}
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
            @if(valueInArray('employees',$attr))
                <th>
                    {{trans('lang.employees')}}
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
                    @if(valueInArray('name',$attr))
                        <td>
                            {{$dt->name??''}}
                        </td>
                    @endif
                    @if(valueInArray('employees',$attr))
                        <td>
                            {{$dt->employees->count()??''}}
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
