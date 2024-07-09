<?php

namespace App\Models\Logistic;

use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemTransactionInvoice extends Model
{
    use HasFactory;
    use HasUser,SoftDeletes;

    public function fromable()
    {
        return $this->morphTo();
    }
    public function toable()
    {
        return $this->morphTo();
    }

    public function details():HasMany
    {
        return $this->hasMany(ItemTransactionDetail::class);
    }

}
