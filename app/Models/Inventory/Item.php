<?php

namespace App\Models\Inventory;

use App\Models\POS\PurchaseDetailCode;
use App\Models\POS\PurchaseInvoiceDetail;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes,Ownerable;


    public function category() :BelongsTo{
        return $this->belongsTo(Category::class);
    }
    public function brand() :BelongsTo{
        return $this->belongsTo(Brand::class);
    }

    public function multiUnit():BelongsTo{
        return $this->belongsTo(Unit::class, "multiple_unit_id");
    }

    public function singleUnit():BelongsTo{
        return $this->belongsTo(Unit::class, "single_unit_id");
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
        foreach ($this->purchases as $key => $purchase) {
            $sumBase += convertToCurrency($purchase->currency_id,getBaseCurrency()->id,$purchase->codes->count("code") * $purchase->price);
            $sumQuantity += $purchase->codes->count("code");
        }

        return $sumBase / $sumQuantity;
    }



}
