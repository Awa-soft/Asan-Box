<?php

namespace App\Models\HR;

use App\Models\Settings\Currency;
use App\Traits\Core\HasAttachments;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use HasUser;
    use SoftDeletes;
    use HasAttachments;
    use Ownerable;



    public function identityType(): BelongsTo{
        return $this->belongsTo(IdentityType::class)->withTrashed();
    }

    public function currency(): BelongsTo{
        return $this->belongsTo(Currency::class)->withTrashed();
    }

    public static function getSalaryTypes():array{
        return [
            'monthly'=>trans('lang.monthly'),
            'weekly'=>trans('lang.weekly'),
            'daily'=>trans('lang.daily'),
        ];
    }
    public static function getGenders():array{
        return [
          'male'=>trans('lang.male'),
          'female'=>trans('lang.female'),
        ];
    }
    public function positions(): BelongsToMany{
        return $this->belongsToMany(Position::class,'employee_positions');
    }

    public function team(): BelongsToMany{
        return $this->belongsToMany(Team::class,'team_employees');
    }
    public function activities() :HasMany{
        return $this->hasMany(EmployeeActivity::class, 'employee_id');
    }
    public function notes() :HasMany{
        return $this->hasMany(EmployeeNote::class, 'employee_id');
    }

    public function leaves() :HasMany{
        return $this->hasMany(EmployeeLeave::class, 'employee_id');
    }


    public function getRemainingLeaveAttribute(){
        return $this->annual_leave - $this->leaves()->where('status', 'approved')->whereYear('from', now())->get()->sum('leave_days');
    }

    public function salaries() :HasMany{
        return $this->hasMany(EmployeeSalary::class);
    }

    public function getLastSalaryDateAttribute():?string{
        return $this->salaries()->latest()->first()?->salary_date ?? $this->hire_date;
    }

    public function getHourSalaryAttribute():float{
        return (($this->salary>0 ? $this->salary:1)/ ($this->work_days >0?$this->work_days :0)) / (($this->work_hours >0 ? $this->work_hours:1)) ;
    }




}
