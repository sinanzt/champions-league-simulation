<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

trait AsAction
{
    public static function make()
    {
        return app(static::class);
    }

    public static function run(...$arguments)
    {
        return static::make()->handle(...$arguments);
    }

    public static function runIf($boolean, ...$arguments)
    {
        return $boolean ? static::run(...$arguments) : new Fluent;
    }

    public static function runUnless($boolean, ...$arguments)
    {
        return static::runIf(!$boolean, ...$arguments);
    }
}
