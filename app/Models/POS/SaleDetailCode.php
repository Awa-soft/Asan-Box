<?php

namespace App\Models\POS;

use App\Models\Inventory\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetailCode extends Model
{
    use HasFactory;

    public function detail(): BelongsTo
    {
        return $this->belongsTo(SaleDetail::class, "sale_detail_id");
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
