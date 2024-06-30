<?php

namespace App\Traits\Core;

use Illuminate\Database\Eloquent\Model;

trait HasSoftDeletes
{
   public static function canSoftDelete():bool{
       return auth()->id() == 1;
   }
    public static function getActiveNavigationIcon(): ?string
    {
        return 'heroicon-s-check-badge'; // TODO: Change the autogenerated stub
    }
    public static function canForceDelete(Model $record): bool
    {
        return static::canSoftDelete();
    }
    public static function canRestore(Model $record): bool
    {
        return static::canSoftDelete();
    }
        public static function canDeleteAny(): bool
        {
            return static::canSoftDelete();
        }
    public static function canForceDeleteAny(): bool
    {
        return static::canSoftDelete();
    }
    public static function canRestoreAny(): bool
    {
        return static::canSoftDelete();
    }
}
