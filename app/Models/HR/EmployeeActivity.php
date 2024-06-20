<?php

namespace App\Models\HR;

use App\Models\Logistic\Branch;
use App\Models\Settings\Currency;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeActivity extends Model
{
    use HasFactory;
    use HasUser;
    use Ownerable, SoftDeletes;


    public function employee():BelongsTo{
        return $this->belongsTo(Employee::class)->withTrashed();
    }
    public function currency():BelongsTo{
        return $this->belongsTo(Currency::class)->withTrashed();
    }
    public function branch(): BelongsTo{
        return $this->belongsTo(Branch::class)->withTrashed();
    }

    public static function getTypes():array{
        return [
          'punish'=>trans('lang.punishment'),
          'bonus'=>trans('lang.bonus'),
          'absence'=>trans('lang.absence'),
          'advance'=>trans('lang.advance'),
          'overtime'=>trans('lang.overtime'),
        ];
    }

}
