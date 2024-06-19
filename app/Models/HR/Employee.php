<?php

namespace App\Models\HR;

use App\Models\Core\Attachment;
use App\Models\Logistic\Branch;
use App\Models\Settings\Currency;
use App\Models\User;
use App\Traits\HasAttachments;
use App\Traits\HasUser;
use App\Traits\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use HasUser;
    use SoftDeletes;
    use HasAttachments;
    use Ownerable;



    public function identityType(): BelongsTo{
        return $this->belongsTo(IdentityType::class);
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
    public function positions(): BelongsToMany{
        return $this->belongsToMany(Position::class,'employee_positions');
    }

    public function teams(): BelongsToMany{
        return $this->belongsToMany(Team::class,'team_employees');
    }


}
