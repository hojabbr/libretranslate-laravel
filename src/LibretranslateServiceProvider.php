<?php

declare(strict_types=1);

namespace Hojabbr\LibretranslateLaravel;

use Illuminate\Support\ServiceProvider;

class LibretranslateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/libretranslate.php', 'libretranslate');

        $this->app->singleton(LibretranslateClient::class, function ($app) {
            return new LibretranslateClient(
                config('libretranslate.base_url'),
                config('libretranslate.api_key')
            );
        });

        $this->app->singleton(Translator::class, function ($app) {
            return new Translator($app->make(LibretranslateClient::class));
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/libretranslate.php' => config_path('libretranslate.php'),
        ], 'config');
    }
}
