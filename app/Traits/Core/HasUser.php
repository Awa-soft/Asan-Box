<?php

namespace App\Traits\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUser
{
    protected static function bootHasUser(): void
    {
        self::creating(function ($model) {
            $model->user_id = auth()->id();
        });
        self::updating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }
}
