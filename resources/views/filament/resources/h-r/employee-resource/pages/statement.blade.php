<x-filament-panels::page>
    <link rel="stylesheet" href="{{asset('assets/css/core/print.css')}}">


    <section class="sheet A4 ">
    <div class="mx-auto bg-white ">
        <table class="w-full">
            <thead>
            <td>
                @if($employee->ownerable_type == 'App\Models\Logistic\Branch')
                    {{$employee->ownerable->name }}
                @else
                    {{\App\Models\Logistic\Branch::find(1)?->name}}
                @endif
            </td>
            </thead>
            <tbody>
            <tr>
                <td>
                    @if(in_array('salary',$activity) || in_array('all',$activity))
                        <div class="p-2 mt-4 font-bold text-center text-white rounded-sm bg-primary-600">
                            {{trans('HR/lang.employee_salary.plural_label')}}
                        </div>
                        <table class="w-full">
                            <thead class="text-[10pt] border">
                            <th class="border">
                                {{trans('lang.amount')}}
                            </th>
                            <th class="border">
                                {{trans('lang.payment_amount')}}
                            </th>
                            <th class="border">
                                {{trans('lang.salary_date')}}
                            </th>
                            <th class="border">
                                {{trans('lang.payment_date')}}
                            </th>
                            <th class="py-2 border">
                                {{trans('lang.note')}}
                            </th>
                            </thead>
                            <tbody class="text-center text-[9pt]">
                            @foreach($employee->salaries as $salary)
                                <tr class="border odd:bg-gray-50">
                                    <td class="py-2 border">
                                        {{ number_format($salary->amount,$salary->currency->decimal) .' '.  $salary->currency->symbol }}
                                    </td>
                                    <td class="py-2 border">
                                        {{ number_format($salary->payment_amount,$salary->currency->decimal) .' '. $salary->currency->symbol }}
                                    </td>
                                    <td class="border">
                                        {{ $salary->salary_date }}
                                    </td>
                                    <td class="border">
                                        {{ $salary->payment_date }}
                                    </td>
                                    <td class="border">
                                        {{ $salary->note }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if(in_array('leaves',$activity) || in_array('all',$activity))
                        <div class="p-2 mt-4 font-bold text-center text-white rounded-sm bg-primary-600">
                            {{trans('HR/lang.employee_leave.plural_label')}}
                        </div>
                        <table class="w-full">
                            <thead class="text-[10pt] border">
                            <th class="border">
                                {{trans('lang.from')}}
                            </th>
                            <th class="border">
                                {{trans('lang.to')}}
                            </th>
                            <th class="border">
                                {{trans('lang.status')}}
                            </th>
                            <th class="py-2 border">
                                {{trans('lang.note')}}
                            </th>
                            </thead>
                            <tbody class="text-center text-[9pt]">
                            @foreach($employee->leaves as $leave)
                                <tr class="border odd:bg-gray-50">
                                    <td class="border">
                                        {{ \Carbon\Carbon::parse($leave->from)->format('Y/m/d - H:i:s') }}
                                    </td>
                                    <td class="border">
                                        {{ \Carbon\Carbon::parse($leave->to)->format('Y/m/d - H:i:s') }}
                                    </td>
                                    <td class="border">
                                        {{ \App\Models\HR\EmployeeLeave::getStatus()[$leave->status] }}
                                    </td>
                                    <td class="py-2 border">
                                        {{ $leave->note }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if(in_array('bonus',$activity)||in_array('punish',$activity) ||in_array('overtime',$activity) ||in_array('absence',$activity) ||in_array('advance',$activity) || in_array('all',$activity))
                        <div class="p-2 mt-4 font-bold text-center text-white rounded-sm bg-primary-600">
                            {{trans('HR/lang.employee_activity.plural_label')}}
                        </div>
                        <table class="w-full">
                            <thead class="text-[10pt] border">
                            <th class="border">
                                {{trans('lang.type')}}
                            </th>
                            <th class="border">
                                {{trans('lang.amount')}}
                            </th>
                            <th class="border">
                                {{trans('lang.date')}}
                            </th>
                            <th class="py-2 border">
                                {{trans('lang.note')}}
                            </th>
                            </thead>
                            <tbody class="text-center text-[9pt]">
                            @foreach($employee->activities as $activity_record)
                                <tr class="border odd:bg-gray-50">
                                    <td class="py-2 border">
                                        {{ \App\Models\HR\EmployeeActivity::getTypes()[$activity_record->type]  }}
                                    </td>
                                    <td class="py-1 border">
                                        {{ number_format($activity_record->amount,$activity_record->currency->decimal) .' '. $activity_record->currency->symbol }}
                                    </td>
                                    <td class="border">
                                        {{ \Carbon\Carbon::parse($activity_record->date)->format('Y/m/d') }}
                                    </td>
                                    <td class="border">
                                        {{ $activity_record->note }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if(in_array('notes',$activity) || in_array('all',$activity))
                        <div class="p-2 mt-4 font-bold text-center text-white rounded-sm bg-primary-600">
                            {{trans('HR/lang.employee_note.plural_label')}}
                        </div>
                        <table class="w-full">
                            <thead class="text-[10pt] border">
                            <th class="border">
                                {{trans('lang.date')}}
                            </th>
                            <th class="py-2 border">
                                {{trans('lang.note')}}
                            </th>
                            </thead>
                            <tbody class="text-center text-[9pt]">
                            @foreach($employee->leaves as $leave)
                                <tr class="border odd:bg-gray-50">
                                    <td class="border">
                                        {{ \Carbon\Carbon::parse($leave->date)->format('Y/m/d') }}
                                    </td>
                                    <td class="py-2 border">
                                        {{ $leave->note }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    @if($employee->ownerable_type == 'App\Models\Logistic\Branch')
                        {{$employee->ownerable->name }}
                    @else
                        {{\App\Models\Logistic\Branch::find(1)?->name}}
                    @endif
                </td>
            </tr>
            </tfoot>
        </table>

    </div>
    </section>
</x-filament-panels::page>
