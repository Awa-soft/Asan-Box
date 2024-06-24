<div>
    <link rel="stylesheet" href="{{asset('assets/css/core/print.css')}}">
    <style>
       .tableContent * th,.tableContent * td{
            padding:5px 4px;
            border-width:1px;
            text-align: center;
        }
       .tableContent * tbody tr:nth-child(odd){
            background-color: rgb(250,250,250);
       }
       td{
           font-size: 10pt;
       }
       th{
           font-size: 10.5pt !important;
           font-weight: bold;
       }
    </style>
    <div class="mx-auto relative w-[210mm] py-3 print:hidden ">
        <div class="w-fit ms-auto">
            <x-filament::button
                icon="fas-print"
                icon-position="before"
                onclick="window.print()"
            >
                {{trans('lang.print')}}
            </x-filament::button>
        </div>
          </div>
    <div class="mx-auto relative text-black bg-white w-[210mm] min-h-[297mm]">
        <table class="w-full">
            <thead>
                <th class="pb-4" style="border-width: 0">
                    <img class="hidden w-full print:block" src="{{asset('storage/'.(auth()->user()?->ownerable?->receipt_header!=null?auth()->user()?->ownerable?->receipt_header:\App\Models\Logistic\Branch::find(1)?->receipt_header))}}">
                </th>
            </thead>
            <tbody>
                <tr class="tableContent">
                    <td style="border-width: 0">
                        <div class="px-4">
                            {{$pageHeader??''}}
                            <table class="w-full my-4">
                                <thead class="text-white border bg-primary-500">
                                {{$tableHeader??''}}
                                </thead>
                                <tbody>
                                {{$tableContent??''}}
                                </tbody>
                                <tfoot>
                                {{$tableFooter??''}}
                                </tfoot>
                            </table>
                            {{$pageFooter??''}}
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
            <th class="pt-4" style="border-width: 0">
                <img class="w-full opacity-0" src="{{asset('storage/'.(auth()->user()?->ownerable?->receipt_footer!=null ?auth()->user()?->ownerable?->receipt_footer:\App\Models\Logistic\Branch::find(1)?->receipt_footer))}}">
            </th>
            </tfoot>
        </table>
        <img class="fixed bottom-0 left-0 w-full opacity-0 print:opacity-100" src="{{asset('storage/'.(auth()->user()?->ownerable?->receipt_footer!=null ?auth()->user()?->ownerable?->receipt_footer:\App\Models\Logistic\Branch::find(1)?->receipt_footer))}}">
    </div>
</div>
