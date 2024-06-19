<?php

namespace App\Models\HR;

use App\Models\Logistic\Branch;
use App\Models\Settings\Currency;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSalary extends Model
{
    use HasFactory;
    use HasUser;
    use Ownerable;

    public function employee():BelongsTo{
        return $this->belongsTo(Employee::class)->withTrashed();
    }
    public function currency():BelongsTo{
        return $this->belongsTo(Currency::class)->withTrashed();
    }
    public function branch(): BelongsTo{
        return $this->belongsTo(Branch::class)->withTrashed();
    }

}
