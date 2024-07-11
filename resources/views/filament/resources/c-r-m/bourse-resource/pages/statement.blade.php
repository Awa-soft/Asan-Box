<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('assets/css/core/print.css') }}">


    <section class="sheet A4 ">
        <div class="mx-auto bg-white ">
            <table class="w-full">
                <thead>
                <td>
                    @if (auth()->user()->ownerable_type == 'App\Models\Logistic\Branch')
                        <img src="/storage/{{ auth()->user()->ownerable->receipt_header }}" alt="">
                    @else
                        <img src="/storage/{{ \App\Models\Logistic\Branch::find(1)->receipt_header }}" alt="">
                    @endif
                </td>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="p-2 mt-4 font-bold text-center text-white rounded-sm bg-primary-600">
                            {!!   trans('lang.statement', ['name' => $bourse->name]) !!}
                        </div>
                        <table class="w-full">
                            <thead class="text-[10pt] border">
                            <th class="border">
                                {{ trans('lang.invoice_number') }}
                            </th>
                            <th class="border">
                                {{ trans('lang.user') }}
                            </th>

                            <th class="border">
                                {{ trans('lang.branch') }}
                            </th>
                            <th class="border">
                                {{ trans('lang.type') }}
                            </th>
                            <th class="border">
                                {{ trans('lang.date') }}
                            </th>
                            <th class="border">
                                {{ trans('lang.amount') }}
                            </th>
                            <th class="border">
                                {{ trans('lang.balance') }}
                            </th>
                            <th class="py-2 border">
                                {{ trans('lang.note') }}
                            </th>
                            </thead>
                            <tbody class="text-center text-[9pt]">
                            @foreach ($bourse->boursePayment as $d)
                                <tr class="border odd:bg-gray-50">
                                    <td class="py-2 border">
                                        {{ $d['invoice_number'] }}
                                    </td>
                                    <td class="py-2 border">
                                        {{ $d['user']['name'] }}
                                    </td>
                                    <td class="py-2 border">
                                        {{ $d['branch']['name'] }}
                                    </td>
                                    <td class="py-2 border">
                                        {{ trans("lang.$d[type]") }}
                                    </td>
                                    <td class="py-2 border">
                                        {{ $d['date'] }}
                                    </td>
                                    <td class="py-1 border">
                                        {{ number_format($d['amount'], $d['currency']['decimal']) . ' ' . $d['currency']['symbol'] }}
                                    </td>
                                    <td class="border">
                                        {{ number_format($d['balance'], $d['currency']['decimal']) . ' ' . $d['currency']['symbol'] }}
                                    </td>
                                    <td class="border">
                                        {{ $d['note'] }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td>
                        @if (auth()->user()->ownerable_type == 'App\Models\Logistic\Branch')
                            <img src="/storage/{{ auth()->user()->ownerable->receipt_footer }}" alt="">
                        @else
                            <img src="/storage/{{ \App\Models\Logistic\Branch::find(1)->receipt_footer }}"
                                 alt="">
                        @endif
                    </td>
                </tr>
                </tfoot>
            </table>

        </div>
    </section>
</x-filament-panels::page>
