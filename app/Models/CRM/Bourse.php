<?php

namespace App\Models\CRM;

use App\Models\Finance\BoursePayment;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bourse extends Model
{
    use HasFactory, SoftDeletes,Ownerable,HasUser;

    public function payments(){
        return $this->hasMany(BoursePayment::class)->where('type','payment');
    }
    public function debits(){
        return $this->hasMany(BoursePayment::class)->where('type','debit');
    }

    public function boursePayment():HasMany{
        return  $this->hasMany(BoursePayment::class);
    }

    public function getBalanceAttribute(){
        $total = $this->payments->map(function($payment){
            return convertToCurrency($payment->currency_id, getBaseCurrency()->id, $payment->amount);
        })->sum();
        return $total;
    }
}
