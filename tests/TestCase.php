<?php

namespace Hojabbr\LibretranslateLaravel\Tests;

use Hojabbr\LibretranslateLaravel\LibretranslateServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LibretranslateServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('libretranslate.base_url', 'https://libretranslate.com');
        $app['config']->set('libretranslate.api_key', 'test-key');
    }
}