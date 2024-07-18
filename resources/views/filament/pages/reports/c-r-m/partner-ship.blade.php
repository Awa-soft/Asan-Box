<x-filament-panels::page>
    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">
                    <b>{{trans('lang.from')}}:</b> {{$from}}
                </div>
                <div class="font-bold text-center">
                    {{trans('CRM/lang.reports.partnership')}}
                </div>
                <div class="text-end">
                    <b>{{trans('lang.to')}}:</b> {{$to}}
                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('lang.start_date')}}
                </th>
                <th>
                    {{trans('lang.end_date')}}
                </th>
                <th>
                    {{trans('lang.status')}}
                </th>
                <th>
                    {{trans('lang.branch')}}
                </th>
                <th>
                    {{trans('lang.user')}}
                </th>
            </tr>
        @endslot
        @slot('tableContent')
           @foreach($data as $dt)
               <tr>
                   <td>
                       {{$dt->start_date}}
                   </td>
                   <td>
                       {{$dt->end_date}}
                   </td>
                   <td>
                      {{trans('lang.'.strtolower($dt->status))}}
                   </td>
                   <td>
                       {{$dt->branch->name}}
                   </td>
                   <td>
                       {{$dt->user->name}}
                   </td>
               </tr>
                @if($dt->partnerAccounts->count() > 0)
                        <tr>
                            <th colspan="5" style="background: rgb(var(--primary-300))">
                                {{trans('CRM/lang.partner_account.plural_label')}}
                            </th>
                        </tr>
                        <tr style="background: rgb(var(--primary-100))">
                            <th colspan="3">
                                {{trans('CRM/lang.partner.singular_label')}}
                            </th>
                            <th>
                                {{trans('lang.percent')}}
                            </th>

                            <th>
                                {{trans('lang.user')}}
                            </th>
                        </tr>
                        @foreach($dt->partnerAccounts as $partnerAccount)
                            <td colspan="3">
                                {{$partnerAccount->partner->name}}
                            </td>
                            <td>
                                {{$partnerAccount->percent}} %
                            </td>
                            <td>
                                {{$partnerAccount->user->name}}
                            </td>
                        @endforeach
                @endif
               <tr>
                   <td colspan="5" style="padding: 10px;border: none;background: white;border-top: 2px solid rgb(var(--primary-500))"></td>
               </tr>
           @endforeach
        @endslot
        @slot('tableFooter')
        @endslot
        @slot('pageFooter')
        @endslot
    </x-core.report-content>
</x-filament-panels::page>
