<?php

namespace App\Models\CRM;

use App\Models\Logistic\Branch;
use App\Models\Scopes\OwnerableScope;
use App\Models\User;
use App\Traits\HasUser;
use App\Traits\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes,Ownerable,HasUser;




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
