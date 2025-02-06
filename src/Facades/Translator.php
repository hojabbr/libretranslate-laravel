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

    public static function translate($text, $source, $target, $format = 'text')
    {
        try {
            return static::getFacadeRoot()->translate($text, $source, $target, $format);
        } catch (\Exception $e) {
            // Optionally log the error or return a default error message
            return 'Error: ' . $e->getMessage();
        }
    }

    public static function detect($text)
    {
        try {
            return static::getFacadeRoot()->detect($text);
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public static function languages()
    {
        try {
            return static::getFacadeRoot()->languages();
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}