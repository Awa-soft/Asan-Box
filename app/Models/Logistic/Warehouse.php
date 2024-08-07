<?php

namespace App\Models\Logistic;

use App\Models\Inventory\Item;
use App\Models\Inventory\ItemLoss;
use App\Models\POS\ItemRepair;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function branches():BelongsToMany{
        return $this->belongsToMany(Branch::class,'branch_warehouses');
    }

    public function items() :BelongsToMany{
        return $this->belongsToMany(Item::class,'warehouse_items');
    }
    public static function hasItem($itemId,$WarehouseId):float
    {
        $transactionCount = ItemTransactionInvoice::where(function($query) use ($WarehouseId) {
            $query->where('fromable_id', $WarehouseId)->where('fromable_type', 'App\Models\Logistic\Warehouse');
        })->orWhere(function($query) use ($WarehouseId) {
            $query->where('toable_id', $WarehouseId)->where('toable_type', 'App\Models\Logistic\Warehouse');
        })
            ->get()
            ->reduce(function ($count, $transaction) use ($WarehouseId,$itemId) {
                return $count + ((($transaction->fromable_id ==  $WarehouseId && $transaction->fromable_type ==  'App\Models\Logistic\Warehouse') ? -1 : 1) * $transaction->details()->where('item_id', $itemId)->get()->sum('codes_count'));
            }, 0);

        $repairCounts = ItemRepair::where('ownerable_type', 'App\Models\Logistic\Warehouse')
            ->where('ownerable_id', $WarehouseId)
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
        $itemLoss = ItemLoss::where('ownerable_type', 'App\Models\Logistic\Warehouse')
            ->where('ownerable_id', $WarehouseId)
            ->where('item_id', $itemId)
            ->get()
            ->count();

        return ($transactionCount + $repairIncreaseCount) -   ($repairDecreaseCount + $itemLoss);
    }



    public static function hasCode($itemId,$code,$WarehouseId):float
    {
        $transactionCount = ItemTransactionInvoice::where(function($query) use ($WarehouseId) {
            $query->where('fromable_id', $WarehouseId)->where('fromable_type', 'App\Models\Logistic\Warehouse');
        })->orWhere(function($query) use ($WarehouseId) {
            $query->where('toable_id', $WarehouseId)->where('toable_type', 'App\Models\Logistic\Warehouse');
        })
            ->whereHas('details',function ($query) use($code){
                return $query->whereHas('codes',function ($query)use($code){
                    return $query->where('code',$code);
                });
            })
            ->get()
            ->reduce(function ($count, $transaction) use ($WarehouseId,$itemId) {
                return $count + ((($transaction->fromable_id ==  $WarehouseId && $transaction->fromable_type ==  'App\Models\Logistic\Warehouse') ? -1 : 1) * $transaction->details()->where('item_id', $itemId)->get()->sum('codes_count'));
            }, 0);

        $repairCounts = ItemRepair::where('ownerable_type', 'App\Models\Logistic\Warehouse')
            ->where('ownerable_id', $WarehouseId)
            ->where('item_id', $itemId)
            ->where('code',$code)
            ->get()
            ->reduce(function ($counts, $repair) {
                if ($repair->type == 'increase') {
                    $counts['increase']++;
                } else if ($repair->type == 'decrease') {
                    $counts['decrease']++;
                }
                return $counts;
            }, ['increase' => 0, 'decrease' => 0]);
        $itemLoss = ItemLoss::where('ownerable_type', 'App\Models\Logistic\Warehouse')
            ->where('ownerable_id', $WarehouseId)
            ->where('code',$code)
            ->where('item_id', $itemId)
            ->get()
            ->count();
        $repairIncreaseCount = $repairCounts['increase'];
        $repairDecreaseCount = $repairCounts['decrease'];


        return ($transactionCount + $repairIncreaseCount) -   ($repairDecreaseCount + $itemLoss);
    }

    public function financialBranch():BelongsTo
    {
            return $this->belongsTo(Branch::class,'financial_branch_id');
    }
}
