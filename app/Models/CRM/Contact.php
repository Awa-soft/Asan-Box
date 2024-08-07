<?php

namespace App\Models\CRM;

use App\Models\Finance\Payment;
use App\Models\POS\PurchaseInvoice;
use App\Models\POS\SaleInvoice;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes,Ownerable,HasUser;


    public function purchases(){
        return $this->hasMany(PurchaseInvoice::class);
    }
    public function sales(){
        return $this->hasMany(SaleInvoice::class);
    }
    public function sends(){
        return $this->hasMany(Payment::class)->where('type', "send");
    }
    public function receives(){
        return $this->hasMany(Payment::class)->where('type', "receive");
    }


    public function getBalanceAttribute(){
        $sends = $this->sends->map(function($send){
            return $send->currency_id == getBaseCurrency()->id ? $send->amount : $send->amount / ($send->rate / 100);
        })->sum();

        $receives = $this->receives->map(function($receive){
            return $receive->currency_id == getBaseCurrency()->id ? $receive->amount : $receive->amount / ($receive->rate / 100);

        })->sum();

        $receives += $this->sales->map(function($sale){
            return $sale->currency_id == getBaseCurrency()->id ? $sale->due_amount : $sale->due_amount / ($sale->rate / 100);
        })->sum();

        $sends += $this->purchases->map(function($purchase){
            return $purchase->currency_id == getBaseCurrency()->id ? $purchase->due_amount : $purchase->due_amount / ($purchase->rate / 100);

        })->sum();
        return $sends - $receives;
    }



    public function scopeDebt($query,$debt)
    {
        $ids = [];
        foreach (self::all() as $contact){
            if($contact->balance != 0){
                $ids[] = $contact->id;
            }
        }
        if($debt == 'only_debt'){
            return $query->whereIn('id', $ids);
        }elseif($debt == 'without_debt'){
            return $query->whereNotIn('id', $ids);
        }
        return $query;
    }
    public function scopeMaxDebt($query,$maximumDebt)
    {
        $ids = [];
        foreach (self::all() as $contact){
            if($contact->balance >= $contact->max_debt || $contact->balance <= (-1* $contact->max_debt)){
                $ids[] = $contact->id;
            }
        }
        if($maximumDebt == 'reached'){
            return $query->whereIn('id', $ids);
        }elseif($maximumDebt == 'not_reached'){
            return $query->whereNotIn('id', $ids);
        }
        return $query;
    }

    public function scopeVendor($query){
        return  $query->where('type', "Vendor");
    }
    public function scopeCustomer($query){
        return  $query->where('type', "Customer");
    }
    public function scopeBoth($query){
        return  $query->where('type', "Both");
    }
}
