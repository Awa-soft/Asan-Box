<?php

namespace App\Models\Logistic;

use App\Models\CRM\Partner;
use App\Models\Inventory\Item;
use App\Models\POS\ItemRepair;
use App\Models\POS\PurchaseInvoice;
use App\Models\POS\SaleInvoice;
use App\Models\Setting\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function warehouses():BelongsToMany{
        return $this->belongsToMany(Warehouse::class,'branch_warehouses');
    }

    public function currencies() :HasMany{
        return $this->hasMany(Currency::class);
    }

    public function items() :BelongsToMany
    {
        return $this->belongsToMany(Item::class,'branch_items');
    }

    public function partners() :BelongsToMany{
        return $this->belongsToMany(Partner::class,'branch_partners');
    }
    public function scopeBranchHasItem($query, $itemId,$branch_id)
    {
        $purchaseCount = PurchaseInvoice::where('branch_id', $branch_id)
            ->get()
            ->reduce(function ($count, $purchase)use($itemId) {
                return $count + ($purchase->type == 'purchase' ? 1 : -1) * $purchase->details()->where('item_id', $itemId)->get()->sum('codes_count');
            }, 0);

        $saleCount = SaleInvoice::where('branch_id', $branch_id)
            ->get()
            ->reduce(function ($count, $sale)use ($itemId) {
                return $count + ($sale->type == 'return' ? 1 : -1) * $sale->details()->where('item_id', $itemId)->get()->sum('codes_count');
            }, 0);

        $transactionCount = ItemTransactionInvoice::where(function($query) use ($branch_id) {
            $query->where('fromable_id', $branch_id)->where('fromable_type', 'App\Models\Logistic\Branch');
        })->orWhere(function($query) use ($branch_id) {
            $query->where('toable_id', $branch_id)->where('toable_type', 'App\Models\Logistic\Branch');
        })
            ->get()
            ->reduce(function ($count, $transaction) use ($branch_id,$itemId) {
                return $count + ((($transaction->fromable_id ==  $branch_id && $transaction->fromable_type ==  'App\Models\Logistic\Branch') ? -1 : 1) * $transaction->details()->where('item_id', $itemId)->get()->sum('codes_count'));
            }, 0);

        $repairCounts = ItemRepair::where('ownerable_type', 'App\Models\Logistic\Branch')
            ->where('ownerable_id', $branch_id)
            ->where('item_id', $itemId)
            ->get()
            ->reduce(function ($counts, $repair) {
                if ($repair->type == 'increase') {
                    $counts['increase']++;
                } else if ($repair->type == 'decrease') {
                    $counts['decrease']++;
                }
                return $counts;
            }, ['increase' => 0, 'decrease' => 0]);

        $repairIncreaseCount = $repairCounts['increase'];
        $repairDecreaseCount = $repairCounts['decrease'];

        return $purchaseCount + $saleCount + $transactionCount + $repairIncreaseCount - $repairDecreaseCount;
    }




}
