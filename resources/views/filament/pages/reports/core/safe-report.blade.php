<x-filament-panels::page>
    {{ $this->SafeForm }}
    <div class="grid grid-cols-4 gap-5">
        @foreach ($currencies as $currency)
            <livewire:core.currency-overview :symbol="$currency->symbol" :name="$currency->name" :amount="$currency->amount" />
        @endforeach
    </div>
    <x-core.report-content>
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div>
                    {!! trans('lang.statement_date', ['from' => $from, 'to' => $to != 'all' ? $to : now()->format('Y/m/d')]) !!}
                </div>
                <div class="font-bold">
                    {{ trans('HR/lang.reports.activity') }}
                </div>
            </div>
        @endslot
        @slot('tableHeader')
        <th>
            #
        </th>
        <th>
            {{ trans('lang.owner') }}
        </th>
        <th>
            {{ trans('lang.user') }}
        </th>
        <th>
            {{ trans('lang.employee') }}
        </th>
        <th>
            {{ trans('lang.type') }}
        </th>
        <th>
            {{ trans('lang.amount') }}
        </th>
        <th>
            {{ trans('lang.currency_rate') }}
        </th>
        <th>
            {{ trans('lang.date') }}
        </th>
        <th>
            {{ trans('lang.note') }}
        </th>
    @endslot
    @slot('tableContent')
        <tr>
            <td>
                1
            </td>
            <td>
                sfhsfhsfhsf
            </td>
            <td>
                gjdjdgjdgj
            </td>
            <td>
                dgjdgjdgjgdj
            </td>

            <td>
                sfhsfh
            </td>

            <td>
                sfhsfh
            </td>


            <td>
                sfhsfhsfh
            </td>

            <td>
                sfhsfhsfh
            </td>
            <td>
                sfhsfh
            </td>
        </tr>
    @endslot
    @slot('tableFooter')

    @endslot
    @slot('pageFooter')

    @endslot
</x-core.report-content>
</x-filament-panels::page>
