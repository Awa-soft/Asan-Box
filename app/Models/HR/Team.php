<?php

namespace App\Models\HR;

use App\Models\Logistic\Branch;
use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;
    use HasUser;

    public function employee():BelongsTo{
        return $this->belongsTo(Employee::class)->withTrashed();
    }
    public function branch(): BelongsTo{
        return $this->belongsTo(Branch::class)->withTrashed();
    }

    public function employees(): BelongsToMany{
        return $this->belongsToMany(Employee::class,'team_employees');
    }
}
