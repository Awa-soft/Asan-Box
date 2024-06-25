<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css', 'resources/js/app.js', 'resources/css/filament/admin/theme.css')
</head>

<body>
    <div class="mx-auto relative text-black bg-white w-[210mm] min-h-[297mm]">

        @php
            $imagePath = asset("storage/01J14R11T9C4K7J5XQ66H98HQX.png");
        @endphp
        <p class="w-full">{{ $imagePath }}</p>
        <table class="w-full">
            <thead>
                <th class="pb-4" style="border-width: 0">
                    <img src="{{ $imagePath }}" style="width: 100%;">
                </th>
            </thead>
            <tbody>

                <tr class="tableContent">
                    <td style="border-width: 0">
                        <div class="px-4">
                            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                                <div>
                                    {!! trans('lang.statement_date', ['from' => $from, 'to' => $to != 'all' ? $to : now()->format('Y/m/d')]) !!}
                                </div>
                                <div class="font-bold">
                                    {{ trans('HR/lang.reports.activity') }}
                                </div>
                                <div>
                                </div>
                            </div>
                            <table class="w-full my-4">
                                <thead class="text-white border bg-primary-500">
                                    @if (valueInArray('invoice_number', $attr))
                                        <th>
                                            #
                                        </th>
                                    @endif
                                    @if (valueInArray('owner', $attr))
                                        <th>
                                            {{ trans('lang.owner') }}
                                        </th>
                                    @endif
                                    @if (valueInArray('user', $attr))
                                        <th>
                                            {{ trans('lang.user') }}
                                        </th>
                                    @endif
                                    @if (valueInArray('employee.name', $attr))
                                        <th>
                                            {{ trans('lang.employee') }}
                                        </th>
                                    @endif
                                    @if (valueInArray('type', $attr))
                                        <th>
                                            {{ trans('lang.type') }}
                                        </th>
                                    @endif
                                    @if (valueInArray('amount', $attr))
                                        <th>
                                            {{ trans('lang.amount') }}
                                        </th>
                                    @endif
                                    @if (valueInArray('currency_rate', $attr))
                                        <th>
                                            {{ trans('lang.currency_rate') }}
                                        </th>
                                    @endif
                                    @if (valueInArray('date', $attr))
                                        <th>
                                            {{ trans('lang.date') }}
                                        </th>
                                    @endif
                                    @if (valueInArray('note', $attr))
                                        <th>
                                            {{ trans('lang.note') }}
                                        </th>
                                    @endif
                                </thead>
                                <tbody>
                                    @foreach ($data as $dt)
                                        <tr>
                                            @if (valueInArray('invoice_number', $attr))
                                                <td>
                                                    {{ $dt->id }}
                                                </td>
                                            @endif
                                            @if (valueInArray('owner', $attr))
                                                <td>
                                                    {{ $dt->ownerable->name ?? '' }}
                                                </td>
                                            @endif
                                            @if (valueInArray('user', $attr))
                                                <td>
                                                    {{ $dt->user->name ?? '' }}
                                                </td>
                                            @endif
                                            @if (valueInArray('employee.name', $attr))
                                                <td>
                                                    {{ $dt->employee->name ?? '' }}
                                                </td>
                                            @endif
                                            @if (valueInArray('type', $attr))
                                                <td>
                                                    {{ \App\Models\HR\EmployeeActivity::getTypes()[$dt->type] }}
                                                </td>
                                            @endif
                                            @if (valueInArray('amount', $attr))
                                                <td>
                                                    {{ number_format($dt->amount, $dt->currency->decimal) . ' ' . $dt->currency->symbol }}
                                                </td>
                                            @endif
                                            @if (valueInArray('currency_rate', $attr))
                                                <td>
                                                    {{ number_format($dt->currency_rdate ?? 0, 2) }}
                                                </td>
                                            @endif
                                            @if (valueInArray('date', $attr))
                                                <td>
                                                    {{ $dt->date }}
                                                </td>
                                            @endif
                                            @if (valueInArray('note', $attr))
                                                <td>
                                                    {{ $dt->note }}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                {{-- <th class="pt-4" style="border-width: 0">
                    <img class="w-full opacity-0"
                        src="{{ asset('storage/' . (auth()->user()?->ownerable?->receipt_footer != null ? auth()->user()?->ownerable?->receipt_footer : \App\Models\Logistic\Branch::find(1)?->receipt_footer)) }}">
                </th> --}}
            </tfoot>
        </table>
        {{-- <img class="fixed bottom-0 left-0 w-full opacity-0 print:opacity-100"
            src="{{ asset('storage/' . (auth()->user()?->ownerable?->receipt_footer != null ? auth()->user()?->ownerable?->receipt_footer : \App\Models\Logistic\Branch::find(1)?->receipt_footer)) }}"> --}}
    </div>
</body>

</html>
