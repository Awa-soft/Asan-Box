<?php

namespace App\Traits;

use App\Models\Scopes\OwnerableScope;

trait Ownerable
{
    protected static function bootOwnerable()
    {
        static::addGlobalScope(new OwnerableScope(auth()->user()));

        static::creating(function ($model) {
            $model->ownerable_id =$model->ownerable_id?? auth()->user()->ownerable_id;
            $model->ownerable_type =$model->ownerable_type?? auth()->user()->ownerable_type;
        });
    }

    public function ownerable()
    {
        return $this->morphTo();
    }


}
