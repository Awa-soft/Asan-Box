<?php

namespace App\Models\CRM;

use App\Models\Logistic\Branch;
use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;
    use HasUser;


    public function branches() :BelongsToMany{
        return $this->belongsToMany(Branch::class,'branch_partners');
    }
}
