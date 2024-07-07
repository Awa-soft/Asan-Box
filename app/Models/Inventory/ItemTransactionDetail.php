<?php

namespace App\Models\Inventory;

use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemTransactionDetail extends Model
{
    use HasFactory;


    public function invoice():BelongsTo{
        return $this->belongsTo(ItemTransactionInvoice::class,'item_transaction_invoice_id');
    }

    public function item():BelongsTo{
        return $this->belongsTo(Item::class);
    }

    public function codes():HasMany
    {
        return $this->hasMany(ItemTransactionCode::class);
    }
}
