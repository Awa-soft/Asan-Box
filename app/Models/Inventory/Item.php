<?php

namespace App\Models\Inventory;

use App\Models\Logistic\ItemTransactionCode;
use App\Models\POS\PurchaseDetailCode;
use App\Models\POS\PurchaseInvoiceDetail;
use App\Models\POS\SaleDetail;
use App\Models\POS\SaleDetailCode;
use App\Models\Settings\Currency;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;


    public function category() :BelongsTo{
        return $this->belongsTo(Category::class);
    }
    public function brand() :BelongsTo{
        return $this->belongsTo(Brand::class);
    }


    public function unit():BelongsTo{
        return $this->belongsTo(Unit::class, "unit_id");
    }

    public function purchases() :HasMany{
        return $this->hasMany(PurchaseInvoiceDetail::class, "item_id");
    }

    public function purchaseCodes():HasMany
    {
        return $this->hasMany(ItemLoss::class,'item_id')
            ->whereHas('detail',function ($query){
                return $query->whereHas('invoice',function ($query){
                    return $query->where('deleted_at',null)->where('type','purchase');
                });
            });
    }
    public function returnPurchaseCodes():HasMany
    {
        return $this->hasMany(ItemLoss::class,'item_id')
            ->whereHas('detail',function ($query){
                return $query->whereHas('invoice',function ($query){
                    return $query->where('deleted_at',null)->where('type','!=','purchase');
                });
            });
    }
    public function saleCodes():HasMany
    {
        return $this->hasMany(SaleDetailCode::class,'item_id')
            ->whereHas('detail',function ($query){
                    return $query->whereHas('invoice',function ($query){
                        return $query->where('deleted_at',null)
                            ->where('type','!=','return');
                    });
                });
    }
    public function returnSaleCodes():HasMany
    {
        return $this->hasMany(SaleDetailCode::class,'item_id')
            ->whereHas('detail',function ($query){
                return $query->whereHas('invoice',function ($query){
                    return $query->where('deleted_at',null)
                        ->where('type','return');
                });
            });
    }

    public function transactionCodes():HasMany
    {
        return $this->hasMany(ItemTransactionCode::class,'item_id')
            ->whereHas('itemTransactionDetail',function ($query){
                    return $query->whereHas('invoice',function ($query){
                        return $query->where('deleted_at',null);
                    });
           });
    }

    public function itemLoss():HasMany
    {
        return $this->hasMany(ItemLoss::class,'item_id')
            ->whereHas('detail',function ($query){
                    return $query->whereHas('invoice',function ($query){
                        return $query->where('deleted_at',null);
                    });
            });
    }
    public function codes() :HasMany{
        return $this->hasMany(PurchaseDetailCode::class, "item_id")
                ->whereHas('detail',function ($query){
                    return $query->whereHas('invoice',function ($query){
                        return $query->where('deleted_at',null);
                    });
                });
    }

    public function getCostAttribute(){
        $sumBase = 0;
        $sumQuantity = 0;
        $sumExpensesBase = 0;
        foreach ($this->purchases as $key => $purchase) {
            $sumExpensesBase += $purchase->whereHas('invoice',function ($query){
                return $query->where('deleted_at',null);
            })->invoice->expenses->map(function($expense){
                return $expense->currency_id == getBaseCurrency()->id ? $expense->amount : ($expense->amount / ($expense->currency_rate / 100));
            })->sum();
            $sumBase+= $purchase->currency_id == getBaseCurrency()->id ? ($purchase->whereHas('invoice',function ($query){
                return $query->where('deleted_at',null);
                })->codes->count("code") * $purchase->price) : (($purchase->codes->count("code") * $purchase->price)/($purchase->currency_rate / 100));
            $sumQuantity += $purchase->codes->count("code");
        }
        return ($sumBase / ($sumQuantity==0?1:$sumQuantity)) +  ($sumExpensesBase/($this->purchases()->get()->sum("codes_count")==0?1:$this->purchases()->get()->sum("codes_count")));
    }



public static function hasCode()
{
    return true;
}





}
