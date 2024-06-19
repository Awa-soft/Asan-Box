<?php

namespace App\Models\Inventory;

use App\Models\Logistic\Branch;
use App\Models\Scopes\OwnerableScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OwnerableScope(auth()->user()));
    }
    public function ownerable()
    {
        return $this->morphTo();
    }
    public function items() :HasMany{
        return $this->hasMany(Item::class);
    }
}
