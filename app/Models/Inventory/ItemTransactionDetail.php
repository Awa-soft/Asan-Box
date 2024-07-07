<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemTransactionDetail extends Model
{
    use HasFactory;

    public function invoice():BelongsTo{
        return $this->belongsTo(ItemTransactionInvoice::class);
    }

    public function item():BelongsTo{
        return $this->belongsTo(Item::class);
    }

    public function codes():HasMany
    {
        return $this->hasMany(ItemTransactionCode::class);
    }
}
