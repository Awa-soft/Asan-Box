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
        $price = 0;
        $expenses = 0;

        return $this->detail->price ;

    }
    public function getExpenseAttribute(){
        $price = 0;
        $expenses = 0;

        foreach($this->detail->invoice->expenses as $expense){
            $expenses += convertToCurrency($expense->currency_id, getBaseCurrency()->id,$expense->amount, to_rate:$expense->rate);
        }

        return  ($expenses/$this->detail->codes->count("code"));

    }
    public function getCostAttribute(){
        $price = 0;
        $expenses = 0;

        foreach($this->detail->invoice->expenses as $expense){
            $expenses += convertToCurrency($expense->currency_id, getBaseCurrency()->id,$expense->amount, to_rate:$expense->rate);
        }

        return $this->detail->price + ($expenses/$this->detail->codes->count("code"));

    }
}
