<?php

namespace App\Models\HR;

use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdentityType extends Model
{
    use HasFactory;
    use HasUser;
    use Ownerable, SoftDeletes;

    public function employees() :HasMany{
        return $this->hasMany(Employee::class);
    }

}
