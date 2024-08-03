<?php

namespace App\Models\CRM;

use App\Models\Finance\CashManagement;
use App\Models\Logistic\Branch;
use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerAccount extends Model
{
    use HasFactory;
    use HasUser;
    use SoftDeletes;

    public function partner():BelongsTo{
        return $this->belongsTo(Partner::class);
    }

    public function partnership():BelongsTo{
        return $this->belongsTo(Partnership::class);
    }
     public function partnershipAll():BelongsTo{
        return $this->belongsTo(Partnership::class,'partnership_id')->withTrashed();
    }

    public function getStatusAttribute()
    {
        return $this->partnershipAll?->status ?? trans('lang.deactivate');
    }


    public function cashManagement():HasMany
    {
        return $this->hasMany(CashManagement::class);
    }

    public function getBalanceAttribute():float
    {
        return ($this->cashManagement()->where('type','deposit')->get()->sum('base_amount'))-(
            $this->cashManagement()->where('type','withdraw')->get()->sum('base_amount')
            );
    }

    public function getProfitAttribute():float
    {
     return   $this->cashManagement()->where('type','profit')->get()->sum('base_amount');
    }

}
