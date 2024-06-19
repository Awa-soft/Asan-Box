<?php

namespace App\Models\CRM;

use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
