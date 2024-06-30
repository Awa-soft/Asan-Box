<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTransaction extends Model
{
    use HasFactory;

    public function fromable(){
        return $this->morphTo();
    }

    public function toable(){
        return $this->morphTo();
    }
}
