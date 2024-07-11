<?php

namespace App\Models\Logistic;

use App\Models\Inventory\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function branches():BelongsToMany{
        return $this->belongsToMany(Branch::class,'branch_warehouses');
    }

    public function items() :BelongsToMany{
        return $this->belongsToMany(Item::class,'warehouse_items');
    }
    public function hasItem($itemsId,$WarehouseId):float
    {
        return 0;
    }
}
