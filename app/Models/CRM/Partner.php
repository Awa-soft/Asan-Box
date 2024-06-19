<?php

namespace App\Models\CRM;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
      parent::boot();
      static::creating(function ($model) {
        $model->user_id = auth()->id();
      });
    }
    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }
}
