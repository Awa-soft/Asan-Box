<?php

namespace App\Models\HR;

use App\Models\Logistic\Branch;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory;
    use HasUser, SoftDeletes, Ownerable;
    public function branch(): BelongsTo{
        return $this->belongsTo(Branch::class)->withTrashed();
    }

    public function employees(): BelongsToMany{
        return $this->belongsToMany(Employee::class,'employee_positions');
    }
}
