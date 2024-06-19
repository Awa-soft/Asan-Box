<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OwnerableScope implements Scope
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
         if($this->user->ownerable_id){
            $builder->where('ownerable_id', $this->user->ownerable_id)
                ->where('ownerable_type', $this->user->ownerable_type);
         }
    }
}
