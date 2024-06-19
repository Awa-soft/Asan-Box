<?php

namespace App\Models\Inventory;

use App\Models\Logistic\Branch;
use App\Models\Scopes\OwnerableScope;
use App\Traits\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes,Ownerable;

    public function items() :HasMany{
        return $this->hasMany(Item::class);
    }

}
