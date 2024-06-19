<?php

namespace App\Models\Inventory;

use App\Models\Logistic\Branch;
use App\Models\Scopes\OwnerableScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OwnerableScope(auth()->user()));
        static::creating(function ($model) {
            $model->ownerable_id =$model->ownerable_id?? auth()->user()->ownerable_id;
            $model->ownerable_type =$model->ownerable_type?? auth()->user()->ownerable_type;
        });
    }
    public function ownerable()
    {
        return $this->morphTo();
    }
    public function items() :HasMany{
        return $this->hasMany(Item::class);
    }
}
