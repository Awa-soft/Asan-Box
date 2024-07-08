<?php

namespace App\Models\Finance;

use App\Models\CRM\Bourse;
use App\Models\CRM\Contact;
use App\Models\Logistic\Branch;
use App\Models\Settings\Currency;
use App\Models\User;
use App\Traits\Core\HasCurrency;
use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes, HasUser, HasCurrency;

    public function contact() :BelongsTo
    {
        return $this->belongsTo(Contact::class);
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
            'send' => trans('lang.send'),
            'receive' => trans('lang.receive'),
        ];
    }
}
