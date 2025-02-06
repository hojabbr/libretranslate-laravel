<?php

declare(strict_types=1);

namespace Hojabbr\LibretranslateLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Translator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Hojabbr\LibretranslateLaravel\Translator::class;
    }
}
