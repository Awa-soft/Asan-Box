<?php

namespace App\Models\POS;

use App\Models\Settings\Currency;
use App\Models\User;
use App\Traits\Core\HasCurrency;
use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseExpense extends Model
{
    use HasFactory, HasUser;
    use HasCurrency;
    public function invoice() :BelongsTo
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
    }



}
