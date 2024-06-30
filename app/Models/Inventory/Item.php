<?php

namespace App\Models\Inventory;

use App\Models\POS\PurchaseDetailCode;
use App\Models\POS\PurchaseInvoiceDetail;
use App\Models\Settings\Currency;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;


    public function category() :BelongsTo{
        return $this->belongsTo(Category::class);
    }
    public function brand() :BelongsTo{
        return $this->belongsTo(Brand::class);
    }


    public function unit():BelongsTo{
        return $this->belongsTo(Unit::class, "unit_id");
    }

    public function purchases() :HasMany{
        return $this->hasMany(PurchaseInvoiceDetail::class, "item_id");
    }
    public function codes() :HasMany{
        return $this->hasMany(PurchaseDetailCode::class, "item_id");
    }

    public function getCostAttribute(){
        $sumBase = 0;
        $sumQuantity = 0;
        $sumExpensesBase = 0;
        foreach ($this->purchases as $key => $purchase) {
            $sumExpensesBase += $purchase->invoice->expenses->map(function($expense){
                return convertToCurrency($expense->currency_id,getBaseCurrency()->id,$expense->amount, from_rate: $expense->rate);
            })->sum();
            $sumBase += convertToCurrency($purchase->currency_id,getBaseCurrency()->id,$purchase->codes->count("code") * $purchase->price);
            $sumQuantity += $purchase->codes->count("code");
        }
        return ($sumBase / ($sumQuantity==0?1:$sumQuantity)) +  ($sumExpensesBase/($this->purchases()->get()->sum("codes_count")==0?1:$this->purchases()->get()->sum("codes_count")));

    }



}
