<?php

namespace App\Models\Inventory;

use App\Traits\Core\HasCurrency;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemLoss extends Model
{
    use HasFactory;
    use Ownerable,HasUser,HasCurrency,SoftDeletes;
    public function item():BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
