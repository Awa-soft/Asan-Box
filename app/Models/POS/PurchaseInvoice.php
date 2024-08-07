<?php

namespace App\Models\POS;

use App\Models\CRM\Contact;
use App\Models\Logistic\Branch;
use App\Models\Settings\Currency;
use App\Models\User;
use App\Traits\Core\HasCurrency;
use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseInvoice extends Model
{
    use HasFactory, SoftDeletes, HasUser, HasCurrency;


    public static function InvoiceNumber() {
        $lastInvoice = self::orderBy('id', 'desc')->first();
        if ($lastInvoice) {
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $lastInvoiceNumber = str_replace('PUR-', '', $lastInvoiceNumber);
            $lastInvoiceNumber = (int) $lastInvoiceNumber;
            $lastInvoiceNumber++;
        } else {
            $lastInvoiceNumber = 1;
        }
        return 'PUR-'.str_pad($lastInvoiceNumber, 4, '0', STR_PAD_LEFT);

    }
    public function branch() :BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    public function contact() :BelongsTo{
        return $this->belongsTo(Contact::class);
    }
    public function currency() :BelongsTo{
        return $this->belongsTo(Currency::class);
    }

    public function details() :HasMany{
        return $this->hasMany(PurchaseInvoiceDetail::class);
    }
    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function expenses() :HasMany{
        return $this->hasMany(PurchaseExpense::class);
    }

    public function getItemsCountAttribute():int
    {
        return $this->details->count();
    }
    public function getCodesCountAttribute():int
    {
        return $this->details()->get()->sum('codes_count');
    }

    public function getTotalAttribute(){
        $total = 0;
        foreach ($this->details as $detail) {
            $total += $detail->price * $detail->codes()->where("gift", 0)->count();
        }
        if($this->currency_id == getBaseCurrency()->id){
            return $total;
        }
        return $total * ($this->rate / 100);
    }

    public function getTotalExpensesAttribute(){
        $sumBaseExpenses = 0;
        foreach ($this->expenses as $expense) {
            $sumBaseExpenses += $expense->currency_id == getBaseCurrency()->id ? $expense->amount : $expense->amount / ($expense->rate / 100);
    }

    return $sumBaseExpenses;
}
public function getDueAmountAttribute():float
{

    return ($this->getTotalAttribute() + $this->getTotalExpensesAttribute()) - $this->paid_amount;
}

public function vendor():BelongsTo
{
    return $this->belongsTo(Contact::class,'contact_id')->withTrashed();
}
public function contactPhone():BelongsTo
{
    return $this->vendor();
}
public function getNetTotalAttribute(){
    return $this->total - $this->total_expenses;
}


}
