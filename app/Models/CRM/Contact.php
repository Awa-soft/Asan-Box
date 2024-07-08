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
        return $this->hasMany(Payment::class)->where('type', "recieve");
    }


    public function getBalanceAttribute(){
        $sends = $this->sends->map(function($send){
            return convertToCurrency($send->currency_id, getBaseCurrency()->id,
             $send->amount, $send->rate,  getBaseCurrency()->rate );
        })->sum();

        $receives = $this->receives->map(function($receive){
            return convertToCurrency($receive->currency_id, getBaseCurrency()->id,
             $receive->amount, $receive->rate,  getBaseCurrency()->rate );
        })->sum();
        
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
