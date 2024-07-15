<?php

namespace App\Models\POS;

use App\Models\Inventory\Item;
use App\Models\Settings\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleDetail extends Model
{
    use HasFactory;
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(SaleInvoice::class, 'sale_invoice_id');
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function codes(): HasMany
    {
        return $this->hasMany(SaleDetailCode::class);
    }
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function getCodesCountAttribute():int{
        return $this->codes()->count();
    }

    public function getProfitAttribute():float
    {
        return $this->codes()->get()->sum('profit');
    }
    public function getTotalAttribute(){
        return $this->price * $this->codes()->where("gift", 0)->count();
    }
}
