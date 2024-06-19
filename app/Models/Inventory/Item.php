<?php

namespace App\Models\Inventory;

use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes,Ownerable;


    public function category() :BelongsTo{
        return $this->belongsTo(Category::class);
    }
    public function brand() :BelongsTo{
        return $this->belongsTo(Brand::class);
    }

    public function multiUnit():BelongsTo{
        return $this->belongsTo(Unit::class, "multiple_unit_id");
    }

    public function singleUnit():BelongsTo{
        return $this->belongsTo(Unit::class, "single_unit_id");
    }



}
