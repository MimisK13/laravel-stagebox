<?php

namespace Mimisk\Stagebox;

use Illuminate\Support\ServiceProvider;
use Mimisk\Stagebox\Commands\CleanOrphanStageboxesCommand;

class StageboxServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CleanOrphanStageboxesCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        // Register the service the package provides.
        $this->app->singleton('stagebox', function ($app) {
            return new Stagebox;
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['stagebox'];
    }
}
