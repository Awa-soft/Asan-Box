<?php

namespace App\Models\POS;

use App\Models\Inventory\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseInvoiceDetail extends Model
{
    use HasFactory;

    public function invoice() :BelongsTo{
        return $this->belongsTo(PurchaseInvoice::class);
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function codes() :HasMany{
        return $this->hasMany(PurchaseDetailCode::class);
    }
}
