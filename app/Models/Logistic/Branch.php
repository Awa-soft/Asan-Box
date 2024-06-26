<?php

namespace App\Models\Logistic;

use App\Models\CRM\Partner;
use App\Models\Inventory\Item;
use App\Models\Setting\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function warehouses():BelongsToMany{
        return $this->belongsToMany(Warehouse::class,'branch_warehouses');
    }

    public function currencies() :HasMany{
        return $this->hasMany(Currency::class);
    }

    public function items() :HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function partners() :BelongsToMany{
        return $this->belongsToMany(Partner::class,'branch_partners');
    }
}
