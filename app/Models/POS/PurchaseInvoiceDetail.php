<?php

namespace App\Models\POS;

use App\Models\Inventory\Item;
use App\Models\Settings\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseInvoiceDetail extends Model
{
    use HasFactory;


    public function invoice() :BelongsTo{
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id')->withTrashed();
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function codes() :HasMany{
        return $this->hasMany(PurchaseDetailCode::class);
    }
    public function currency():BelongsTo{
        return $this->belongsTo(Currency::class);
    }

    public function getCodesCountAttribute():int{
        return $this->codes()->count();
    }

    public function getTotalAttribute(){
            return $this->price * $this->codes()->where("gift", 0)->count();
    }
}
