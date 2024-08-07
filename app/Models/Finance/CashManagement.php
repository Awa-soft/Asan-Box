<?php

namespace App\Models\Finance;

use App\Models\CRM\PartnerAccount;
use App\Traits\Core\HasCurrency;
use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashManagement extends Model
{
    use HasFactory;
    use HasCurrency;
    use HasUser;

    public  static function getTypes():array
    {
        return [
            'deposit'=>trans('lang.deposit'),
            'withdraw'=>trans('lang.withdraw'),
            'profit'=>trans('lang.profit'),
        ];
    }

    public function partnerAccountAll():BelongsTo
    {
        return $this->belongsTo(PartnerAccount::class,'partner_account_id');
    }
    public function partnerAccount(): BelongsTo{
        $ids = [];

        foreach (PartnerAccount::all() as $partnerAccount){
            if($partnerAccount->status == trans('lang.active')){
                $ids[] = $partnerAccount->id;
            }
        }
        return $this->belongsTo(PartnerAccount::class,'partner_account_id')->whereIn('id', $ids);
    }


    public function getBaseAmountAttribute():float
    {
        return $this->currency_id == getBaseCurrency()->id ? $this->amount : $this->amount / ($this->rate / 100);
    }
}
