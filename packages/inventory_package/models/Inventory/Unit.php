<?php

namespace App\Models\Inventory;

use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes,Ownerable;
    protected static function boot()
    {
        parent::boot();
    }

    public function items() :HasMany{
        return $this->hasMany(Item::class);
    }
}
