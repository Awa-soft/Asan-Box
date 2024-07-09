<?php

namespace App\Models\Finance;

use App\Models\CRM\Bourse;
use App\Models\Logistic\Branch;
use App\Models\Settings\Currency;
use App\Models\User;
use App\Traits\Core\HasCurrency;
use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoursePayment extends Model
{
    use HasFactory, SoftDeletes, HasUser, HasCurrency;

    public static function InvoiceNumber() {
        $lastInvoice = self::orderBy('id', 'desc')->first();
        if ($lastInvoice) {
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $lastInvoiceNumber = str_replace('BPY-', '', $lastInvoiceNumber);
            $lastInvoiceNumber = (int) $lastInvoiceNumber;
            $lastInvoiceNumber++;
        } else {
            $lastInvoiceNumber = 1;
        }
        return 'BPY-'.str_pad($lastInvoiceNumber, 4, '0', STR_PAD_LEFT);

    }
    public function bourse() :BelongsTo
    {
        return $this->belongsTo(Bourse::class);
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency() :BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function branch() :BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public static function getTypes()
    {
        return [
            'payment' => trans('lang.payment'),
            'debit' => trans('lang.debit'),
        ];
    }
}
