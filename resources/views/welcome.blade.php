<tfoot>
<tr>
    <td class="py-2 px-2 " colspan="5">
    </td>
    <th  class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border  text-[10pt] min-w-[3cm] py-1 ">
        Sub Total
    </th>
    <th class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border text-[10pt] min-w-[3cm]">
        @if($data->currency == '$')
            {{remove_zeros_and_format($data->total)}}
        @else
            {{remove_zeros_and_format(($data->total * $data->currency_price),'IQD')}}
        @endif
        {{$data->currency}}
    </th>
</tr>
<tr>
    <td class="py-2 px-2 " colspan="5">
    </td>
    <th  class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border  text-[10pt] min-w-[3cm] py-1 ">
        Discount
    </th>
    <th class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border text-[10pt] min-w-[3cm]">
        {{remove_zeros_and_format($data->discount_amount)}}  %
    </th>
</tr>
<tr>
    <td class="py-2 px-2 " colspan="5">
    </td>
    <th  class="bg-[{{setting('settings.invoice_primary_color')}}] text-[{{setting('settings.invoice_secondary_color')}}]  border  text-[10pt] min-w-[3cm] py-1 ">
        Total
    </th>
    <th class="bg-[{{setting('settings.invoice_primary_color')}}] text-[{{setting('settings.invoice_secondary_color')}}]  border text-[10pt] min-w-[3cm]">
        @if($data->currency == '$')
            {{remove_zeros_and_format($data->total - ($data->total * ($data->discount_amount / 100)))}}
        @else
            {{remove_zeros_and_format((($data->total * $data->currency_price) -  ($data->total * ($data->discount_amount / 100))),'IQD')}}
        @endif
        {{$data->currency}}            </th>
</tr>
<tr>
    <td colspan="7" class="p-2"></td>
</tr>
<tr>
    <td class="py-2 px-2 " colspan="5">
    </td>
    <th  class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border  text-[10pt] min-w-[3cm] py-1 ">
        Previous Balance
    </th>
    <th class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border text-[10pt] min-w-[3cm]">
        {{remove_zeros_and_format(\App\Models\Vendor::getPrevBalance($data->vendor_id,$data->created_at))}}  $
    </th>
</tr>
<tr>
    <td class="py-2 px-2 " colspan="5">
    </td>
    <th  class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border  text-[10pt] min-w-[3cm] py-1 ">
        Total Balance
    </th>
    <th class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border text-[10pt] min-w-[3cm]">
        {{remove_zeros_and_format(\App\Models\Vendor::getPrevBalance($data->vendor_id,$data->created_at) - ($data->total -  ($data->total * ($data->discount_amount / 100))))}}  $
    </th>
</tr>
<tr>
    <td colspan="5">
    </td>
    <th class="bg-[{{setting('settings.invoice_primary_color')}}] border-b border-e text-[10pt] py-1 text-[{{setting('settings.invoice_secondary_color')}}]">
        Paid
    </th>
    <th class="bg-[{{setting('settings.invoice_primary_color')}}] border-b text-[10pt] text-[{{setting('settings.invoice_secondary_color')}}]">
        {{remove_zeros_and_format($data->paid_amount)}} {{$data->currency}}
    </th>
</tr>
<tr>
    <td class="py-2 px-2 " colspan="5">
    </td>
    <th  class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border  text-[10pt] min-w-[3cm] py-1 ">
        Due Balance
    </th>
    <th class="text-[{{setting('settings.invoice_primary_color')}}] border-[{{setting('settings.invoice_primary_color')}}] border text-[10pt] min-w-[3cm]">
        {{remove_zeros_and_format(\App\Models\Vendor::getPrevBalance($data->vendor_id,$data->created_at) - (($data->total -  ($data->total * ($data->discount_amount / 100))) - $data->paid_amount ))}}  $
    </th>
</tr>
</tfoot>
