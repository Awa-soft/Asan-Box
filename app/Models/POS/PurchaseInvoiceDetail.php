<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseInvoiceDetail extends Model
{
    use HasFactory;

    public function invoice() :BelongsTo{
        return $this->belongsTo(PurchaseInvoice::class);
    }
}
