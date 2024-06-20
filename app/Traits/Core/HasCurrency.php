<?php

namespace App\Traits\Core;

use App\Models\Settings\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCurrency
{
    protected static function bootHasCurrency(): void
    {
        self::creating(function ($model) {
            $model->rate = getCurrencyRate($model->currency_id);
        });
        self::updating(function ($model) {
            $model->rate = getCurrencyRate($model->currency_id);
        });
    }

    public function currency() :BelongsTo{
        return $this->belongsTo(Currency::class);
    }
}
