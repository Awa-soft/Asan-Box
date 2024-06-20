<?php

namespace App\Traits\Core;

trait HasTranslatableResource
{
    public static function getModelLabel(): string
    {
        return trans(static::getTranslatableAttributes()[0].'/lang.'.strtolower(static::getTranslatableAttributes()[1]).'.plural_label');
    }
    public static function getPluralModelLabel(): string
    {
        return trans(static::getTranslatableAttributes()[0].'/lang.'.strtolower(static::getTranslatableAttributes()[1]).'.singular_label');
    }
    public static function getNavigationGroup(): ?string
    {
        return trans(static::getTranslatableAttributes()[0].'/lang.group_label');
    }
    protected static function getTranslatableAttributes(): array{
        $model = explode('\\', self::getModel());
        return [$model[count($model) -2], static::snakeCase($model[count($model) -1])];
    }

   public static function snakeCase($value)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0',$value));
}
}
