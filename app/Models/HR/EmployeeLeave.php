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


    public function getLeaveDaysAttribute():int{
        return Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to));
    }



}
