<?php

namespace App\Models\POS;

use App\Models\Inventory\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetailCode extends Model
{
    use HasFactory;

    public function detail(): BelongsTo
    {
        return $this->belongsTo(SaleDetail::class, "sale_detail_id");
    }

    public function getCostAttribute():float
    {
        $code = $this->code;
        $purchasedCode = PurchaseDetailCode::where('code',$code)->first();
        if($purchasedCode){
          if($purchasedCode->gift == 1){
              return 0;
          }else{
              if($purchasedCode->detail->invoice->currency->base){
                  return ($purchasedCode->detail->price);
              }else{
                  return ($purchasedCode->detail->price / $purchasedCode->detail->invoice->rate);
              }
          }
        }
        return 0;
    }
    public function getProfitAttribute():float
    {
        if($this->gift == 1){
            return (-1)*($this->cost);
        }
        return $this->detail->price - $this->cost;
    }

}
