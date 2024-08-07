<?php

namespace App\Models\POS;

use App\Models\Inventory\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseDetailCode extends Model
{
    use HasFactory;

    public function detail() :BelongsTo{
        return $this->belongsTo(PurchaseInvoiceDetail::class, "purchase_invoice_detail_id");
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function getPriceAttribute(){
           return $this->detail->price ;
    }
    public function getExpenseAttribute(){
        $expenses = 0;

        foreach($this->detail->invoice->expenses as $expense){
            $expenses += $expense->currency_id == getBaseCurrency()->id ? $expense->amount : ($expense->amount / ($expenses->currency_rate / 100));
        }

        return  ($expenses/$this->detail->codes->count("code"));

    }
    public function getCostAttribute(){
        $expenses = 0;
        foreach($this->detail->invoice->expenses as $expense){
            $expenses += $expense->currency_id == getBaseCurrency()->id ? $expense->amount : ($expense->amount / ($expenses->currency_rate / 100));
        }

        return $this->detail->price + ($expenses/$this->detail->codes->count("code"));

    }

    public function getIsSoldAttribute():float
    {
        $code = $this->code;
        $saleInvoice = SaleInvoice::whereHas('details',function ($query)use($code){
            return $query->whereHas('codes', function ($query) use ($code){
                return $query->where('code', $code);
            });
        })->where('type','sale')->where('deleted_at',null)->count();
        $returnSale = SaleInvoice::whereHas('details',function ($query)use($code){
            return $query->whereHas('codes', function ($query) use ($code){
                return $query->where('code', $code);
            });
        })->where('type','!=','sale')->where('deleted_at',null)->count();
        if($saleInvoice > $returnSale){
            return true;
        }
        return false;
    }
}
