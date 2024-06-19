<?php

namespace App\Models\Inventory;

use App\Models\Logistic\Branch;
use App\Models\Scopes\OwnerableScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OwnerableScope(auth()->user()));
    }

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

    public function ownerable()
    {
        return $this->morphTo();
    }

}
