<?php

namespace App\Models\HR;

use App\Models\Logistic\Branch;
use App\Models\Settings\Currency;
use App\Models\User;
use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use HasUser;
    use SoftDeletes;



    public function identityType(): BelongsTo{
        return $this->belongsTo(IdentityType::class);
    }
    public function branch(): BelongsTo{
        return $this->belongsTo(Branch::class)->withTrashed();
    }
    public function currency(): BelongsTo{
        return $this->belongsTo(Currency::class)->withTrashed();
    }

    public static function getSalaryTypes():array{
        return [
            'monthly'=>trans('lang.hr.monthly'),
            'weekly'=>trans('lang.hr.weekly'),
            'daily'=>trans('lang.hr.daily'),
        ];
    }
    public static function getGenders():array{
        return [
          'male'=>trans('lang.hr.male'),
          'female'=>trans('lang.hr.female'),
        ];
    }
}
