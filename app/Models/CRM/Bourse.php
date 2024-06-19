<?php

namespace App\Models\CRM;

use App\Models\Logistic\Branch;
use App\Models\Scopes\OwnerableScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bourse extends Model
{
    use HasFactory, SoftDeletes;
    protected static function boot()
    {
      parent::boot();
      static::addGlobalScope(new OwnerableScope(auth()->user()));
      static::creating(function ($model) {
        $model->user_id = auth()->id();
      });
      static::updating(function ($model) {
        $model->user_id = auth()->id();
      });
    }


    public function ownerable()
    {
        return $this->morphTo();
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
