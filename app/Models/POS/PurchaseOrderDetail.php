<?php

namespace App\Models\POS;

use App\Models\Inventory\Item;
use App\Models\Inventory\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderDetail extends Model
{
    use HasFactory;

    public function item():BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function unit():BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function purchaseOrder():BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
