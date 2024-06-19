<?php

namespace App\Models\POS;

use App\Models\Inventory\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseDetailCode extends Model
{
    use HasFactory;

    public function parent() :BelongsTo{
        return $this->belongsTo(PurchaseInvoiceDetail::class, "purchase_invoice_detail");
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
