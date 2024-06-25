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

class Team extends Model
{
    use HasFactory, HasUser, Ownerable, SoftDeletes;
    protected $appends = [
        'owner_name',
        'user_name',
        'employee_name',
    ];
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

    public static function getLabels()
    {
        return [
            'owner_name' => trans('lang.owner'),
            'user_name' => trans('user'),
            'name' => trans('lang.name'),
            'leader' => trans('lang.leader'),
            'members' => trans('lang.members'),
        ];
    }
    public function leader(): BelongsTo
    {
        return $this->belongsTo(Employee::class, "leader_id")->withTrashed();
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'team_employees');
    }
}
