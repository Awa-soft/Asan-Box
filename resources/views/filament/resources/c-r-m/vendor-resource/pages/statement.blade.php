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
                <tbody class="w-full">
                <tr class="w-full">
                    <td class="w-max">
                        <div class="p-2 mt-4 font-bold text-center text-white rounded-sm bg-primary-600">
                            {!!   trans('lang.statement', ['name' => $contact->{'name_'.\Illuminate\Support\Facades\App::getLocale()}]) !!}
                        </div>

                        <div class="grid w-full grid-cols-1 my-2 md:grid-cols-2 lg:grid-cols-5">
                            <p class="px-2 py-2 border border-black "><span class="font-bold text-primary-500">{{ trans('lang.branch') }}</span>: {{ $contact->ownerable->name }}</p>
                            <p class="col-span-2 px-2 py-2 border border-black border-s-0"><span class="font-bold text-primary-500">{{ trans('lang.contact') }}</span>: {{ $contact->name  }}- {{ $contact->phone }}</p>
                            <p class="px-2 py-2 border border-black border-s-0"><span class="font-bold text-primary-500">{{ trans('lang.date') }}</span>: {{ $from }} - {{ $to }}</p>
                            <p class="px-2 py-2 border border-black border-s-0"><span class="font-bold text-primary-500">{{ trans('lang.balance') }}</span>: {{ number_format($contact->balance, getBaseCurrency()->decimal) }} {{ getBaseCurrency()->symbol }}</p>
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
                                {{ trans('lang.type') }}
                            </th>
                            <th class="border">
                                {{ trans('lang.date') }}
                            </th>
                            <th class="border">
                                {{ trans('lang.amount') }}
                            </th>
                            <th class="border">
                                {{ trans('lang.paid_amount') }}
                            </th>
                            <th class="border">
                                {{ trans('lang.balance') }}
                            </th>
                            <th class="py-2 border">
                                {{ trans('lang.note') }}
                            </th>
                            </thead>
                            <tbody class="text-center text-[9pt]">
                            @foreach ($data as $d)
                                <tr class="border odd:bg-gray-50">
                                    <td class="py-2 border">
                                        {{ $d['invoice_number'] }}
                                    </td>
                                    <td class="py-2 border">
                                        {{ $d['user']['name'] }}
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
                                    <td class="py-1 border">
                                        {{ number_format($d['paid_amount'], $d['currency']['decimal']) . ' ' . $d['currency']['symbol'] }}
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
