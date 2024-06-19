<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUser
{
    protected static function bootHasUser()
    {
        self::created(function ($model) {
            $model->user_id = auth()->id();
        });
        self::updated(function ($model) {
            $model->user_id = auth()->id();
        });
    }
    public function user() :BelongsTo{
        return $this->belongsTo(User::class)->withTrashed();
    }
}
