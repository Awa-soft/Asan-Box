<x-filament-panels::page>
    <x-core.report-content  listner="employee_activity_report">
        @slot('pageHeader')
            <div class="grid items-center grid-cols-3 p-2 align-middle border rounded-md ">
                <div class="text-start">

                </div>
                <div class="font-bold text-center">
                    {{trans('CRM/lang.reports.partnerAccount')}}
                </div>
                <div class="text-end">

                </div>
            </div>
        @endslot
        @slot('tableHeader')
            <tr>
                <th>
                    {{trans('CRM/lang.partnership.singular_label')}}
                </th>
                <th>
                    {{trans('lang.status')}}
                </th>
                <th>
                    {{trans('CRM/lang.partner.singular_label')}}
                </th>
                <th>
                    {{trans('lang.percent')}}
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
                @foreach($data as $partnerAccount)
                    <td>
                        {{$partnerAccount->partnerShip->name}}
                    </td>
                    <td>
                        {{trans('lang.'.strtolower($partnerAccount->partnerShip->status))}}
                    </td>
                    <td>
                        {{$partnerAccount->partner->name}}
                    </td>
                    <td>
                        {{$partnerAccount->percent}} %
                    </td>
                    <td>
                        {{$partnerAccount->partnerShip->branch->name}}
                    </td>
                    <td>
                        {{$partnerAccount->user->name}}
                    </td>
                @endforeach
        @endslot
        @slot('tableFooter')
        @endslot
        @slot('pageFooter')
        @endslot
    </x-core.report-content>
</x-filament-panels::page>
