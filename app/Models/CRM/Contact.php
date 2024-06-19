<?php

namespace App\Models\CRM;

use App\Models\Logistic\Branch;
use App\Models\Scopes\OwnerableScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;
    protected static function boot()
    {
      parent::boot();
      static::addGlobalScope(new OwnerableScope(auth()->user()));
      static::creating(function ($model) {
        $model->user_id = auth()->id();
      });
    }
    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function ownerable()
    {
        return $this->morphTo();
    }

    public function scopeVendor($query){
        return  $query->where('type', "Vendor");
    }
    public function scopeCustomer($query){
        return  $query->where('type', "Customer");
    }
    public function scopeBoth($query){
        return  $query->where('type', "Both");
    }
}
