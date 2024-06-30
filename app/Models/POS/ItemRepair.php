<?php

namespace App\Models\POS;

use App\Models\Inventory\Item;
use App\Traits\Core\HasCurrency;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use App\Traits\Core\OwnerableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemRepair extends Model
{
    use HasFactory;
    use SoftDeletes,Ownerable,HasUser,HasCurrency;

    public function item():BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public static function getTypes():array
    {
        return [
            'increase'=>trans('lang.increase'),
            'decrease'=>trans('lang.decrease'),
        ];
    }
}
