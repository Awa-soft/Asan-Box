<?php

namespace App\Models\HR;

use App\Models\Logistic\Branch;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLeave extends Model
{
    use HasFactory;
    use HasUser;
    use Ownerable, SoftDeletes;
    protected $appends = [
        'owner_name',
        'user_name',
        'employee_name',
    ];

    public function employee():BelongsTo{
        return $this->belongsTo(Employee::class)->withTrashed();
    }

    public static function getStatus(){
        return [
            'pending' => trans('lang.pending'),
            'approved' => trans('lang.approved'),
            'rejected' => trans('lang.rejected'),
        ];
    }


    public static function getLabels(){
        return [
            'owner_name' => trans('lang.owner'),
            'user_name'=>trans('user'),
            'employee_name'=>trans('lang.employee'),
            'status'=>trans('lang.status'),
            'from'=>trans('lang.from'),
            'to'=>trans('lang.to'),
            'date'=>trans('lang.date'),
            'note'=>trans('lang.note'),
        ];

    }

    public function getOwnerNameAttribute()
    {
        return $this->ownerable?->name;
    }
    public function getUserNameAttribute()
    {
        return $this->user?->name;
    }
    public function getEmployeeNameAttribute()
    {
        return $this->employee?->name;
    }

    public function getLeaveDaysAttribute():int{
        return Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to));
    }



}
